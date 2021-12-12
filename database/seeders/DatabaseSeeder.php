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
        $users = User::factory()->count(100)->create();
        $company_profiles = CompanyProfile::factory()->count(100)->has(JobPost::factory()->count(20), 'job_posts')->create();
        $job_posts = JobPost::factory()->count(500)->create();
        $articles = Article::factory()->count(250)->create();

        // Seed article / company_profiles many to many relationship
        $this->call([
            ArticleCompanyProfile::class
        ]);
    }

}
