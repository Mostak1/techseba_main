<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCvRequest;
use App\Models\CvTemplate;
use App\Models\PortfolioTemplate;
use App\Models\UserCv;
use Barryvdh\DomPDF\Facade\Pdf;
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

    public function update(UserCvRequest $request)
    {
        $user = Auth::guard('web')->user();
        $validated = $request->validated();

        DB::transaction(function () use ($request, $validated, $user) {
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

            $cv->save();
            $this->syncChildren($cv, $validated);
        });

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

    private function ownerCv(): UserCv
    {
        return Auth::guard('web')->user()
            ->userCv()
            ->with($this->relations)
            ->firstOrFail();
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
