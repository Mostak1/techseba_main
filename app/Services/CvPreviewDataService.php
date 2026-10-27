<?php

namespace App\Services;

use App\Models\CvAcademic;
use App\Models\CvEmployment;
use App\Models\CvLanguage;
use App\Models\CvProfessionalQualification;
use App\Models\CvProject;
use App\Models\CvReference;
use App\Models\CvSkill;
use App\Models\CvTraining;
use App\Models\User;
use App\Models\UserCv;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Single source of truth for template preview data.
 *
 * Loads rich dummy CV data from database/data/cv_dummy_data.json,
 * and creates an in-memory UserCv instance with all relations populated.
 */
class CvPreviewDataService
{
    public const DEMO_USERNAME = 'mostak';

    private ?UserCv $cached = null;

    public function make(): UserCv
    {
        if ($this->cached) {
            return $this->cached;
        }

        $jsonFile = database_path('data/cv_dummy_data.json');
        if (file_exists($jsonFile)) {
            $raw = json_decode(file_get_contents($jsonFile), true);
            if (is_array($raw) && !empty($raw['basic'])) {
                return $this->cached = $this->buildFromJson($raw);
            }
        }

        return $this->cached = $this->buildFallback();
    }

    /**
     * Merge user CV with dummy data if certain relations are empty.
     */
    public function mergeWithDummyIfEmpty(?UserCv $userCv): UserCv
    {
        if (! $userCv) {
            return $this->make();
        }

        $dummy = $this->make();

        // If user has no name or email, use dummy basic fields
        if (empty($userCv->full_name)) {
            $userCv->full_name = $dummy->full_name;
        }
        if (empty($userCv->career_objective)) {
            $userCv->career_objective = $dummy->career_objective;
        }
        if (empty($userCv->career_summary)) {
            $userCv->career_summary = $dummy->career_summary;
        }
        if (empty($userCv->present_address)) {
            $userCv->present_address = $dummy->present_address;
        }
        if (empty($userCv->mobile)) {
            $userCv->mobile = $dummy->mobile;
        }
        if (empty($userCv->email)) {
            $userCv->email = $dummy->email;
        }

        // Child relations fallback if user has none
        if ($userCv->employments->isEmpty()) {
            $userCv->setRelation('employments', $dummy->employments);
        }
        if ($userCv->academics->isEmpty()) {
            $userCv->setRelation('academics', $dummy->academics);
        }
        if ($userCv->trainings->isEmpty()) {
            $userCv->setRelation('trainings', $dummy->trainings);
        }
        if ($userCv->professionalQualifications->isEmpty()) {
            $userCv->setRelation('professionalQualifications', $dummy->professionalQualifications);
        }
        if ($userCv->skills->isEmpty()) {
            $userCv->setRelation('skills', $dummy->skills);
        }
        if ($userCv->projects->isEmpty()) {
            $userCv->setRelation('projects', $dummy->projects);
        }
        if ($userCv->languages->isEmpty()) {
            $userCv->setRelation('languages', $dummy->languages);
        }
        if ($userCv->references->isEmpty()) {
            $userCv->setRelation('references', $dummy->references);
        }

        return $userCv;
    }

    private function buildFromJson(array $data): UserCv
    {
        $cv = new UserCv;
        $basic = $data['basic'] ?? [];
        $basic['id'] = 0;
        $basic['is_public'] = true;
        $basic['public_print_enabled'] = true;
        $basic['public_pdf_enabled'] = false;

        $cv->forceFill($basic);

        $demoUser = new User;
        $demoUser->forceFill([
            'id' => 0,
            'name' => $basic['full_name'] ?? 'Md. Mostak Ahmed',
            'username' => self::DEMO_USERNAME,
            'email' => $basic['email'] ?? 'mostakidb@gmail.com',
            'image' => $basic['photo'] ?? null,
        ]);

        $cv->setRelation('user', $demoUser);
        $cv->setRelation('template', null);
        $cv->setRelation('portfolioTemplate', null);
        $cv->setRelation('employments', $this->collect(CvEmployment::class, $data['employments'] ?? []));
        $cv->setRelation('academics', $this->collect(CvAcademic::class, $data['academics'] ?? []));
        $cv->setRelation('trainings', $this->collect(CvTraining::class, $data['trainings'] ?? []));
        $cv->setRelation('professionalQualifications', $this->collect(CvProfessionalQualification::class, $data['professional_qualifications'] ?? []));
        $cv->setRelation('skills', $this->collect(CvSkill::class, $data['skills'] ?? []));
        $cv->setRelation('languages', $this->collect(CvLanguage::class, $data['languages'] ?? []));
        $cv->setRelation('references', $this->collect(CvReference::class, $data['references'] ?? []));
        $cv->setRelation('projects', $this->collect(CvProject::class, $data['projects'] ?? []));

        $cv->total_experience = $basic['total_experience'] ?? $cv->calculated_total_experience_years;

        return $cv;
    }

    private function buildFallback(): UserCv
    {
        $cv = new UserCv;
        $cv->forceFill([
            'id' => 0,
            'full_name' => 'Md. Mostak Ahmed',
            'father_name' => 'Md. Mofizul Islam',
            'mother_name' => 'Most. Morium Begum',
            'date_of_birth' => '1996-08-15',
            'gender' => 'Male',
            'marital_status' => 'Married',
            'nationality' => 'Bangladeshi',
            'religion' => 'Islam',
            'nid_or_passport' => '5509238471',
            'present_address' => 'Dhanmondi, Dhaka, Bangladesh',
            'permanent_address' => 'Lalmonirhat, Bangladesh',
            'mobile' => '+8801752243665',
            'email' => 'mostakidb@gmail.com',
            'website_url' => 'https://techseba.com',
            'photo' => 'uploads/website-images/avatar-image-2024-07-02-10-08-24-5849.png',
            'career_objective' => 'To contribute as a Lead Software Engineer.',
            'career_summary' => 'Experienced Laravel Engineer with 6+ years of expertise in full-stack architecture.',
            'declaration' => 'All information provided is true and authentic.',
            'declaration_date' => Carbon::now()->toDateString(),
            'is_public' => true,
            'public_print_enabled' => true,
            'public_pdf_enabled' => false,
        ]);

        $demoUser = new User;
        $demoUser->forceFill(['id' => 0, 'name' => 'Md. Mostak Ahmed', 'username' => self::DEMO_USERNAME, 'email' => 'mostakidb@gmail.com']);
        $cv->setRelation('user', $demoUser);
        $cv->setRelation('employments', collect());
        $cv->setRelation('academics', collect());
        $cv->setRelation('trainings', collect());
        $cv->setRelation('professionalQualifications', collect());
        $cv->setRelation('skills', collect());
        $cv->setRelation('languages', collect());
        $cv->setRelation('references', collect());
        $cv->setRelation('projects', collect());

        return $cv;
    }

    private function collect(string $class, array $rows): Collection
    {
        return collect($rows)->values()->map(function (array $row, int $i) use ($class) {
            $model = new $class;
            $model->forceFill($row + ['id' => $i + 1, 'user_cv_id' => 0, 'sort_order' => $i]);

            return $model;
        });
    }
}
