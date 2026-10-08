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
 * Single source of truth for template-gallery preview data.
 *
 * Builds an in-memory (never persisted) UserCv with every relation populated,
 * so every CV/portfolio Blade template can render a complete, realistic preview
 * without touching any real user's data.
 */
class CvPreviewDataService
{
    public const DEMO_USERNAME = 'alexjohnson';

    private ?UserCv $cached = null;

    public function make(): UserCv
    {
        if ($this->cached) {
            return $this->cached;
        }

        $cv = new UserCv;
        $cv->forceFill([
            'id' => 0,
            'full_name' => 'Alex Johnson',
            'father_name' => 'Michael Johnson',
            'mother_name' => 'Sarah Johnson',
            'date_of_birth' => '1998-04-12',
            'gender' => 'Male',
            'marital_status' => 'Single',
            'nationality' => 'American',
            'religion' => 'N/A',
            'nid_or_passport' => 'X12345678',
            'present_address' => 'New York, USA',
            'permanent_address' => '221 Example Street, Brooklyn, New York, USA',
            'mobile' => '+1 555 012 3456',
            'email' => 'alex@example.com',
            'website_url' => 'https://alexjohnson.dev',
            'github_url' => 'https://github.com/alexjohnson',
            'linkedin_url' => 'https://linkedin.com/in/alexjohnson',
            'photo' => null,
            'signature' => null,
            'career_objective' => 'To contribute to a forward-thinking engineering team by building reliable, scalable and user-focused web platforms while continuing to grow as a technical leader.',
            'career_summary' => 'Experienced software engineer with expertise in Laravel, PHP, JavaScript, cloud systems and scalable web applications. Passionate about clean architecture, performance optimization and mentoring developers.',
            'technical_challenge' => 'Re-architected a monolithic billing system into queue-driven services, reducing invoice generation time from 40 minutes to under 3 minutes.',
            'built_from_scratch' => 'Designed and launched a multi-tenant SaaS analytics dashboard serving 20k+ monthly active users.',
            'sparks_joy' => 'Turning complex business problems into simple, elegant interfaces and fast APIs.',
            'proficiency_ratings' => [
                'laravel' => 5, 'laravel_description' => 'Built and maintained 10+ production Laravel applications.',
                'php' => 5, 'php_description' => 'Strong OOP, SOLID and PSR standards.',
                'javascript' => 4, 'javascript_description' => 'Modern ES6+, jQuery, React and Vue.',
                'sql' => 4, 'sql_description' => 'Query optimization, indexing and schema design in MySQL.',
                'css' => 4, 'css_description' => 'Responsive, accessible UI with modern CSS.',
                'redis' => 3, 'redis_description' => 'Caching, queues and rate limiting with Redis.',
            ],
            'declaration' => 'I hereby declare that all the information provided above is true and correct to the best of my knowledge.',
            'declaration_date' => Carbon::now()->toDateString(),
            'is_public' => true,
            'public_print_enabled' => true,
            'public_pdf_enabled' => false,
        ]);

        $demoUser = new User;
        $demoUser->forceFill(['id' => 0, 'name' => 'Alex Johnson', 'username' => self::DEMO_USERNAME, 'email' => 'alex@example.com']);

        $cv->setRelation('user', $demoUser);
        $cv->setRelation('template', null);
        $cv->setRelation('portfolioTemplate', null);
        $cv->setRelation('employments', $this->employments());
        $cv->setRelation('academics', $this->academics());
        $cv->setRelation('trainings', $this->trainings());
        $cv->setRelation('professionalQualifications', $this->qualifications());
        $cv->setRelation('skills', $this->skills());
        $cv->setRelation('languages', $this->languages());
        $cv->setRelation('references', $this->references());
        $cv->setRelation('projects', $this->projects());

        $cv->total_experience = $cv->calculated_total_experience_years;

        return $this->cached = $cv;
    }

