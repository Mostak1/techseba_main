<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserCvRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('web')->check();
    }

    public function rules(): array
    {
        return [
            'template_id' => ['required', Rule::exists('cv_templates', 'id')->where('is_active', 1)],
            'portfolio_template_id' => ['nullable', Rule::exists('portfolio_templates', 'id')->where('is_active', 1)],
            'full_name' => ['required', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'max:50'],
            'marital_status' => ['nullable', 'string', 'max:50'],
            'nationality' => ['nullable', 'string', 'max:100'],
            'religion' => ['nullable', 'string', 'max:100'],
            'nid_or_passport' => ['nullable', 'string', 'max:100'],
            'present_address' => ['nullable', 'string', 'max:2000'],
            'permanent_address' => ['nullable', 'string', 'max:2000'],
            'mobile' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'website_url' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'career_objective' => ['nullable', 'string', 'max:2000'],
            'career_summary' => ['nullable', 'string', 'max:3000'],
            'total_experience' => ['nullable', 'numeric', 'min:0', 'max:99.99'],
            'declaration' => ['nullable', 'string', 'max:2000'],
            'signature' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            'declaration_date' => ['nullable', 'date'],
            'is_public' => ['nullable', 'boolean'],
            'public_print_enabled' => ['nullable', 'boolean'],
            'public_pdf_enabled' => ['nullable', 'boolean'],

            'employments' => ['nullable', 'array'],
            'employments.*.company_name' => ['nullable', 'string', 'max:255'],
            'employments.*.designation' => ['nullable', 'string', 'max:255'],
            'employments.*.department' => ['nullable', 'string', 'max:255'],
            'employments.*.start_date' => ['nullable', 'date'],
            'employments.*.end_date' => ['nullable', 'date'],
            'employments.*.is_current' => ['nullable', 'boolean'],
            'employments.*.responsibilities' => ['nullable', 'string', 'max:5000'],
            'employments.*.achievements' => ['nullable', 'string', 'max:5000'],
            'employments.*.company_location' => ['nullable', 'string', 'max:255'],
            'employments.*.business_type' => ['nullable', 'string', 'max:255'],

            'academics' => ['nullable', 'array'],
            'academics.*.degree_name' => ['nullable', 'string', 'max:255'],
            'academics.*.institution' => ['nullable', 'string', 'max:255'],
            'academics.*.board_or_university' => ['nullable', 'string', 'max:255'],
            'academics.*.group_or_major' => ['nullable', 'string', 'max:255'],
            'academics.*.result' => ['nullable', 'string', 'max:100'],
            'academics.*.passing_year' => ['nullable', 'string', 'max:20'],

            'trainings' => ['nullable', 'array'],
            'trainings.*.training_title' => ['nullable', 'string', 'max:255'],
            'trainings.*.institute' => ['nullable', 'string', 'max:255'],
            'trainings.*.duration' => ['nullable', 'string', 'max:100'],
            'trainings.*.year' => ['nullable', 'string', 'max:20'],
            'trainings.*.certificate_details' => ['nullable', 'string', 'max:3000'],

            'professional_qualifications' => ['nullable', 'array'],
            'professional_qualifications.*.title' => ['nullable', 'string', 'max:255'],
            'professional_qualifications.*.authority' => ['nullable', 'string', 'max:255'],
            'professional_qualifications.*.result_or_score' => ['nullable', 'string', 'max:100'],
            'professional_qualifications.*.year' => ['nullable', 'string', 'max:20'],
            'professional_qualifications.*.details' => ['nullable', 'string', 'max:3000'],

            'skills' => ['nullable', 'array'],
            'skills.*.skill_type' => ['nullable', 'string', 'max:100'],
            'skills.*.skill_name' => ['nullable', 'string', 'max:255'],
            'skills.*.skill_level' => ['nullable', 'string', 'max:100'],

            'languages' => ['nullable', 'array'],
            'languages.*.language_name' => ['nullable', 'string', 'max:100'],
            'languages.*.reading_level' => ['nullable', 'string', 'max:100'],
            'languages.*.writing_level' => ['nullable', 'string', 'max:100'],
            'languages.*.speaking_level' => ['nullable', 'string', 'max:100'],

            'references' => ['nullable', 'array'],
            'references.*.name' => ['nullable', 'string', 'max:255'],
            'references.*.designation' => ['nullable', 'string', 'max:255'],
            'references.*.organization' => ['nullable', 'string', 'max:255'],
            'references.*.phone' => ['nullable', 'string', 'max:100'],
            'references.*.email' => ['nullable', 'email', 'max:255'],
            'references.*.relationship' => ['nullable', 'string', 'max:255'],
        ];
    }
}
