<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\JobPost;
use App\Models\CompanyProfile;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // seed test data
        print("Seeding users. \n");
        $users = User::factory()->count(100)->create();
        print("Seeding company profiles.\n");

        for ($i = 0; $i < 20; $i++) {
            $company_profiles_1 = CompanyProfile::factory()->count(5)->has(JobPost::factory()->count(rand(4, 20)), 'job_posts')->create();
        }
        $company_profiles_2 = CompanyProfile::factory()->count(5)->has(JobPost::factory()->count(rand(1, 3)), 'job_posts')->create();
        $company_profiles_3 = CompanyProfile::factory()->count(3)->has(JobPost::factory()->count(0), 'job_posts')->create();
        $company_profiles_4 = CompanyProfile::factory()->count(3)->has(JobPost::factory()->count(100), 'job_posts')->create();

        print("Seeding articles.\n");
        $articles = Article::factory()->count(250)->create();

        // Seed article / company_profiles many to many relationship and company types
        $this->call([
            ArticleCompanyProfile::class,
            CompanyProfileCompanyType::class,
            CompanyProfileBenefitCat::class
        ]);
    }
}