    private function collect(string $class, array $rows): Collection
    {
        return collect($rows)->values()->map(function (array $row, int $i) use ($class) {
            $model = new $class;
            $model->forceFill($row + ['id' => $i + 1, 'user_cv_id' => 0, 'sort_order' => $i]);

            return $model;
        });
    }

    private function employments(): Collection
    {
        return $this->collect(CvEmployment::class, [
            [
                'company_name' => 'TechNova Inc.',
                'designation' => 'Senior Software Engineer',
                'department' => 'Platform Engineering',
                'start_date' => '2023-01-01',
                'end_date' => null,
                'is_current' => true,
                'company_location' => 'New York, USA',
                'business_type' => 'SaaS / Cloud Software',
                'responsibilities' => "Lead a team of 5 engineers building a multi-tenant SaaS platform.\nDesign scalable REST APIs with Laravel, Redis and MySQL.\nOwn CI/CD pipelines with Docker and AWS.",
                'achievements' => 'Reduced average API response time by 62% and cut infrastructure cost by 30%.',
            ],
            [
                'company_name' => 'Example Labs',
                'designation' => 'Software Engineer',
                'department' => 'Product Development',
                'start_date' => '2021-02-01',
                'end_date' => '2022-12-31',
                'is_current' => false,
                'company_location' => 'Boston, USA',
                'business_type' => 'Software Agency',
                'responsibilities' => "Developed client web applications using Laravel and JavaScript.\nIntegrated payment gateways and third-party APIs.\nWrote automated tests and code reviews.",
                'achievements' => 'Delivered 12+ client projects on time with 98% client satisfaction.',
            ],
        ]);
    }

    private function academics(): Collection
    {
        return $this->collect(CvAcademic::class, [
            [
                'degree_name' => 'B.Sc. in Computer Science',
                'institution' => 'University of Example',
                'board_or_university' => 'University of Example',
                'group_or_major' => 'Software Engineering',
                'result' => 'CGPA 3.85 / 4.00',
                'passing_year' => '2021',
            ],
            [
                'degree_name' => 'Higher Secondary Certificate',
                'institution' => 'Example City College',
                'board_or_university' => 'State Education Board',
                'group_or_major' => 'Science',
                'result' => 'GPA 5.00 / 5.00',
                'passing_year' => '2017',
            ],
        ]);
    }

    private function trainings(): Collection
    {
        return $this->collect(CvTraining::class, [
            ['training_title' => 'AWS Cloud Practitioner Essentials', 'institute' => 'Amazon Web Services', 'duration' => '1 Month', 'year' => '2023', 'certificate_details' => 'Cloud fundamentals, IAM, EC2, S3 and billing.'],
            ['training_title' => 'Advanced Laravel & Clean Architecture', 'institute' => 'Laracasts', 'duration' => '6 Weeks', 'year' => '2022', 'certificate_details' => 'Domain-driven design, testing and queues.'],
        ]);
    }

    private function qualifications(): Collection
    {
        return $this->collect(CvProfessionalQualification::class, [
            ['title' => 'AWS Certified Developer – Associate', 'authority' => 'Amazon Web Services', 'result_or_score' => 'Passed', 'year' => '2024', 'details' => 'Serverless, DynamoDB and CI/CD on AWS.'],
            ['title' => 'Zend Certified PHP Engineer', 'authority' => 'Zend / Perforce', 'result_or_score' => 'Passed', 'year' => '2022', 'details' => 'Advanced PHP language and security.'],
        ]);
    }

    private function skills(): Collection
    {
        $technical = ['Laravel', 'PHP', 'JavaScript', 'MySQL', 'Docker', 'AWS', 'Git', 'Redis', 'REST APIs', 'Vue.js'];
        $soft = ['Team Leadership', 'Problem Solving', 'Communication', 'Mentoring'];

        $rows = [];
        foreach ($technical as $i => $name) {
            $rows[] = ['skill_type' => 'Technical Skills', 'skill_name' => $name, 'skill_level' => $i < 4 ? 'Expert' : 'Advanced'];
        }
        foreach ($soft as $name) {
            $rows[] = ['skill_type' => 'Soft Skills', 'skill_name' => $name, 'skill_level' => 'Advanced'];
        }

        return $this->collect(CvSkill::class, $rows);
    }

