<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\JobPost;
use App\Models\CompanyProfile;
use Illuminate\Support\Str;

class BenefitCatsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->load_benefit_cats();
    }

    // Load job subcategories
    function load_benefit_cats()
    {
        // TODO decide if there is any value is sub job categories.
        //$job_cats_json = json_decode(file_get_contents("scraped_data/job_subcats.json"));

        // Load the top level job categories
        $benefit_cats = [];

        $benefit_cats[] = ["name" => "Health Insurance", "id" => 2001];
        $benefit_cats[] = ["name" => "Dental Insurance", "id" => 2002];
        $benefit_cats[] = ["name" => "Life Insurance", "id" => 2003];
        $benefit_cats[] = ["name" => "HSA Account", "id" => 2004];
        $benefit_cats[] = ["name" => "401(K)", "id" => 2005];
        $benefit_cats[] = ["name" => "401(K) (Company Matching)", "id" => 2006];
        $benefit_cats[] = ["name" => "Paid Holidays", "id" => 2007];
        $benefit_cats[] = ["name" => "Paid Vacation", "id" => 2008];
        $benefit_cats[] = ["name" => "Unlimited Vacation", "id" => 2009];
        $benefit_cats[] = ["name" => "Personal/Sick Days", "id" => 2010];
        $benefit_cats[] = ["name" => "Company Equity", "id" => 2011];
        $benefit_cats[] = ["name" => "Performance Bonus", "id" => 2012];
        $benefit_cats[] = ["name" => "Relocation Assistance", "id" => 2013];
        $benefit_cats[] = ["name" => "Snacks", "id" => 2014];
        $benefit_cats[] = ["name" => "Some Meals Provided", "id" => 2015];
        $benefit_cats[] = ["name" => "Pet Friendly Office", "id" => 2016];
        $benefit_cats[] = ["name" => "Work from Home Stipend", "id" => 2017];
        $benefit_cats[] = ["name" => "Tuition Reimbursement", "id" => 2018];


        foreach ($benefit_cats as $cat) {

                DB::table('benefit_cats')->insert([
                    'name' => $cat['name'],
                    'id' => $cat['id'],
                    'slug' => Str::slug($cat['name'], '-'),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
        }

    }

}
