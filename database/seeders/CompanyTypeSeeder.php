<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\JobPost;
use App\Models\CompanyProfile;
use Illuminate\Support\Str;

class CompanyTypeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->load_company_types();
    }

    function load_company_types(){
        $company_types = ['AdTech',
                        'Agriculture Tech',
                        'Aerospace',
                        'Agency',
                        'Investment',
                        'Artificial Intelligence',
                        'Automotive',
                        'Beauty',
                        'Big Data',
                        'BioTech',
                        'Boating',
                        'Cloud Computing',
                        'Cryptocurrency',
                        'Consulting',
                        'Consumer Web',
                        'Cybersecurity',
                        'Ecommerce',
                        'EdTech',
                        'Energy',
                        'Enterprise Web',
                        'Events',
                        'Fashion',
                        'FinTech',
                        'Fitness',
                        'Food',
                        'Gaming',
                        'GreenTech',
                        'Government',
                        'Hardware',
                        'HealthTech',
                        'HR Tech',
                        'Incubator',
                        'Insurance',
                        'Intelligence',
                        'IT Services',
                        'Legal Tech',
                        'Logistics',
                        'Manufacturing Tech',
                        'Marketing Tech',
                        'Machine Learning',
                        'Mobile',
                        'Music',
                        'News',
                        'Other',
                        'Payments',
                        'Pet and Animals',
                        'Productivity',
                        'Professional Services',
                        'Real Estate',
                        'Retail',
                        'Robotics',
                        'Sales',
                        'Security',
                        'Sharing Economy',
                        'Social Impact',
                        'Social Media',
                        'Software',
                        'Sports',
                        'Transportation',
                        'Travel',
                        'Tourism'
        ];

        foreach($company_types as $type){

        DB::table('company_types')->insert([
            'name' => $type,
            'slug' => Str::slug($type, '-'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        }

    }
}
