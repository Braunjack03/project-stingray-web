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
        $company_profiles = CompanyProfile::factory()->count(100)->has(JobPost::factory()->count(20), 'job_posts')->create();
        print("Seeding job posts.\n");
        $job_posts = JobPost::factory()->count(500)->create();
        print("Seeding articles.\n");
        $articles = Article::factory()->count(250)->create();

        // Seed article / company_profiles many to many relationship
        $this->call([
            ArticleCompanyProfile::class
        ]);
    }

}
