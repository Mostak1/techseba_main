<?php

namespace App\Services;

use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use Throwable;

class CvSourceExtractor
{
    private array $sectionHeaders = [
        'career objective',
        'career summary',
        'profile summary',
        'professional summary',
        'employment history',
        'work experience',
        'experience',
        'academic qualification',
        'education',
        'training',
        'certification',
        'skills',
        'technical skills',
        'key skills',
        'projects',
        'personal information',
        'reference',
        'references',
        'declaration',
    ];

    public function extract(string $path, ?string $originalName = null): array
    {
        $extension = strtolower(pathinfo($originalName ?: $path, PATHINFO_EXTENSION));
        $messages = [];
        $text = '';

        if ($extension === 'pdf') {
            $text = $this->extractPdfText($path, $messages);
        } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true)) {
            $text = $this->extractImageText($path, $messages);
        } else {
            $messages[] = 'Unsupported file type.';
        }

        $text = $this->cleanText($text);
        $data = $text ? $this->parseCvData($text) : [];

        return [
            'text' => $text,
            'data' => $data,
            'status' => $text ? 'success' : 'failed',
            'messages' => $messages,
        ];
    }

    private function extractPdfText(string $path, array &$messages): string
    {
        $text = $this->runProcess([env('PDFTOTEXT_BINARY', 'pdftotext'), '-layout', $path, '-']);

        if ($text !== '') {
            $messages[] = 'PDF text extracted with pdftotext.';

            return $text;
        }

        $messages[] = 'pdftotext is not available or returned no text; using internal PDF text extractor.';

        return $this->extractPdfTextInternally($path);
    }

    private function extractImageText(string $path, array &$messages): string
    {
        $text = $this->runProcess([env('TESSERACT_BINARY', 'tesseract'), $path, 'stdout', '-l', env('TESSERACT_LANG', 'eng')]);

        if ($text !== '') {
            $messages[] = 'Image text extracted with Tesseract.';

            return $text;
        }

        $messages[] = 'Image OCR needs Tesseract installed on the server. PDF text extraction works without it for text-based PDFs.';

        return '';
    }

    private function runProcess(array $command): string
    {
        try {
            $process = new Process($command);
            $process->setTimeout(30);
            $process->run();

            return $process->isSuccessful() ? trim($process->getOutput()) : '';
        } catch (Throwable) {
            return '';
        }
    }

    private function extractPdfTextInternally(string $path): string
    {
        $contents = @file_get_contents($path);

        if ($contents === false) {
            return '';
        }

        $text = [];

        preg_match_all('/(<<.*?>>)\s*stream\s*(.*?)\s*endstream/s', $contents, $streams, PREG_SET_ORDER);

        foreach ($streams as $stream) {
            $dictionary = $stream[1] ?? '';
            $data = $stream[2] ?? '';
            $data = preg_replace('/^\r?\n/', '', $data);
            $data = preg_replace('/\r?\n$/', '', $data);

            if (str_contains($dictionary, '/FlateDecode')) {
                $decoded = @gzuncompress($data);
                $decoded = $decoded === false ? @gzdecode($data) : $decoded;
                $decoded = $decoded === false ? @gzinflate(substr($data, 2, -4)) : $decoded;
                $data = $decoded === false ? $data : $decoded;
            }

            $text[] = $this->extractTextOperators($data);
        }

        return implode("\n", array_filter($text));
    }

    private function extractTextOperators(string $data): string
    {
        $parts = [];

        preg_match_all('/BT(.*?)ET/s', $data, $blocks);

        foreach ($blocks[1] ?? [] as $block) {
            preg_match_all('/\((?:\\\\.|[^\\\\()])*\)\s*Tj/s', $block, $simpleStrings);

            foreach ($simpleStrings[0] ?? [] as $operator) {
                if (preg_match('/\(((?:\\\\.|[^\\\\()])*)\)\s*Tj/s', $operator, $match)) {
                    $parts[] = $this->decodePdfString($match[1]);
                }
            }

            preg_match_all('/\[(.*?)\]\s*TJ/s', $block, $arrayStrings);

            foreach ($arrayStrings[1] ?? [] as $arrayText) {
                preg_match_all('/\((?:\\\\.|[^\\\\()])*\)|<([0-9A-Fa-f\s]+)>/s', $arrayText, $items);

                foreach ($items[0] ?? [] as $item) {
                    if (str_starts_with($item, '(')) {
                        $parts[] = $this->decodePdfString(substr($item, 1, -1));
                    } elseif (preg_match('/<([0-9A-Fa-f\s]+)>/', $item, $hex)) {
                        $parts[] = $this->decodeHexString($hex[1]);
                    }
                }
            }

            preg_match_all('/<([0-9A-Fa-f\s]+)>\s*Tj/s', $block, $hexStrings);

            foreach ($hexStrings[1] ?? [] as $hex) {
                $parts[] = $this->decodeHexString($hex);
            }
        }

        return trim(preg_replace('/\s+/', ' ', implode(' ', array_filter($parts))));
    }

    private function decodePdfString(string $value): string
    {
        $value = preg_replace_callback('/\\\\([0-7]{1,3})/', fn ($match) => chr(octdec($match[1])), $value);
        $value = strtr($value, [
            '\n' => "\n",
            '\r' => "\r",
            '\t' => "\t",
            '\b' => '',
            '\f' => '',
            '\(' => '(',
            '\)' => ')',
            '\\\\' => '\\',
        ]);

        return $value;
    }

    private function decodeHexString(string $value): string
    {
        $hex = preg_replace('/\s+/', '', $value);

        if ($hex === '') {
            return '';
        }

        if (strlen($hex) % 2 !== 0) {
            $hex .= '0';
        }

        $binary = @hex2bin($hex);

        if ($binary === false) {
            return '';
        }

        if (str_starts_with($binary, "\xfe\xff") || substr_count($binary, "\x00") > 0) {
            $utf16 = @mb_convert_encoding($binary, 'UTF-8', 'UTF-16BE');

            return $utf16 ?: $binary;
        }

        return $binary;
    }

    private function cleanText(string $text): string
    {
        $text = str_replace(["\r\n", "\r"], "\n", $text);
        $text = preg_replace('/[ \t]+/', ' ', $text);
        $text = preg_replace('/\n{3,}/', "\n\n", $text);

        return trim($text);
    }

    private function parseCvData(string $text): array
    {
        $lines = collect(preg_split('/\n+/', $text))
            ->map(fn ($line) => trim($line, " \t\n\r\0\x0B:-|"))
            ->filter()
            ->values();

        $data = [
            'full_name' => $this->guessName($lines->all()),
            'email' => $this->firstMatch('/[A-Z0-9._%+\-]+@[A-Z0-9.\-]+\.[A-Z]{2,}/i', $text),
            'mobile' => $this->firstMatch('/(?:\+?88)?\s*01[3-9][\s.\-]?\d{3}[\s.\-]?\d{4}/', $text),
            'website_url' => $this->firstMatch('/https?:\/\/(?!github\.com|www\.github\.com|linkedin\.com|www\.linkedin\.com)[^\s<>)]+/i', $text),
            'github_url' => $this->firstMatch('/https?:\/\/(?:www\.)?github\.com\/[^\s<>)]+/i', $text),
            'linkedin_url' => $this->firstMatch('/https?:\/\/(?:www\.)?linkedin\.com\/[^\s<>)]+/i', $text),
            'career_objective' => $this->section($text, ['career objective', 'objective']),
            'career_summary' => $this->section($text, ['career summary', 'profile summary', 'professional summary', 'summary']),
            'present_address' => $this->address($lines->all(), 'present'),
            'permanent_address' => $this->address($lines->all(), 'permanent'),
            'skills' => $this->skills($text),
            'academics' => $this->academics($lines->all()),
            'trainings' => $this->trainings($text),
            'projects' => $this->projects($text),
        ];

        return array_filter($data, fn ($value) => $value !== null && $value !== '' && $value !== []);
    }

    private function guessName(array $lines): ?string
    {
        foreach (array_slice($lines, 0, 10) as $line) {
            $lower = strtolower($line);

            if (preg_match('/@|\d{4,}|curriculum|resume|vitae|mobile|phone|email|address|developer|engineer|officer|manager/', $lower)) {
                continue;
            }

            if (preg_match('/^[a-z .\'-]{3,80}$/i', $line) && str_word_count($line) <= 6) {
                return Str::title(strtolower($line));
            }
        }

        return null;
    }

    private function firstMatch(string $pattern, string $text): ?string
    {
        return preg_match($pattern, $text, $match) ? trim($match[0], " \t\n\r\0\x0B.,;") : null;
    }

    private function section(string $text, array $headers): ?string
    {
        $lines = preg_split('/\n+/', $text);
        $capture = false;
        $buffer = [];

        foreach ($lines as $line) {
            $clean = trim($line);
            $lower = strtolower(trim($clean, " :-|"));

            if ($capture && $this->isSectionHeader($lower, $headers)) {
                break;
            }

            if (! $capture && in_array($lower, $headers, true)) {
                $capture = true;
                continue;
            }

            if ($capture && $clean !== '') {
                $buffer[] = $clean;
            }
        }

        $value = trim(implode("\n", array_slice($buffer, 0, 8)));

        return $value !== '' ? Str::limit($value, 2000, '') : null;
    }

    private function isSectionHeader(string $line, array $currentHeaders = []): bool
    {
        if (in_array($line, $currentHeaders, true)) {
            return false;
        }

        return in_array($line, $this->sectionHeaders, true);
    }

    private function address(array $lines, string $type): ?string
    {
        foreach ($lines as $line) {
            if (preg_match('/'.$type.'\s+address\s*:?\s*(.+)$/i', $line, $match)) {
                return Str::limit(trim($match[1]), 2000, '');
            }
        }

        return null;
    }

    private function skills(string $text): array
    {
        $section = $this->section($text, ['skills', 'technical skills', 'key skills', 'computer skills', 'software skills']);

        if (! $section) {
            return [];
        }

        return collect(preg_split('/[,;|\n]+/', $section))
            ->map(fn ($skill) => trim($skill, " \t\n\r\0\x0B-*•:"))
            ->filter(fn ($skill) => $skill !== '' && strlen($skill) <= 120)
            ->unique()
            ->take(30)
            ->map(fn ($skill, $index) => [
                'skill_name' => $skill,
                'skill_type' => 'Technical Skills',
                'skill_level' => null,
                'sort_order' => $index,
            ])
            ->values()
            ->all();
    }

    private function academics(array $lines): array
    {
        $academics = [];

        foreach ($lines as $line) {
            if (! preg_match('/\b(ssc|hsc|bachelor|b\.?s\.?s|b\.?s\.?c|bba|mba|masters|honours|diploma|degree)\b/i', $line)) {
                continue;
            }

            $academics[] = [
                'degree_name' => Str::limit(trim($line), 255, ''),
                'institution' => null,
                'board_or_university' => null,
                'group_or_major' => null,
                'result' => $this->firstMatch('/(?:CGPA|GPA)\s*[:\-]?\s*[0-9.]+/i', $line),
                'passing_year' => $this->firstMatch('/\b(?:19|20)\d{2}\b/', $line),
                'sort_order' => count($academics),
            ];

            if (count($academics) >= 6) {
                break;
            }
        }

        return $academics;
    }

    private function trainings(string $text): array
    {
        $section = $this->section($text, ['training', 'trainings', 'certification', 'certifications']);

        if (! $section) {
            return [];
        }

        return collect(preg_split('/\n+/', $section))
            ->map(fn ($line) => trim($line, " \t\n\r\0\x0B-*•:"))
            ->filter()
            ->take(8)
            ->map(fn ($line, $index) => [
                'training_title' => Str::limit($line, 255, ''),
                'institute' => null,
                'duration' => null,
                'year' => $this->firstMatch('/\b(?:19|20)\d{2}\b/', $line),
                'certificate_details' => $line,
                'sort_order' => $index,
            ])
            ->values()
            ->all();
    }

    private function projects(string $text): array
    {
        $section = $this->section($text, ['projects', 'project']);

        if (! $section) {
            return [];
        }

        return collect(preg_split('/\n+/', $section))
            ->map(fn ($line) => trim($line, " \t\n\r\0\x0B-*•:"))
            ->filter()
            ->take(10)
            ->map(fn ($line, $index) => [
                'title' => Str::limit(preg_replace('/https?:\/\/\S+/i', '', $line), 255, ''),
                'link' => $this->firstMatch('/https?:\/\/[^\s<>)]+/i', $line),
                'description' => $line,
                'sort_order' => $index,
            ])
            ->values()
            ->all();
    }
}
