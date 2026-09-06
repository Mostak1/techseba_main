<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserCv;
use App\Models\CvTemplate;
use App\Models\CvEmployment;
use App\Models\CvAcademic;
use App\Models\CvTraining;
use App\Models\CvSkill;
use App\Models\CvLanguage;
use App\Models\CvReference;
use App\Models\PortfolioTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserCvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    // 1. Ensure we have a template
    $template = CvTemplate::firstOrCreate(
        ['slug' => 'modern'],
        [
            'name' => 'Modern Professional',
            'view_path' => 'frontend.cv.templates.modern',
            'is_active' => true
        ]
    );

    $portfolioTemplate = PortfolioTemplate::updateOrCreate(
        ['slug' => 'modern'],
        [
            'name' => 'Modern Portfolio',
            'preview_image' => null,
            'view_path' => 'frontend.cv.portfolio',
            'is_active' => true,
        ]
    );

    PortfolioTemplate::updateOrCreate(
        ['slug' => 'classic'],
        [
            'name' => 'Classic Portfolio',
            'preview_image' => null,
            'view_path' => 'frontend.cv.portfolio_classic',
            'is_active' => true,
        ]
    );

    $applicationPortfolio = PortfolioTemplate::updateOrCreate(
        ['slug' => 'application'],
        [
            'name' => 'Application Portfolio',
            'preview_image' => null,
            'view_path' => 'frontend.cv.portfolio_application',
            'is_active' => true,
        ]
    );

    // 2. Find or create user from PDF data
    $user = User::where('email', 'mostakidb@gmail.com')
        ->orWhere('email', 'mdmostaka@gmail.com')
        ->orWhere('phone', '01834160283')
        ->first();

    if (!$user) {
        $user = User::create([
            'name' => 'Md. Mostak Ahmed',
            'username' => 'mostak',
            'email' => 'mostakidb@gmail.com',
            'phone' => '+8801752243665',
            'password' => Hash::make('password'),
            'status' => 1,
            'is_banned' => 0,
        ]);
    } else {
        $user->update([
            'name' => 'Md. Mostak Ahmed',
            'username' => $user->username ?: 'mostak',
            'email' => 'mostakidb@gmail.com',
            'phone' => '+8801752243665',
        ]);
    }

    // 3. Create / update main CV record
    $cv = UserCv::updateOrCreate(
        ['user_id' => $user->id],
        [
            'template_id' => $template->id,
            'portfolio_template_id' => $applicationPortfolio->id,

            'full_name' => 'Md. Mostak Ahmed',
            'father_name' => 'Md. Abdul Motin Sarker',
            'mother_name' => 'Mst. Samima Akthar',
            'date_of_birth' => '1997-03-06',
            'gender' => 'Male',
            'marital_status' => null,
            'nationality' => 'Bangladeshi',
            'religion' => null,
            'nid_or_passport' => '8254920997',

            'present_address' => '273/7, Shenpara Parbata, Mirpur-10, Dhaka-1216',
            'permanent_address' => 'Vill: Khuniagach; Post: Kalmati-5500; Thana & Zilla: Lalmonirhat.',

            'mobile' => '+8801752243665',
            'email' => 'mostakidb@gmail.com',
            'website_url' => 'https://mostaksarker.com',
            'github_url' => 'https://github.com/Mostak1',
            'linkedin_url' => 'https://linkedin.com/in/mostaksarker',

            'career_objective' => 'To architect and deliver high-performance, secure, and scalable enterprise web applications in a Senior Full-Stack / Lead Engineer role, driving backend architecture, API design, DevOps automation, and server-side analytics.',

            'career_summary' => 'Senior Full-Stack Laravel Developer & Team Lead with 4.5+ years of experience engineering high-performance enterprise ERP, POS, Healthcare, and multi-tenant SaaS platforms. Expert in Laravel architecture, RESTful API design, Vue.js, MySQL schema optimization, Rocky Linux DevOps, and server-side tracking analytics (Meta CAPI / GTM). Proven track record leading development teams, driving system scalability, and automating production deployments.',

            'total_experience' => 4.5,

            // Application Questionnaire Fields
            'technical_challenge' => "At Carenet ERP and TechSeba POS & ERP, I architected complex enterprise solutions across high-volume business domains:\n\n1. **Modular Healthcare & POS Architecture**: Designed modular Laravel architectures using `nwidart/laravel-modules` across 15+ business domains (Clinical care, LIS analyzer device ingestion, inventory, HRM, POS cash-register audit).\n\n2. **Serial & IMEI Lifecycle Tracking**: Architected unit-level tracking across purchases, warehouse stock, transfers, POS sales, returns, and repair workflows with status history and overselling controls.\n\n3. **Cash-Register Audit & Financial Reporting**: Built opening/closing sessions, denomination breakdowns, and real-time transaction aggregation using optimized `SUM(CASE WHEN ...)` SQL queries.\n\n4. **Device & Automated Ingestion Pipelines**: Integrated laboratory diagnostic analyzer data using parser-to-API pipelines and connected ZKTeco biometric attendance devices.\n\n5. **Performance & Security**: Implemented OAuth2 authentication with Laravel Passport, granular RBAC via Spatie Permission, Redis caching, eager loading, composite indexes, and server-side DataTables for high-volume transactions.",

            'built_from_scratch' => "Yes — I have engineered multiple enterprise platforms from scratch, including MessMeal (Multi-Tenant PWA), Fluento (EdTech & IELTS Platform), and TechSeba SaaS:\n\n1. **MessMeal Shared-Database Multi-Tenancy**: Built a multi-tenant financial PWA using `mess_id`, custom `BelongsToMess` global scopes, active-context session switching, 6-state expense review workflow, and PHP `BCMath` 4-decimal precision accounting to prevent floating-point financial errors.\n\n2. **Fluento EdTech & IELTS Assessment Engine**: Architected an IELTS mock-exam engine with dynamic reading passages, custom listening audio, writing submission scoring, drip course releases, and automated certificate generation using Spatie Browsershot/Puppeteer & DomPDF.\n\n3. **Server-Side Marketing Analytics Infrastructure**: Implemented server-side event tracking across Meta Conversions API (CAPI), TikTok Events API, and GA4 Measurement Protocol using Google Tag Manager (GTM) containers and custom website events.",

            'proficiency_ratings' => [
                'laravel' => 5,
                'laravel_description' => 'Expert in Laravel (v10, v11, v12, v13). Proficient in Eloquent ORM, nwidart/laravel-modules, Passport OAuth2, middleware, queues/jobs, service providers, Inertia.js, and multi-tenant architectures.',
                'php' => 5,
                'php_description' => 'Daily PHP 8.2+ development. Proficient in OOP, BCMath precise accounting, design patterns (Service Layer, Repository), PSR standards, and Composer package management.',
                'javascript' => 4,
                'javascript_description' => 'Strong experience with Vue.js (Vue 2.7 & Vue 3 Composition API), React.js, Alpine.js, Axios, and building installable PWAs with Vite & Workbox.',
                'sql' => 5,
                'sql_description' => 'Expert in MySQL/MariaDB relational schema design, complex joins, indexing, aggregate reporting (SUM CASE WHEN), and transaction isolation.',
                'linux_devops' => 5,
                'linux_devops_description' => 'Rocky Linux production server administration, Virtualmin multi-domain hosting, Let\'s Encrypt SSL/TLS automation, Nginx/PHP-FPM, Docker, and GitHub Actions CI/CD workflows.',
                'analytics' => 5,
                'analytics_description' => 'End-to-end marketing event tracking: Google Tag Manager (GTM), Meta Pixel, Meta Conversions API (CAPI), TikTok Events API, GA4 Measurement Protocol, and Meta Dataset integration.',
                'css' => 4,
                'css_description' => 'Modern responsive CSS, Tailwind CSS (v3 & v4), Bootstrap 5, BootstrapVue, Flexbox/Grid layouts, and custom design systems.',
            ],

            'sparks_joy' => "🐧 **Linux Server Administration & DevOps**: Provisioning Rocky Linux production environments, Virtualmin multi-domain virtual servers, and automating Let's Encrypt SSL certificates.\n\n📊 **Server-Side Tracking & Analytics**: Building robust Meta Conversions API (CAPI) and Google Tag Manager (GTM) event pipelines that bridge client-side user actions with server-side conversion datasets.\n\n🎸 **Creative Reset**: Playing acoustic guitar after coding sessions and mentoring junior developers in web engineering and Linux concepts.",

            'landing_page_url' => 'https://subscribepage.io/mostak-portfolio',

            'declaration' => 'I hereby declare that the information provided in this CV is true and correct to the best of my knowledge and belief.',
            'declaration_date' => now(),

            'is_public' => true,
            'public_print_enabled' => true,
            'public_pdf_enabled' => false,
        ]
    );

    // 4. Clear existing details to avoid duplicates if seeder is re-run
    $cv->employments()->delete();
    $cv->academics()->delete();
    $cv->trainings()->delete();

    if (method_exists($cv, 'professionalQualifications')) {
        $cv->professionalQualifications()->delete();
    }

    $cv->skills()->delete();
    $cv->languages()->delete();
    $cv->references()->delete();

    if (method_exists($cv, 'projects')) {
        $cv->projects()->delete();
    }

    // 5. Employment History (Actual Work Experience)
    $cv->employments()->createMany([
        [
            'company_name' => 'American Wellness Centre',
            'designation' => 'Team Leader of Software Developer',
            'department' => 'Software Engineering',
            'start_date' => '2023-09-01',
            'end_date' => null,
            'is_current' => true,
            'responsibilities' => 'Leading software development team, architecting enterprise healthcare & modular web applications, code review, system design, API architecture, and database optimization.',
            'achievements' => 'Currently working as Team Leader of Software Developer at American Wellness Centre since September 2023.',
            'company_location' => 'Dhaka, Bangladesh',
            'business_type' => 'Healthcare & IT Services',
            'sort_order' => 1,
        ],
        [
            'company_name' => 'Genuity Systems Ltd.',
            'designation' => 'Software Developer (Internship)',
            'department' => 'Software Development',
            'start_date' => '2023-03-01',
            'end_date' => '2023-08-31',
            'is_current' => false,
            'responsibilities' => 'Completed 6-month intensive software developer internship. Developed web applications using PHP, Laravel, and JavaScript; assisted in database design, API integrations, and bug fixes.',
            'achievements' => 'Completed 6-month (March to August 2023) internship as a Software Developer at Genuity Systems Ltd.',
            'company_location' => 'Dhaka, Bangladesh',
            'business_type' => 'Software Development & IT Solutions',
            'sort_order' => 2,
        ],
        [
            'company_name' => 'Bank Asia Agent Banking',
            'designation' => 'Customer Service Officer (CSO)',
            'department' => 'Operations & Customer Service',
            'start_date' => '2020-04-01',
            'end_date' => '2021-12-31',
            'is_current' => false,
            'responsibilities' => 'Customer service, account management, daily financial transaction processing, agent banking operations, customer issue resolution, and transaction reporting.',
            'achievements' => 'Worked as Customer Service Officer (CSO) at Bank Asia Agent Banking, Borobari, Lalmonirhat from April 2020 to December 2021.',
            'company_location' => 'Borobari, Lalmonirhat, Bangladesh',
            'business_type' => 'Banking & Financial Services',
            'sort_order' => 3,
        ],
        [
            'company_name' => 'Flood Relief Voluntary Initiative 2019',
            'designation' => 'Voluntary Team Lead / Organizer',
            'department' => 'Community Service',
            'start_date' => '2019-07-01',
            'end_date' => '2019-09-30',
            'is_current' => false,
            'responsibilities' => 'Organized community fundraising, emergency supply logistics, and relief distribution for flood-affected families.',
            'achievements' => 'Arranged relief distribution for 525 flood-affected people in 2019.',
            'company_location' => 'Lalmonirhat, Bangladesh',
            'business_type' => 'Social Welfare & Community Service',
            'sort_order' => 4,
        ],
    ]);

    // 6. Academic Qualifications
    $cv->academics()->createMany([
        [
            'degree_name' => 'Bachelor of Social Science',
            'institution' => 'Dhaka Commerce College',
            'board_or_university' => 'National University',
            'group_or_major' => 'Economics',
            'result' => 'CGPA 3.05',
            'passing_year' => null,
            'sort_order' => 1,
        ],
        [
            'degree_name' => 'H.S.C.',
            'institution' => 'Lalmonirhat Govt. College',
            'board_or_university' => 'Dinajpur Board',
            'group_or_major' => 'Science',
            'result' => 'GPA 4.20',
            'passing_year' => '2014',
            'sort_order' => 2,
        ],
        [
            'degree_name' => 'S.S.C.',
            'institution' => 'Church Of God High School, Lalmonirhat',
            'board_or_university' => 'Dinajpur Board',
            'group_or_major' => 'Science',
            'result' => 'GPA 4.81',
            'passing_year' => '2012',
            'sort_order' => 3,
        ],
    ]);

    // 7. Training / Certification
    $cv->trainings()->createMany([
        [
            'training_title' => 'IT PGD - Web Application Development',
            'institute' => 'IsDB-BISEW IT Scholarship Programme',
            'duration' => '1 Year',
            'year' => '2023',
            'certificate_details' => 'Completed IT Postgraduate Diploma in Web Application Development covering PHP, Laravel, JavaScript, React.js, CodeIgniter, MySQL, and Linux deployment.',
            'sort_order' => 1,
        ],
        [
            'training_title' => 'Rocky Linux & Virtualmin Administration',
            'institute' => 'DevOps & Systems Training',
            'duration' => 'Practical',
            'year' => '2024',
            'certificate_details' => 'Production server provisioning, Virtualmin control plane setup, multi-domain hosting configuration, Let\'s Encrypt SSL/TLS automation, and Nginx/PHP-FPM web server delivery.',
            'sort_order' => 2,
        ],
        [
            'training_title' => 'Meta CAPI, Pixel & Google Tag Manager Integration',
            'institute' => 'Analytics & Tracking Mastery',
            'duration' => 'Practical',
            'year' => '2024',
            'certificate_details' => 'Browser & server-side event tracking, Meta Conversions API (CAPI), GTM container architecture, custom data layer events, and Meta Dataset integration.',
            'sort_order' => 3,
        ],
    ]);

    // 8. Projects (Updated from RockyLinux Master HTML Profile)
    $cv->projects()->createMany([
        [
            'title' => 'Carenet ERP — Healthcare & Modular Business Platform',
            'link' => 'https://mostak.awcbd.org',
            'demo_user' => 'demoadmin',
            'demo_password' => '123456',
            'github_url' => 'https://github.com/Mostak1/Carenet_ERP',
            'technologies' => 'PHP, Laravel 10, Laravel Modules, MySQL, Redis, Passport OAuth2, Spatie Permission, REST API, DataTables, Docker, Nginx, ZKTeco Integration',
            'role' => 'Senior Full-Stack Laravel Developer / Core Module Architect',
            'problem' => 'Centralized fragmented clinical and business workflows previously dependent on paper intake, manual lab results, isolated branch inventory, and manual attendance processing.',
            'solution' => 'Designed modular architecture using nwidart/laravel-modules across 15+ business domains. Built LIS laboratory analyzer ingestion pipelines, ZKTeco biometric integration, Passport OAuth2 RBAC, Redis caching, composite indexes, and server-side DataTables.',
            'description' => 'Enterprise healthcare platform unifying clinical care, diagnostics, inventory, finance, HRM, assets, and multi-location operations.',
            'sort_order' => 1,
        ],
        [
            'title' => 'TechSeba Main — Digital Agency & Service SaaS Platform',
            'link' => 'https://techseba.com',
            'demo_user' => null,
            'demo_password' => null,
            'github_url' => 'https://github.com/Mostak1/techseba_main',
            'technologies' => 'PHP, Laravel 10, MySQL, Blade, Tailwind CSS, Stripe, Payment Gateways, SaaS Architecture',
            'role' => 'Full-Stack Laravel Developer / Product Engineer',
            'problem' => 'Agencies and freelance service providers struggled to manage commercial workflows, client payments, and portfolio presentations across disconnected tools.',
            'solution' => 'Constructed a commercial SaaS platform combining service operations, online payment processing, client project delivery, and dynamic portfolio generation.',
            'description' => 'Commercial SaaS product for agencies and freelancers, combining service management, billing, online payments, and dynamic portfolio creation.',
            'sort_order' => 2,
        ],
        [
            'title' => 'TechSeba — Enterprise POS & ERP System',
            'link' => 'https://pos.techseba.com',
            'demo_user' => 'admin@gmail.com',
            'demo_password' => '12345678',
            'github_url' => 'https://github.com/Mostak1/TechSeba_POS',
            'technologies' => 'PHP 8.2+, Laravel 12, Vue.js 2.7, Vuex, Vue Router, MySQL, Passport OAuth2, Tailwind CSS, BootstrapVue, GitHub Actions',
            'role' => 'Senior Full-Stack Laravel & Vue.js Developer / Lead Software Engineer',
            'problem' => 'Multi-location retail businesses needed a unified system for unit-level IMEI/serial tracking, cash register session audit, double-entry accounting, repair tickets, and e-commerce sync.',
            'solution' => 'Architected unit-level serial/IMEI lifecycle tracking across purchases, transfers, and POS sales. Built cash register session audits with real-time variance reporting (SUM CASE WHEN), double-entry accounting, Passport OAuth2 APIs, and GitHub Actions CI/CD deployment.',
            'description' => 'Enterprise inventory, POS, double-entry accounting, HRM/payroll, repair ticket, and multi-location business management platform.',
            'sort_order' => 3,
        ],
        [
            'title' => 'MessMeal — Mess Meal & Expense Management SaaS PWA',
            'link' => 'https://mess.techseba.com',
            'demo_user' => null,
            'demo_password' => null,
            'github_url' => 'https://github.com/Mostak1/MessMeal',
            'technologies' => 'PHP 8.3, Laravel 13, Vue 3, Inertia.js, Tailwind CSS v4, MySQL, BCMath, Vite 8, PWA, Workbox',
            'role' => 'Full-Stack Laravel & Vue.js Engineer / Lead Architect',
            'problem' => 'Residential mess communities faced calculation disputes, retroactive expense tampering, and inaccurate floating-point currency calculations in daily meal accounting.',
            'solution' => 'Architected shared-database multi-tenancy using BelongsToMess global scopes, 6-state expense review workflow, PHP BCMath 4-decimal precision accounting, and an installable PWA with Vite & Workbox offline support.',
            'description' => 'Cloud-based multi-tenant PWA for daily meals, bazar expenses, member deposits, live meal rates, and closed-period monthly accounting.',
            'sort_order' => 4,
        ],
        [
            'title' => 'Fluento — Enterprise EdTech & IELTS Platform',
            'link' => 'https://fluento.org/',
            'demo_user' => null,
            'demo_password' => null,
            'github_url' => 'https://github.com/Mostak1/Fluento',
            'technologies' => 'PHP 8.2+, Laravel 11, MySQL, Blade, Tailwind CSS, Alpine.js, Vite 5, Laravel Queues, Spatie Browsershot, Puppeteer, DomPDF, Meta CAPI, TikTok Events API',
            'role' => 'Senior Laravel / Full-Stack Developer',
            'problem' => 'Educational institutes used separate disconnected tools for course video streaming, IELTS mock testing, physical book sales, certificate generation, and marketing analytics.',
            'solution' => 'Unified live/recorded drip course releases, IELTS mock-exam engine (reading, listening, writing scoring), Spatie Browsershot PDF certificate builder, multi-gateway billing (Stripe, PayPal, Razorpay), and Meta CAPI / TikTok Events API server-side tracking.',
            'description' => 'Enterprise platform unifying online learning, IELTS testing, e-commerce, automated certificates, gamification, instructor payouts, and server-side marketing analytics.',
            'sort_order' => 5,
        ],
    ]);

    // 9. Technical Skills (US Recruiter-Friendly Categories)
    $cv->skills()->createMany([
        [
            'skill_name' => 'Backend Development',
            'skill_type' => 'Backend',
            'skill_level' => 'PHP 8.2+, Laravel (v10, v11, v12), REST APIs, Eloquent ORM, Queue Systems, OAuth2 / Passport, Microservices',
            'sort_order' => 1,
        ],
        [
            'skill_name' => 'Frontend Engineering',
            'skill_type' => 'Frontend',
            'skill_level' => 'Vue.js (Vue 3 / Composition API), React.js, Inertia.js, JavaScript (ES6+), Tailwind CSS, Bootstrap 5, Vite, PWAs',
            'sort_order' => 2,
        ],
        [
            'skill_name' => 'Database & Architecture',
            'skill_type' => 'Database',
            'skill_level' => 'MySQL, MariaDB, Relational Schema Design, Query Optimization, Composite Indexing, Transactions, BCMath Accounting',
            'sort_order' => 3,
        ],
        [
            'skill_name' => 'DevOps & Systems',
            'skill_type' => 'DevOps',
            'skill_level' => 'Linux, Rocky Linux, Virtualmin, Nginx, Docker, GitHub Actions CI/CD, Let\'s Encrypt SSL Automation',
            'sort_order' => 4,
        ],
        [
            'skill_name' => 'Analytics & Tracking',
            'skill_type' => 'Analytics',
            'skill_level' => 'Google Tag Manager (GTM), Meta Conversions API (CAPI), GA4 Measurement Protocol, TikTok Events API',
            'sort_order' => 5,
        ],
        [
            'skill_name' => 'Integrations & APIs',
            'skill_type' => 'Integrations',
            'skill_level' => 'Stripe, PayPal, Razorpay, WooCommerce, ZKTeco Biometrics, LIS Analyzer Ingestion Pipelines, AWS S3',
            'sort_order' => 6,
        ],
    ]);

    // 10. Language Proficiency
    $cv->languages()->createMany([
        [
            'language_name' => 'Bangla',
            'reading_level' => 'Native',
            'writing_level' => 'Native',
            'speaking_level' => 'Native',
            'sort_order' => 1,
        ],
        [
            'language_name' => 'English',
            'reading_level' => 'Good',
            'writing_level' => 'Good',
            'speaking_level' => 'Good',
            'sort_order' => 2,
        ],
    ]);

    // 11. References
    $cv->references()->createMany([
        [
            'name' => 'Md. Asaduzzaman Mondol',
            'designation' => 'Head of Public Administration Department',
            'organization' => 'Begum Rokeya University, Rangpur',
            'phone' => '+8801911967202',
            'email' => 'asad.pad.brur@gmail.com',
            'relationship' => 'Academic Reference',
            'sort_order' => 1,
        ],
        [
            'name' => 'Abu Saleh Abdullah Al-Mamun',
            'designation' => 'Instructor & System Consultant',
            'organization' => 'IsDB-BISEW IT Scholarship Programme',
            'phone' => '+8801638308157',
            'email' => 'asad.pad.brur@gmail.com',
            'relationship' => 'Training & Technical Mentor',
            'sort_order' => 2,
        ],
    ]);
}
}

