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

    // 2. Find or create user from PDF data
    $user = User::where('email', 'mostakidb@gmail.com')
        ->orWhere('email', 'mdmostaka@gmail.com')
        ->orWhere('phone', '01834160283')
        ->orWhere('phone', '+8801752243665')
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

            'career_objective' => 'To work in a stimulating and challenging environment that will provide me with advancement opportunities. I want to excel in this field with hard work, perseverance and dedication. I want a highly rewarding career where I can use my skills and knowledge for organizational and personal growth.',

            'career_summary' => 'Experienced software developer with practical experience in Laravel, React.js, PHP, CodeIgniter, JavaScript, MySQL and web application development. Currently working as a Team Leader of Software Developer at American Wellness Centre. Completed internship as a Software Developer at Genuity System Ltd. and previously worked as a Customer Service Officer at Bank Asia Agent Banking.',

            'total_experience' => 3.5,

            'declaration' => 'I hereby declare that the information provided in this CV is true and correct to the best of my knowledge and belief.',
            'declaration_date' => now(),

            'is_public' => true,
            'public_print_enabled' => true,
            'public_pdf_enabled' => true,
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

    // 5. Employment History
    $cv->employments()->createMany([
        [
            'company_name' => 'American Wellness Centre',
            'designation' => 'Team Leader of Software Developer',
            'department' => 'Software Development',
            'start_date' => '2023-09-01',
            'end_date' => null,
            'is_current' => true,
            'responsibilities' => 'Currently working as a Team Leader of Software Developer.',
            'achievements' => null,
            'company_location' => null,
            'business_type' => 'Healthcare / Wellness',
            'sort_order' => 1,
        ],
        [
            'company_name' => 'Genuity System Ltd.',
            'designation' => 'Software Developer Intern',
            'department' => 'Software Development',
            'start_date' => '2023-03-01',
            'end_date' => '2023-08-31',
            'is_current' => false,
            'responsibilities' => 'Completed 6 month internship as a Software Developer.',
            'achievements' => null,
            'company_location' => null,
            'business_type' => 'Software Company',
            'sort_order' => 2,
        ],
        [
            'company_name' => 'Bank Asia Agent Banking, Borobari, Lalmonirhat',
            'designation' => 'Customer Service Officer (CSO)',
            'department' => 'Agent Banking',
            'start_date' => '2020-04-01',
            'end_date' => '2021-12-31',
            'is_current' => false,
            'responsibilities' => 'Worked as a Customer Service Officer at Bank Asia Agent Banking.',
            'achievements' => null,
            'company_location' => 'Borobari, Lalmonirhat',
            'business_type' => 'Banking',
            'sort_order' => 3,
        ],
        [
            'company_name' => 'Relief Distribution Program',
            'designation' => 'Organizer',
            'department' => 'Social Work',
            'start_date' => '2019-01-01',
            'end_date' => '2019-12-31',
            'is_current' => false,
            'responsibilities' => 'Arranged relief distribution for 525 flood-affected people.',
            'achievements' => 'Successfully arranged relief distribution for 525 flood-affected people in 2019.',
            'company_location' => 'Bangladesh',
            'business_type' => 'Volunteer / Social Work',
            'sort_order' => 4,
        ],
        [
            'company_name' => 'Relief Distribution Program',
            'designation' => 'Organizer',
            'department' => 'Social Work',
            'start_date' => '2017-01-01',
            'end_date' => '2017-12-31',
            'is_current' => false,
            'responsibilities' => 'Arranged relief distribution for 150 flood-affected people.',
            'achievements' => 'Successfully arranged relief distribution for 150 flood-affected people in 2017.',
            'company_location' => 'Bangladesh',
            'business_type' => 'Volunteer / Social Work',
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
            'duration' => null,
            'year' => null,
            'certificate_details' => 'Completed IT PGD course about Web Application Development with JavaScript, React.js, PHP, CodeIgniter and Laravel.',
            'sort_order' => 1,
        ],
    ]);

    // 8. Projects
    $cv->projects()->createMany([
        [
            'title' => 'Laravel Project Modify Of UltimatePOS',
            'link' => 'https://pos.mostaksarker.com/',
            'description' => 'Customized projects, essential and product sell interface modules.',
            'sort_order' => 1,
        ],
        [
            'title' => 'Laravel Project About E-Learning',
            'link' => 'https://testbd.mostaksarker.com/',
            'description' => 'Front-end and back-end developed with Laravel 10. Students can login and enroll in packages, learn topics and attend quiz exams. Guest users can also take random quiz exams.',
            'sort_order' => 2,
        ],
        [
            'title' => 'React Project About Event Management',
            'link' => 'https://react.mostaksarker.com/',
            'description' => 'Users can login and register with Firebase, select event decoration choices and submit them. Users can email for any need.',
            'sort_order' => 3,
        ],
        [
            'title' => 'CodeIgniter 4 Project About Book Sale',
            'link' => 'https://cibook.mostaksarker.com/',
            'description' => 'Book sale e-commerce site where users can order books and admin can manage orders.',
            'sort_order' => 4,
        ],
        [
            'title' => 'Ecommerce Website About Electric Product',
            'link' => 'https://mostaksarker.com/electro_master/',
            'description' => 'Built with Vanilla JavaScript, jQuery, PHP and MySQL. Features include product catalog, registration, login verification, wishlist, cart, order submission, checkout, payment integration, admin login and admin panel for managing products, orders and users.',
            'sort_order' => 5,
        ],
    ]);

    // 9. Skills
    $cv->skills()->createMany([
        [
            'skill_name' => 'English Language: can speak, read and write English with minimal difficulty and hold a conversation with a native speaker easily.',
            'skill_type' => 'Language Skills',
            'skill_level' => 'Good',
            'sort_order' => 1,
        ],
        [
            'skill_name' => 'Teamwork: worked with a bank product development team and conducted market research.',
            'skill_type' => 'Job-related Skills',
            'skill_level' => 'Good',
            'sort_order' => 2,
        ],
        [
            'skill_name' => 'Microsoft Excel: IF function and criteria-based calculation.',
            'skill_type' => 'Computer Skills',
            'skill_level' => 'Good',
            'sort_order' => 3,
        ],
        [
            'skill_name' => 'Microsoft PowerPoint: animation, motion path and narration over slides.',
            'skill_type' => 'Computer Skills',
            'skill_level' => 'Good',
            'sort_order' => 4,
        ],
        [
            'skill_name' => 'Adobe Photoshop: business card, flyer, ID card and photo editing.',
            'skill_type' => 'Software Skills',
            'skill_level' => 'Good',
            'sort_order' => 5,
        ],
        [
            'skill_name' => 'Communication Skill: active listening, confidence, friendliness and clear communication.',
            'skill_type' => 'Job-related Skills',
            'skill_level' => 'Good',
            'sort_order' => 6,
        ],
        [
            'skill_name' => 'Laravel',
            'skill_type' => 'Technical Skills',
            'skill_level' => 'Good',
            'sort_order' => 7,
        ],
        [
            'skill_name' => 'React.js',
            'skill_type' => 'Technical Skills',
            'skill_level' => 'Good',
            'sort_order' => 8,
        ],
        [
            'skill_name' => 'PHP',
            'skill_type' => 'Technical Skills',
            'skill_level' => 'Good',
            'sort_order' => 9,
        ],
        [
            'skill_name' => 'CodeIgniter',
            'skill_type' => 'Technical Skills',
            'skill_level' => 'Good',
            'sort_order' => 10,
        ],
        [
            'skill_name' => 'JavaScript',
            'skill_type' => 'Technical Skills',
            'skill_level' => 'Good',
            'sort_order' => 11,
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
            'designation' => 'Head of the Public Administration Department',
            'organization' => 'Begum Rokeya University, Rangpur',
            'phone' => '+8801911967202',
            'email' => 'asad.pad.brur@gmail.com',
            'relationship' => 'Academic Reference',
            'sort_order' => 1,
        ],
        [
            'name' => 'Abu Saleh Abdullah Al-Mamun',
            'designation' => 'Teacher',
            'organization' => 'IsDB-BISEW IT Scholarship Programme',
            'phone' => '+8801638308157',
            'email' => 'asad.pad.brur@gmail.com',
            'relationship' => 'Teacher / Training Reference',
            'sort_order' => 2,
        ],
    ]);
}
}
