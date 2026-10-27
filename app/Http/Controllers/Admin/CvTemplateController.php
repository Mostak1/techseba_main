<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CvTemplate;
use App\Models\User;
use App\Models\UserCvTemplatePermission;
use App\Services\CvTemplateSyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CvTemplateController extends Controller
{
    public function index()
    {
        $templates = CvTemplate::withCount('cvs')->orderBy('id')->paginate(20);
        $pendingRequestsCount = UserCvTemplatePermission::where('status', 'pending')->count();

        return view('admin.cv-templates.index', compact('templates', 'pendingRequestsCount'));
    }

    public function create()
    {
        $template = new CvTemplate([
            'view_path' => 'frontend.cv.templates.',
            'is_active' => true,
        ]);

        return view('admin.cv-templates.form', compact('template'));
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        if (! view()->exists($validated['view_path'])) {
            return redirect()
                ->back()
                ->withInput()
                ->with(['message' => 'Template Blade view path does not exist.', 'alert-type' => 'error']);
        }

        if ($request->hasFile('preview_image')) {
            $validated['preview_image'] = $this->uploadPreview($request, $validated['name']);
        }

        $validated['is_active'] = $request->boolean('is_active');
        CvTemplate::create($validated);

        return redirect()
            ->route('admin.cv-templates.index')
            ->with(['message' => 'CV template created successfully', 'alert-type' => 'success']);
    }

    public function edit(CvTemplate $cvTemplate)
    {
        $template = $cvTemplate;

        return view('admin.cv-templates.form', compact('template'));
    }

    public function update(Request $request, CvTemplate $cvTemplate)
    {
        $validated = $this->validated($request, $cvTemplate);

        if (! view()->exists($validated['view_path'])) {
            return redirect()
                ->back()
                ->withInput()
                ->with(['message' => 'Template Blade view path does not exist.', 'alert-type' => 'error']);
        }

        if ($request->hasFile('preview_image')) {
            $this->deletePreview($cvTemplate->preview_image);
            $validated['preview_image'] = $this->uploadPreview($request, $validated['name']);
        }

        $validated['is_active'] = $request->boolean('is_active');
        $cvTemplate->update($validated);

        return redirect()
            ->route('admin.cv-templates.index')
            ->with(['message' => 'CV template updated successfully', 'alert-type' => 'success']);
    }

    public function preview(CvTemplate $cvTemplate)
    {
        $cv = new \App\Models\UserCv([
            'full_name' => 'John Doe',
            'mobile' => '+1234567890',
            'email' => 'john@example.com',
            'website_url' => 'https://linkedin.com/in/johndoe',
            'date_of_birth' => '1990-01-01',
            'gender' => 'Male',
            'marital_status' => 'Single',
            'nationality' => 'Bangladeshi',
            'religion' => 'Islam',
            'nid_or_passport' => '1234567890',
            'present_address' => 'House #12, Road #5, Dhanmondi R/A, Dhaka-1205, Bangladesh',
            'permanent_address' => 'Village: South Para, Post: Kaliganj, Upazila: Kaliganj, Dist: Lalmonirhat-5350',
            'career_objective' => 'To build a rewarding career in a dynamic organization where I can utilize my marketing knowledge, creativity and analytical skills to contribute to organizational growth and brand success while continuously enhancing my professional competencies.',
            'career_summary' => 'A result-oriented marketing professional with over 2 years of experience in brand promotion, digital marketing, campaign management and market analysis. Proven ability to develop and implement effective marketing strategies that drive customer engagement and business growth.',
            'total_experience' => 2.5,
            'declaration' => 'I hereby declare that the information provided in this resume is true, complete and correct to the best of my knowledge and belief. I understand that any false information may lead to disqualification or termination.',
            'declaration_date' => now(),
        ]);

        $cv->setRelation('template', $cvTemplate);
        
        $cv->setRelation('employments', collect([
            new \App\Models\CvEmployment([
                'company_name' => 'Acme Fashion Ltd.',
                'designation' => 'Marketing Executive',
                'department' => 'Marketing',
                'start_date' => '2023-01-01',
                'is_current' => true,
                'responsibilities' => "Develop and implement marketing plans and promotional campaigns.\nManage social media platforms and run paid advertising campaigns.\nConduct market research and competitor analysis.",
                'achievements' => "Increased Facebook engagement by 45% within 6 months.\nGenerated 30% more leads through targeted digital campaigns.",
            ]),
            new \App\Models\CvEmployment([
                'company_name' => 'Bright Solutions Ltd.',
                'designation' => 'Marketing Officer',
                'department' => 'Marketing',
                'start_date' => '2021-06-01',
                'end_date' => '2022-12-31',
                'is_current' => false,
                'responsibilities' => "Assisted in developing marketing strategies and promotional materials.\nManaged corporate social media and email marketing campaigns.",
                'achievements' => "Improved website traffic by 25% through SEO and content marketing.",
            ])
        ]));

        $cv->setRelation('academics', collect([
            new \App\Models\CvAcademic([
                'degree_name' => 'BBA (Marketing)',
                'institution' => 'Govt. Titumir College, Dhaka',
                'board_or_university' => 'National University',
                'passing_year' => '2020',
                'result' => '3.32 out of 4.00',
            ]),
            new \App\Models\CvAcademic([
                'degree_name' => 'HSC',
                'institution' => 'Notre Dame College, Dhaka',
                'board_or_university' => 'Dhaka Board',
                'passing_year' => '2016',
                'result' => '4.40 out of 5.00',
            ])
        ]));

        $cv->setRelation('trainings', collect([
            new \App\Models\CvTraining([
                'training_title' => 'Digital Marketing Professional Certification',
                'institute' => 'ICT Division, Bangladesh',
                'year' => '2023',
                'certificate_details' => 'Covered SEO, Social Media Marketing, Content Marketing, Email Marketing & Analytics.',
            ])
        ]));

        $cv->setRelation('skills', collect([
            new \App\Models\CvSkill(['skill_name' => 'Digital Marketing', 'skill_type' => 'Job-related Skills', 'skill_level' => 'Expert']),
            new \App\Models\CvSkill(['skill_name' => 'Social Media Management', 'skill_type' => 'Job-related Skills', 'skill_level' => 'Good']),
            new \App\Models\CvSkill(['skill_name' => 'Microsoft Office', 'skill_type' => 'Computer Skills', 'skill_level' => 'Excellent']),
            new \App\Models\CvSkill(['skill_name' => 'Google Analytics', 'skill_type' => 'Software Skills', 'skill_level' => 'Good']),
        ]));

        $cv->setRelation('languages', collect([
            new \App\Models\CvLanguage(['language_name' => 'Bangla', 'reading_level' => 'Native', 'writing_level' => 'Native', 'speaking_level' => 'Native']),
            new \App\Models\CvLanguage(['language_name' => 'English', 'reading_level' => 'Proficient', 'writing_level' => 'Proficient', 'speaking_level' => 'Proficient']),
        ]));

        $cv->setRelation('references', collect([
            new \App\Models\CvReference([
                'name' => 'Mr. Tamal Chandra Saha',
                'designation' => 'Marketing Manager',
                'organization' => 'Acme Fashion Ltd.',
                'phone' => '+880 1712 556 789',
                'email' => 'tamal.saha@acmefashion.com',
                'relationship' => 'Former Supervisor',
            ])
        ]));

        $cv->setRelation('projects', collect([
            new \App\Models\CvProject([
                'title' => 'Project One',
                'link' => 'https://github.com/example/one',
                'description' => 'A descriptive text about project one and its impact.',
            ]),
            new \App\Models\CvProject([
                'title' => 'Project Two',
                'link' => 'https://github.com/example/two',
                'description' => 'A descriptive text about project two and its impact.',
            ])
        ]));

        $viewPath = $cvTemplate->view_path;

        return view($viewPath, [
            'cv' => $cv,
            'showActions' => false,
            'printEnabled' => false,
            'pdfEnabled' => false,
            'printUrl' => null,
            'pdfUrl' => null,
            'printMode' => false,
            'forPdf' => false,
        ]);
    }

    public function destroy(CvTemplate $cvTemplate)
    {
        if ($cvTemplate->cvs()->exists()) {
            return redirect()
                ->back()
                ->with(['message' => 'This template is already used by one or more CVs.', 'alert-type' => 'error']);
        }

        $this->deletePreview($cvTemplate->preview_image);
        $cvTemplate->delete();

        return redirect()
            ->back()
            ->with(['message' => 'CV template deleted successfully', 'alert-type' => 'success']);
    }

    public function syncJson(CvTemplateSyncService $syncService)
    {
        $result = $syncService->syncFromJson();

        return redirect()
            ->back()
            ->with([
                'message' => $result['message'],
                'alert-type' => $result['success'] ? 'success' : 'error',
            ]);
    }

    public function permissions(Request $request)
    {
        $users = User::orderBy('name')->get(['id', 'name', 'email']);
        $templates = CvTemplate::orderBy('name')->get(['id', 'name', 'is_premium']);

        $query = UserCvTemplatePermission::with(['user', 'template'])->latest();

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $permissions = $query->paginate(20);
        $pendingCount = UserCvTemplatePermission::where('status', 'pending')->count();

        return view('admin.cv-templates.permissions', compact('permissions', 'users', 'templates', 'pendingCount'));
    }

    public function grantPermission(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'cv_template_id' => ['required', 'exists:cv_templates,id'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        UserCvTemplatePermission::updateOrCreate(
            [
                'user_id' => $validated['user_id'],
                'cv_template_id' => $validated['cv_template_id'],
            ],
            [
                'status' => 'active',
                'notes' => $validated['notes'] ?? 'Granted manually by Admin',
            ]
        );

        return redirect()
            ->back()
            ->with(['message' => 'Template permission granted successfully.', 'alert-type' => 'success']);
    }

    public function approvePermission($id)
    {
        $permission = UserCvTemplatePermission::findOrFail($id);
        $permission->update(['status' => 'active']);

        return redirect()
            ->back()
            ->with(['message' => 'Permission request approved successfully.', 'alert-type' => 'success']);
    }

    public function rejectPermission($id)
    {
        $permission = UserCvTemplatePermission::findOrFail($id);
        $permission->update(['status' => 'rejected']);

        return redirect()
            ->back()
            ->with(['message' => 'Permission request rejected.', 'alert-type' => 'info']);
    }

    public function revokePermission($id)
    {
        $permission = UserCvTemplatePermission::findOrFail($id);
        $permission->delete();

        return redirect()
            ->back()
            ->with(['message' => 'Permission revoked successfully.', 'alert-type' => 'success']);
    }

    public function togglePremium(CvTemplate $cvTemplate)
    {
        $cvTemplate->update(['is_premium' => ! $cvTemplate->is_premium]);

        return redirect()
            ->back()
            ->with(['message' => 'Template pricing status updated.', 'alert-type' => 'success']);
    }

    private function validated(Request $request, ?CvTemplate $template = null): array
    {
        $request->merge([
            'slug' => Str::slug($request->input('slug') ?: $request->input('name')),
        ]);

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('cv_templates', 'slug')->ignore($template?->id),
            ],
            'view_path' => ['required', 'string', 'max:255'],
            'preview_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
            'is_premium' => ['nullable', 'boolean'],
        ]);
    }

    private function uploadPreview(Request $request, string $name): string
    {
        $directory = 'uploads/cv/templates';
        File::ensureDirectoryExists(public_path($directory));

        $file = $request->file('preview_image');
        $filename = Str::slug($name).'-'.time().'-'.Str::random(8).'.'.$file->getClientOriginalExtension();
        $file->move(public_path($directory), $filename);

        return $directory.'/'.$filename;
    }

    private function deletePreview(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
