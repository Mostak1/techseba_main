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

            'career_objective' => 'To architect and deliver high-performance, secure, and scalable enterprise Laravel applications while driving infrastructure excellence on Rocky Linux servers and enabling server-side data analytics & tracking integration.',

            'career_summary' => 'Senior Full-Stack Laravel Developer / DevOps & Tracking Integration Engineer experienced in developing enterprise-grade applications (Carenet ERP, TechSeba POS & ERP, MessMeal, Fluento) and managing production infrastructure on Rocky Linux. Combines backend and frontend product engineering with Virtualmin multi-domain hosting, automated Let\'s Encrypt SSL provisioning, secure REST APIs, ERP/POS business logic, CI/CD, and end-to-end marketing event tracking through Meta Pixel, Meta Conversions API (CAPI) and Google Tag Manager (GTM).',

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

    // 5. Employment History (From RockyLinux AI Master Profile)
    $cv->employments()->createMany([
        [
            'company_name' => 'TechSeba — Enterprise POS & ERP System',
            'designation' => 'Senior Full-Stack Laravel & Vue.js Developer / Lead Software Engineer',
            'department' => 'Software Engineering',
            'start_date' => '2026-07-01',
            'end_date' => null,
            'is_current' => true,
            'responsibilities' => 'Architected unit-level serial/IMEI tracking across purchases, warehouse stock, transfers, and POS sales. Built cash-register audit sessions with cash variance reporting. Developed double-entry accounting (Chart of Accounts, Trial Balance, P&L). Built Passport OAuth2 APIs, RBAC, 2FA, and Stripe/QuickBooks/WooCommerce integrations. Configured GitHub Actions CI/CD deployment.',
            'achievements' => 'Built unit-level IMEI/serial tracking and real-time cash register audit reporting using optimized aggregate SQL queries in Laravel 12 & Vue.js.',
            'company_location' => 'Dhaka, Bangladesh',
            'business_type' => 'Retail ERP & POS',
            'sort_order' => 1,
        ],
        [
            'company_name' => 'Fluento — Enterprise EdTech & IELTS Platform',
            'designation' => 'Senior Laravel / Full-Stack Developer',
            'department' => 'Software Development',
            'start_date' => '2024-09-01',
            'end_date' => null,
            'is_current' => true,
            'responsibilities' => 'Architected IELTS mock-exam engine with dynamic reading passages, listening audio, and writing scoring. Built drip course releases, certificate generator using Spatie Browsershot/Puppeteer, multi-gateway billing (Stripe, PayPal, Razorpay), and Meta CAPI / TikTok Events API server-side tracking.',
            'achievements' => 'Unified course streaming, IELTS testing, e-commerce, certificate generation, and server-side marketing analytics on Laravel 11.',
            'company_location' => 'Bangladesh',
            'business_type' => 'EdTech & E-Commerce',
            'sort_order' => 2,
        ],
        [
            'company_name' => 'Carenet ERP — Healthcare & Modular Business Platform',
            'designation' => 'Senior Full-Stack Laravel Developer / Core Module Architect',
            'department' => 'Software Engineering',
            'start_date' => '2023-09-01',
            'end_date' => null,
            'is_current' => false,
            'responsibilities' => 'Designed modular Laravel architecture using nwidart/laravel-modules across 15+ business domains. Built LIS laboratory analyzer ingestion pipelines and ZKTeco biometric attendance device integrations. Implemented Passport OAuth2, Spatie Permission RBAC, and location data filters.',
            'achievements' => 'Architected scalable modular healthcare ERP with automated lab analyzer data ingestion and multi-location inventory reconciliation.',
            'company_location' => 'Dhaka, Bangladesh',
            'business_type' => 'Healthcare ERP',
            'sort_order' => 3,
        ],
        [
            'company_name' => 'MessMeal — Multi-Tenant Financial PWA',
            'designation' => 'Full-Stack Laravel & Vue.js Engineer / Lead Architect',
            'department' => 'Product Engineering',
            'start_date' => '2024-01-01',
            'end_date' => '2024-08-31',
            'is_current' => false,
            'responsibilities' => 'Architected shared-database multi-tenancy using BelongsToMess global scopes and active-context middleware. Built 6-state expense review workflow, PHP BCMath 4-decimal precision accounting, and Vue 3 + Inertia installable PWA with Vite & Workbox.',
            'achievements' => 'Engineered zero-error multi-tenant financial accounting PWA using PHP BCMath and global query scoping.',
            'company_location' => 'Bangladesh',
            'business_type' => 'Multi-Tenant Financial SaaS',
            'sort_order' => 4,
        ],
        [
            'company_name' => 'TechSeba Main — Digital Agency & Service SaaS Platform',
            'designation' => 'Full-Stack Laravel Developer / Product Engineer',
            'department' => 'SaaS Product Development',
            'start_date' => '2023-01-01',
            'end_date' => '2023-08-31',
            'is_current' => false,
            'responsibilities' => 'Full-stack Laravel SaaS product architecture, agency and freelancer service operations, online payment capabilities, and dynamic portfolio-generation functionality.',
            'achievements' => 'Developed commercial SaaS platform combining agency service operations, online payments, and dynamic portfolio generation.',
            'company_location' => 'Dhaka, Bangladesh',
            'business_type' => 'Commercial SaaS',
            'sort_order' => 5,
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

    // 9. Technical & Infrastructure Skills (From Master Profile)
    $cv->skills()->createMany([
        [
            'skill_name' => 'Backend Engineering: PHP 8.2+, Laravel 12/11, Eloquent ORM, REST APIs, Passport OAuth2, Queues & Artisan',
            'skill_type' => 'Technical Skills',
            'skill_level' => 'Expert',
            'sort_order' => 1,
        ],
        [
            'skill_name' => 'Frontend & UI: Vue.js (v2.7 & Vue 3 Composition API), Vuex, Vue Router, Inertia.js, React.js, Tailwind CSS (v3/v4), Alpine.js',
            'skill_type' => 'Technical Skills',
            'skill_level' => 'Expert',
            'sort_order' => 2,
        ],
        [
            'skill_name' => 'Database Engineering: MySQL/MariaDB schema design, BCMath 4-decimal precision, transactions, indexing, aggregate SQL optimization',
            'skill_type' => 'Technical Skills',
            'skill_level' => 'Expert',
            'sort_order' => 3,
        ],
        [
            'skill_name' => 'Linux & DevOps: Rocky Linux administration, Virtualmin multi-domain hosting, Let\'s Encrypt SSL automation, Nginx/PHP-FPM, Docker, GitHub Actions CI/CD',
            'skill_type' => 'Technical Skills',
            'skill_level' => 'Expert',
            'sort_order' => 4,
        ],
        [
            'skill_name' => 'Analytics & Tracking: Google Tag Manager (GTM), Meta Pixel, Meta Conversions API (CAPI), TikTok Events API, GA4 Measurement Protocol',
            'skill_type' => 'Technical Skills',
            'skill_level' => 'Expert',
            'sort_order' => 5,
        ],
        [
            'skill_name' => 'Third-Party Integrations: Stripe, PayPal, Razorpay, QuickBooks Online, WooCommerce, Twilio, Infobip, AWS S3, ZKTeco Biometrics',
            'skill_type' => 'Technical Skills',
            'skill_level' => 'Good',
            'sort_order' => 6,
        ],
        [
            'skill_name' => 'English Language: Professional proficiency in spoken, reading, and written technical English.',
            'skill_type' => 'Language Skills',
            'skill_level' => 'Good',
            'sort_order' => 7,
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

