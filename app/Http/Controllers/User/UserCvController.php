<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCvRequest;
use App\Models\CvTemplate;
use App\Models\PortfolioTemplate;
use App\Models\UserCv;
use App\Services\CvSourceExtractor;
use App\Services\SpreadsheetCvImporter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UserCvController extends Controller
{
    private array $relations = [
        'template',
        'portfolioTemplate',
        'employments',
        'academics',
        'trainings',
        'professionalQualifications',
        'skills',
        'languages',
        'references',
        'projects',
    ];

    private array $mainFields = [
        'template_id',
        'portfolio_template_id',
        'full_name',
        'father_name',
        'mother_name',
        'date_of_birth',
        'gender',
        'marital_status',
        'nationality',
        'religion',
        'nid_or_passport',
        'present_address',
        'permanent_address',
        'mobile',
        'email',
        'website_url',
        'career_objective',
        'career_summary',
        'technical_challenge',
        'built_from_scratch',
        'proficiency_ratings',
        'sparks_joy',
        'landing_page_url',
        'total_experience',
        'declaration',
        'declaration_date',
    ];

    public function edit()
    {
        $user = Auth::guard('web')->user();
        $cv = $user->userCv()->with($this->relations)->first();
        $templates = CvTemplate::where('is_active', true)->orderBy('name')->get();
        $portfolioTemplates = PortfolioTemplate::where('is_active', true)->orderBy('name')->get();

        return view('user.cv.edit', compact('user', 'cv', 'templates', 'portfolioTemplates'));
    }

    public function update(UserCvRequest $request, CvSourceExtractor $extractor)
    {
        $user = Auth::guard('web')->user();
        $validated = $request->validated();
        $cv = null;

        DB::transaction(function () use ($request, $validated, $user, &$cv) {
            $cv = UserCv::firstOrNew(['user_id' => $user->id]);
            $cv->fill(Arr::only($validated, $this->mainFields));
            $cv->is_public = $request->boolean('is_public');
            $cv->public_print_enabled = $request->boolean('public_print_enabled');
            $cv->public_pdf_enabled = false;

            if ($request->hasFile('photo')) {
                $this->deleteFile($cv->photo);
                $cv->photo = $this->uploadFile($request->file('photo'), 'uploads/cv/photos', $validated['full_name']);
            }

            if ($request->hasFile('signature')) {
                $this->deleteFile($cv->signature);
                $cv->signature = $this->uploadFile($request->file('signature'), 'uploads/cv/signatures', $validated['full_name'].' signature');
            }

            if ($request->hasFile('source_file')) {
                $this->deleteFile($cv->source_file);
                $sourceFile = $request->file('source_file');
                $cv->source_file = $this->uploadFile($sourceFile, 'uploads/cv/source-files', $validated['full_name'].' source cv');
                $cv->source_file_original_name = $sourceFile->getClientOriginalName();
            }

            $cv->save();
            $this->syncChildren($cv, $validated);
        });

        if ($request->boolean('extract_source')) {
            return $this->extractSourceAndRedirect($cv, $extractor);
        }

        $tab = $request->input('next_tab') ?: $request->input('active_tab', 'personal');

        return redirect()
            ->route('user.cv.edit', ['tab' => $tab])
            ->with(['message' => trans('translate.Updated successfully'), 'alert-type' => 'success']);
    }

    public function preview()
    {
        $cv = $this->ownerCv();

        return $this->renderCv($cv, [
            'showActions' => true,
            'printEnabled' => true,
            'pdfEnabled' => true,
            'printUrl' => route('user.cv.print'),
            'pdfUrl' => route('user.cv.pdf'),
            'printMode' => false,
            'forPdf' => false,
        ]);
    }

    public function portfolioPreview()
    {
        $user = Auth::guard('web')->user();
        $cv = $this->ownerCv();

        return view($this->portfolioViewPath($cv), [
            'cv' => $cv,
            'username' => $user->username,
            'cvUrl' => route('user.cv.preview'),
            'printUrl' => route('user.cv.print'),
            'pdfUrl' => route('user.cv.pdf'),
            'printEnabled' => true,
            'pdfEnabled' => true,
        ]);
    }

    public function print()
    {
        $cv = $this->ownerCv();

        return $this->renderCv($cv, [
            'showActions' => true,
            'printEnabled' => true,
            'pdfEnabled' => true,
            'printUrl' => route('user.cv.print'),
            'pdfUrl' => route('user.cv.pdf'),
            'printMode' => true,
            'forPdf' => false,
        ]);
    }

    public function pdf()
    {
        $cv = $this->ownerCv();
        $viewPath = $this->viewPath($cv);
        $filename = Str::slug($cv->full_name ?: 'digital').'-cv.pdf';

        return Pdf::loadView($viewPath, $this->viewData($cv, [
            'showActions' => false,
            'printEnabled' => false,
            'pdfEnabled' => false,
            'printUrl' => null,
            'pdfUrl' => null,
            'printMode' => false,
            'forPdf' => true,
        ]))
            ->setOptions($this->pdfOptions(), true)
            ->setPaper('a4', 'portrait')
            ->download($filename);
    }

    public function importSpreadsheet(Request $request, SpreadsheetCvImporter $importer)
    {
        $request->validate([
            'spreadsheet_file' => 'required|file|mimes:csv,xlsx,xls,json,txt|max:10240',
        ]);

        $user = Auth::guard('web')->user();
        $cv = UserCv::firstOrCreate(['user_id' => $user->id]);

        $result = $importer->import($request->file('spreadsheet_file'), $cv);

        return redirect()
            ->route('user.cv.edit', ['tab' => 'upload'])
            ->with([
                'message' => $result['message'],
                'alert-type' => $result['status'] === 'success' ? 'success' : 'error',
            ]);
    }

    public function exportSpreadsheet()
    {
        $cv = $this->ownerCv();

        $exportData = [
            'full_name' => $cv->full_name,
            'email' => $cv->email,
            'mobile' => $cv->mobile,
            'website_url' => $cv->website_url,
            'github_url' => $cv->github_url,
            'linkedin_url' => $cv->linkedin_url,
            'career_objective' => $cv->career_objective,
            'career_summary' => $cv->career_summary,
            'technical_challenge' => $cv->technical_challenge,
            'built_from_scratch' => $cv->built_from_scratch,
            'sparks_joy' => $cv->sparks_joy,
            'proficiency_ratings' => $cv->proficiency_ratings,
            'employments' => $cv->employments->toArray(),
            'projects' => $cv->projects->toArray(),
            'academics' => $cv->academics->toArray(),
            'trainings' => $cv->trainings->toArray(),
            'skills' => $cv->skills->toArray(),
        ];

        $filename = Str::slug($cv->full_name ?: 'my-portfolio').'-data-sheet.json';

        return response()->streamDownload(function () use ($exportData) {
            echo json_encode($exportData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }, $filename, ['Content-Type' => 'application/json']);
    }

    public function downloadSampleSpreadsheet(Request $request)
    {
        $format = strtolower($request->query('format', 'csv'));

        if ($format === 'csv') {
            $csvPath = public_path('samples/sample-portfolio-template.csv');
            if (File::exists($csvPath)) {
                return response()->download($csvPath, 'sample-portfolio-template.csv', ['Content-Type' => 'text/csv']);
            }
        }

        $sampleData = [
            'full_name' => 'Md. Mostak Ahmed',
            'email' => 'mostakidb@gmail.com',
            'mobile' => '+8801752243665',
            'website_url' => 'https://mostaksarker.com',
            'github_url' => 'https://github.com/Mostak1',
            'linkedin_url' => 'https://linkedin.com/in/mostaksarker',
            'career_objective' => 'To architect enterprise Laravel web applications...',
            'career_summary' => 'Senior Full-Stack Laravel Developer / DevOps Engineer...',
            'technical_challenge' => 'Modular architecture and real-time cash register audit...',
            'built_from_scratch' => 'MessMeal multi-tenant PWA and Fluento EdTech platform...',
            'sparks_joy' => 'Linux server administration and acoustic guitar...',
            'projects' => [
                [
                    'title' => 'Carenet ERP — Healthcare Platform',
                    'link' => 'https://mostak.awcbd.org',
                    'demo_user' => 'demoadmin',
                    'demo_password' => '123456',
                    'role' => 'Senior Full-Stack Developer',
                    'technologies' => 'Laravel 10, MySQL, Redis, Passport, Docker',
                    'problem' => 'Fragmented clinical and lab workflows...',
                    'solution' => 'Architected modular system with nwidart/laravel-modules...',
                    'description' => 'Enterprise healthcare platform unifying clinical care...'
                ]
            ]
        ];

        return response()->streamDownload(function () use ($sampleData) {
            echo json_encode($sampleData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }, 'sample-portfolio-spreadsheet.json', ['Content-Type' => 'application/json']);
    }

    private function ownerCv(): UserCv
    {
        return Auth::guard('web')->user()
            ->userCv()
            ->with($this->relations)
            ->firstOrFail();
    }

    private function extractSourceAndRedirect(UserCv $cv, CvSourceExtractor $extractor)
    {
        if (! $cv->source_file || ! File::exists(public_path($cv->source_file))) {
            return redirect()
                ->route('user.cv.edit', ['tab' => 'upload'])
                ->with(['message' => 'Please upload a PDF or image first.', 'alert-type' => 'error']);
        }

        $result = $extractor->extract(public_path($cv->source_file), $cv->source_file_original_name);

        DB::transaction(function () use ($cv, $result) {
            $cv->source_text = $result['text'] ?: null;
            $cv->source_extract_status = $result['status'];
            $cv->source_extracted_at = now();
            $this->applyExtractedData($cv, $result['data'] ?? []);
            $cv->save();
        });

        $messages = $result['messages'] ?? [];
        $message = $result['status'] === 'success'
            ? 'CV data extracted and inserted into empty fields. Please review before saving final changes.'
            : 'Could not extract readable text from this file. '.implode(' ', $messages);

        return redirect()
            ->route('user.cv.edit', ['tab' => $result['status'] === 'success' ? 'personal' : 'upload'])
            ->with([
                'message' => $message,
                'alert-type' => $result['status'] === 'success' ? 'success' : 'error',
            ]);
    }

    private function applyExtractedData(UserCv $cv, array $data): void
    {
        $this->fillIfBlank($cv, 'full_name', $data['full_name'] ?? null);
        $this->fillIfBlank($cv, 'email', $data['email'] ?? null);
        $this->fillIfBlank($cv, 'mobile', $data['mobile'] ?? null);
        $this->fillIfBlank($cv, 'website_url', $data['website_url'] ?? null);
        $this->fillIfBlank($cv, 'github_url', $data['github_url'] ?? null);
        $this->fillIfBlank($cv, 'linkedin_url', $data['linkedin_url'] ?? null);
        $this->fillIfBlank($cv, 'career_objective', $data['career_objective'] ?? null);
        $this->fillIfBlank($cv, 'career_summary', $data['career_summary'] ?? null);
        $this->fillIfBlank($cv, 'present_address', $data['present_address'] ?? null);
        $this->fillIfBlank($cv, 'permanent_address', $data['permanent_address'] ?? null);

        if (! empty($data['skills']) && $cv->skills()->doesntExist()) {
            $cv->skills()->createMany($data['skills']);
        }

        if (! empty($data['academics']) && $cv->academics()->doesntExist()) {
            $cv->academics()->createMany($data['academics']);
        }

        if (! empty($data['trainings']) && $cv->trainings()->doesntExist()) {
            $cv->trainings()->createMany($data['trainings']);
        }

        if (! empty($data['projects']) && $cv->projects()->doesntExist()) {
            $cv->projects()->createMany($data['projects']);
        }
    }

    private function fillIfBlank(UserCv $cv, string $field, ?string $value): void
    {
        if ($value !== null && $value !== '' && blank($cv->{$field})) {
            $cv->{$field} = $value;
        }
    }

    private function syncChildren(UserCv $cv, array $validated): void
    {
        $cv->employments()->delete();
        $cv->employments()->createMany($this->rows($validated['employments'] ?? [], [
            'company_name',
            'designation',
            'department',
            'start_date',
            'end_date',
            'is_current',
            'responsibilities',
            'achievements',
            'company_location',
            'business_type',
        ], ['is_current']));

        $cv->academics()->delete();
        $cv->academics()->createMany($this->rows($validated['academics'] ?? [], [
            'degree_name',
            'institution',
            'board_or_university',
            'group_or_major',
            'result',
            'passing_year',
        ]));

        $cv->trainings()->delete();
        $cv->trainings()->createMany($this->rows($validated['trainings'] ?? [], [
            'training_title',
            'institute',
            'duration',
            'year',
            'certificate_details',
        ]));

        $cv->professionalQualifications()->delete();
        $cv->professionalQualifications()->createMany($this->rows($validated['professional_qualifications'] ?? [], [
            'title',
            'authority',
            'result_or_score',
            'year',
            'details',
        ]));

        $cv->skills()->delete();
        $cv->skills()->createMany($this->rows($validated['skills'] ?? [], [
            'skill_type',
            'skill_name',
            'skill_level',
        ]));

        $cv->languages()->delete();
        $cv->languages()->createMany($this->rows($validated['languages'] ?? [], [
            'language_name',
            'reading_level',
            'writing_level',
            'speaking_level',
        ]));

        $cv->references()->delete();
        $cv->references()->createMany($this->rows($validated['references'] ?? [], [
            'name',
            'designation',
            'organization',
            'phone',
            'email',
            'relationship',
        ]));
    }

    private function rows(array $rows, array $fields, array $booleanFields = []): array
    {
        $cleanRows = [];

        foreach (array_values($rows) as $row) {
            $clean = Arr::only($row, $fields);

            foreach ($booleanFields as $field) {
                $clean[$field] = ! empty($row[$field]);
            }

            if (($clean['is_current'] ?? false) === true) {
                $clean['end_date'] = null;
            }

            $hasContent = collect($clean)
                ->except($booleanFields)
                ->contains(fn ($value) => $value !== null && $value !== '');

            if ($hasContent) {
                $clean['sort_order'] = count($cleanRows);
                $cleanRows[] = $clean;
            }
        }

        return $cleanRows;
    }

    private function uploadFile($file, string $directory, string $name): string
    {
        File::ensureDirectoryExists(public_path($directory));

        $filename = Str::slug($name).'-'.time().'-'.Str::random(8).'.'.$file->getClientOriginalExtension();
        $file->move(public_path($directory), $filename);

        return $directory.'/'.$filename;
    }

    private function deleteFile(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }

    private function renderCv(UserCv $cv, array $options)
    {
        return view($this->viewPath($cv), $this->viewData($cv, $options));
    }

    private function viewData(UserCv $cv, array $options): array
    {
        return array_merge(['cv' => $cv], $options);
    }

    private function viewPath(UserCv $cv): string
    {
        $viewPath = $cv->template?->view_path ?: 'frontend.cv.templates.bdjobs';

        return view()->exists($viewPath) ? $viewPath : 'frontend.cv.templates.bdjobs';
    }

    private function portfolioViewPath(UserCv $cv): string
    {
        $viewPath = $cv->portfolioTemplate?->is_active
            ? $cv->portfolioTemplate->view_path
            : 'frontend.cv.portfolio';

        return view()->exists($viewPath) ? $viewPath : 'frontend.cv.portfolio';
    }

    private function pdfOptions(): array
    {
        return [
            'defaultMediaType' => 'screen',
            'defaultFont' => 'DejaVu Sans',
            'dpi' => 96,
            'isHtml5ParserEnabled' => true,
            'chroot' => base_path(),
        ];
    }
}
