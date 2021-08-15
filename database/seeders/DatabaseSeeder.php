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
        $users = User::factory()->count(10)->create();
        $company_profiles = CompanyProfile::factory()->count(10)->has(JobPost::factory()->count(5), 'job_posts')->create();
        $job_posts = JobPost::factory()->count(10)->create();
        $articles = Article::factory()->count(10)->create();
    }

}
