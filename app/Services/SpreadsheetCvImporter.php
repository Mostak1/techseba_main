<?php

namespace App\Services;

use App\Models\UserCv;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use ZipArchive;
use SimpleXMLElement;

class SpreadsheetCvImporter
{
    public function import($file, UserCv $cv): array
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $path = $file->getRealPath();

        $data = [];

        if ($extension === 'json') {
            $content = file_get_contents($path);
            $data = json_decode($content, true) ?: [];
        } elseif (in_array($extension, ['csv', 'txt'])) {
            $data = $this->parseCsv($path);
        } elseif (in_array($extension, ['xlsx', 'xls'])) {
            $data = $this->parseXlsx($path);
        } else {
            return ['status' => 'error', 'message' => 'Unsupported file format. Please upload CSV, XLSX, or JSON file.'];
        }

        if (empty($data)) {
            return ['status' => 'error', 'message' => 'Spreadsheet file appears empty or unparseable.'];
        }

        return $this->applyImportData($cv, $data);
    }

    public function parseCsv(string $path): array
    {
        $rows = [];
        if (($handle = fopen($path, 'r')) !== false) {
            $header = null;
            while (($row = fgetcsv($handle, 4096, ',')) !== false) {
                if (!$header) {
                    $header = array_map('trim', $row);
                } else {
                    if (count($row) === count($header)) {
                        $rows[] = array_combine($header, array_map('trim', $row));
                    }
                }
            }
            fclose($handle);
        }
        return $this->normalizeRows($rows);
    }

    public function parseXlsx(string $path): array
    {
        $zip = new ZipArchive();
        if ($zip->open($path) !== true) {
            return [];
        }

        // Shared Strings
        $sharedStrings = [];
        if (($sharedStringXml = $zip->getFromName('xl/sharedStrings.xml')) !== false) {
            $xml = new SimpleXMLElement($sharedStringXml);
            foreach ($xml->si as $val) {
                $sharedStrings[] = (string) ($val->t ?? $val->r->t ?? '');
            }
        }

        // Sheet 1
        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        $zip->close();

        if (!$sheetXml) {
            return [];
        }

        $xml = new SimpleXMLElement($sheetXml);
        $rows = [];

        foreach ($xml->sheetData->row as $row) {
            $rowData = [];
            foreach ($row->c as $cell) {
                $cellValue = (string) $cell->v;
                $cellType = (string) $cell['t'];

                if ($cellType === 's' && isset($sharedStrings[$cellValue])) {
                    $cellValue = $sharedStrings[$cellValue];
                }
                $rowData[] = trim($cellValue);
            }
            $rows[] = $rowData;
        }

        if (empty($rows)) {
            return [];
        }

        $header = array_map('trim', array_shift($rows));
        $normalized = [];

        foreach ($rows as $row) {
            if (empty(array_filter($row))) {
                continue;
            }
            $combined = [];
            foreach ($header as $index => $colName) {
                $combined[$colName] = $row[$index] ?? '';
            }
            $normalized[] = $combined;
        }

        return $this->normalizeRows($normalized);
    }

    private function normalizeRows(array $rows): array
    {
        if (empty($rows)) {
            return [];
        }

        // If it's a flat list of key-value rows or tabular format
        $firstRow = $rows[0];
        if (isset($firstRow['Key']) && isset($firstRow['Value'])) {
            $flat = [];
            foreach ($rows as $r) {
                $flat[trim($r['Key'])] = trim($r['Value']);
            }
            return $flat;
        }

        // If it has standard column headers (Full Name, Email, Mobile, etc.)
        $mainData = [];
        $projects = [];
        $employments = [];
        $skills = [];
        $academics = [];

        foreach ($rows as $r) {
            // Main Fields
            foreach (['full_name', 'Full Name', 'name'] as $k) {
                if (!empty($r[$k])) $mainData['full_name'] = $r[$k];
            }
            foreach (['email', 'Email'] as $k) {
                if (!empty($r[$k])) $mainData['email'] = $r[$k];
            }
            foreach (['mobile', 'Mobile', 'Phone', 'phone'] as $k) {
                if (!empty($r[$k])) $mainData['mobile'] = $r[$k];
            }
            foreach (['website_url', 'Website', 'website'] as $k) {
                if (!empty($r[$k])) $mainData['website_url'] = $r[$k];
            }
            foreach (['github_url', 'GitHub', 'github'] as $k) {
                if (!empty($r[$k])) $mainData['github_url'] = $r[$k];
            }
            foreach (['linkedin_url', 'LinkedIn', 'linkedin'] as $k) {
                if (!empty($r[$k])) $mainData['linkedin_url'] = $r[$k];
            }
            foreach (['career_objective', 'Career Objective', 'Objective'] as $k) {
                if (!empty($r[$k])) $mainData['career_objective'] = $r[$k];
            }
            foreach (['career_summary', 'Career Summary', 'Summary'] as $k) {
                if (!empty($r[$k])) $mainData['career_summary'] = $r[$k];
            }
            foreach (['technical_challenge', 'Technical Challenge'] as $k) {
                if (!empty($r[$k])) $mainData['technical_challenge'] = $r[$k];
            }
            foreach (['built_from_scratch', 'Built From Scratch'] as $k) {
                if (!empty($r[$k])) $mainData['built_from_scratch'] = $r[$k];
            }
            foreach (['sparks_joy', 'Sparks Joy'] as $k) {
                if (!empty($r[$k])) $mainData['sparks_joy'] = $r[$k];
            }

            // Projects in rows
            $pTitle = $r['Project Title'] ?? $r['project_title'] ?? $r['title'] ?? null;
            if ($pTitle) {
                $projects[] = [
                    'title' => $pTitle,
                    'link' => $r['Project Link'] ?? $r['link'] ?? null,
                    'demo_user' => $r['Demo User'] ?? $r['demo_user'] ?? null,
                    'demo_password' => $r['Demo Password'] ?? $r['demo_password'] ?? null,
                    'github_url' => $r['Project GitHub'] ?? $r['github_url'] ?? null,
                    'technologies' => $r['Project Tech Stack'] ?? $r['technologies'] ?? null,
                    'role' => $r['Project Role'] ?? $r['role'] ?? null,
                    'problem' => $r['Project Problem'] ?? $r['problem'] ?? null,
                    'solution' => $r['Project Solution'] ?? $r['solution'] ?? null,
                    'description' => $r['Project Description'] ?? $r['description'] ?? null,
                    'sort_order' => count($projects) + 1,
                ];
            }

            // Employments in rows
            $eCompany = $r['Company Name'] ?? $r['company_name'] ?? null;
            if ($eCompany) {
                $employments[] = [
                    'company_name' => $eCompany,
                    'designation' => $r['Designation'] ?? $r['designation'] ?? null,
                    'department' => $r['Department'] ?? $r['department'] ?? null,
                    'start_date' => $r['Start Date'] ?? $r['start_date'] ?? null,
                    'end_date' => $r['End Date'] ?? $r['end_date'] ?? null,
                    'is_current' => !empty($r['Is Current'] ?? $r['is_current'] ?? false),
                    'responsibilities' => $r['Responsibilities'] ?? $r['responsibilities'] ?? null,
                    'achievements' => $r['Achievements'] ?? $r['achievements'] ?? null,
                    'company_location' => $r['Company Location'] ?? $r['company_location'] ?? null,
                    'business_type' => $r['Business Type'] ?? $r['business_type'] ?? null,
                    'sort_order' => count($employments) + 1,
                ];
            }
        }

        return array_merge($mainData, [
            'projects' => $projects,
            'employments' => $employments,
        ]);
    }

    private function applyImportData(UserCv $cv, array $data): array
    {
        DB::transaction(function () use ($cv, $data) {
            $mainFields = [
                'full_name', 'email', 'mobile', 'website_url', 'github_url', 'linkedin_url',
                'career_objective', 'career_summary', 'technical_challenge', 'built_from_scratch', 'sparks_joy', 'total_experience'
            ];

            foreach ($mainFields as $field) {
                if (!empty($data[$field])) {
                    $cv->{$field} = $data[$field];
                }
            }

            if (!empty($data['proficiency_ratings']) && is_array($data['proficiency_ratings'])) {
                $cv->proficiency_ratings = array_merge($cv->proficiency_ratings ?: [], $data['proficiency_ratings']);
            }

            $cv->save();

            // Sync Projects if present
            if (!empty($data['projects']) && is_array($data['projects'])) {
                $cv->projects()->delete();
                $cv->projects()->createMany($data['projects']);
            }

            // Sync Employments if present
            if (!empty($data['employments']) && is_array($data['employments'])) {
                $cv->employments()->delete();
                $cv->employments()->createMany($data['employments']);
            }

            // Sync Skills if present
            if (!empty($data['skills']) && is_array($data['skills'])) {
                $cv->skills()->delete();
                $cv->skills()->createMany($data['skills']);
            }
        });

        return ['status' => 'success', 'message' => 'Digital CV and Portfolio data successfully imported from spreadsheet!'];
    }
}