    private function languages(): Collection
    {
        return $this->collect(CvLanguage::class, [
            ['language_name' => 'English', 'reading_level' => 'Fluent', 'writing_level' => 'Fluent', 'speaking_level' => 'Fluent'],
            ['language_name' => 'Spanish', 'reading_level' => 'Intermediate', 'writing_level' => 'Intermediate', 'speaking_level' => 'Intermediate'],
        ]);
    }

    private function references(): Collection
    {
        return $this->collect(CvReference::class, [
            ['name' => 'Dr. Emily Carter', 'designation' => 'Engineering Director', 'organization' => 'TechNova Inc.', 'phone' => '+1 555 010 2020', 'email' => 'emily.carter@example.com', 'relationship' => 'Line Manager'],
            ['name' => 'Prof. David Lee', 'designation' => 'Professor, Computer Science', 'organization' => 'University of Example', 'phone' => '+1 555 010 3030', 'email' => 'david.lee@example.com', 'relationship' => 'Academic Supervisor'],
        ]);
    }

    private function projects(): Collection
    {
        return $this->collect(CvProject::class, [
            [
                'title' => 'CloudLedger – SaaS Accounting Platform',
                'link' => 'https://example.com/cloudledger',
                'github_url' => 'https://github.com/alexjohnson/cloudledger',
                'technologies' => 'Laravel, Vue.js, MySQL, Redis, AWS',
                'role' => 'Lead Backend Engineer',
                'problem' => 'Small businesses struggled with slow, manual invoicing and reconciliation.',
                'solution' => 'Built a multi-tenant accounting platform with automated invoicing and bank sync.',
                'description' => 'Multi-tenant accounting SaaS used by 1,500+ small businesses.',
                'image' => null, 'demo_user' => null, 'demo_password' => null,
            ],
            [
                'title' => 'ShopSphere – E-commerce Engine',
                'link' => 'https://example.com/shopsphere',
                'github_url' => 'https://github.com/alexjohnson/shopsphere',
                'technologies' => 'Laravel, Livewire, Stripe, Docker',
                'role' => 'Full-Stack Developer',
                'problem' => 'Merchants needed a fast, customizable storefront with reliable payments.',
                'solution' => 'Delivered a modular e-commerce engine with Stripe payments and inventory sync.',
                'description' => 'Headless-ready e-commerce engine handling 50k+ orders per month.',
                'image' => null, 'demo_user' => null, 'demo_password' => null,
            ],
            [
                'title' => 'MediTrack – Clinic Management System',
                'link' => 'https://example.com/meditrack',
                'github_url' => 'https://github.com/alexjohnson/meditrack',
                'technologies' => 'PHP, Laravel, jQuery, MySQL',
                'role' => 'Software Engineer',
                'problem' => 'Clinics relied on paper records causing appointment conflicts.',
                'solution' => 'Created an appointment, patient record and billing system with SMS reminders.',
                'description' => 'Clinic management system adopted by 40+ clinics.',
                'image' => null, 'demo_user' => null, 'demo_password' => null,
            ],
            [
                'title' => 'DevPulse – Engineering Analytics Dashboard',
                'link' => 'https://example.com/devpulse',
                'github_url' => 'https://github.com/alexjohnson/devpulse',
                'technologies' => 'Laravel, Chart.js, GitHub API, Redis',
                'role' => 'Creator',
                'problem' => 'Teams lacked visibility into delivery speed and code review bottlenecks.',
                'solution' => 'Built a dashboard aggregating GitHub metrics into actionable insights.',
                'description' => 'Open-source analytics dashboard with 1.2k GitHub stars.',
                'image' => null, 'demo_user' => null, 'demo_password' => null,
            ],
        ]);
    }
}
