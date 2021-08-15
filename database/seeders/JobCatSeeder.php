<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\JobPost;
use App\Models\CompanyProfile;
use Illuminate\Support\Str;

class JobCatSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->load_job_cats();
    }

    // Load job subcategories
    function load_job_cats()
    {
        // TODO decide if there is any value is sub job categories.
        //$job_cats_json = json_decode(file_get_contents("scraped_data/job_subcats.json"));

        // Load the top level job categories
        $p_job_cats = [];

        $p_job_cats[] = ["name" => "IT Management", "id" => 2001];
        $p_job_cats[] = ["name" => "Cybersecurity", "id" => 2002];
        $p_job_cats[] = ["name" => "Customer Success", "id" => 2003];
        $p_job_cats[] = ["name" => "Data and Analytics", "id" => 2004];
        $p_job_cats[] = ["name" => "Design and UX", "id" => 2005];
        $p_job_cats[] = ["name" => "DevOps", "id" => 2006];
        $p_job_cats[] = ["name" => "Software Engineering", "id" => 2007];
        $p_job_cats[] = ["name" => "Finance", "id" => 2008];
        $p_job_cats[] = ["name" => "HR and Recruiting", "id" => 2009];
        $p_job_cats[] = ["name" => "Marketing", "id" => 2010];
        $p_job_cats[] = ["name" => "Operations", "id" => 2011];
        $p_job_cats[] = ["name" => "Product", "id" => 2012];
        $p_job_cats[] = ["name" => "Project Management", "id" => 2013];
        $p_job_cats[] = ["name" => "Sales", "id" => 2014];


        foreach ($p_job_cats as $cat) {

                DB::table('job_cats')->insert([
                    'name' => $cat['name'],
                    'id' => $cat['id'],
                    'slug' => Str::slug($cat['name'], '-'),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
        }

    }

}
