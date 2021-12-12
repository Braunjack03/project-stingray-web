<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompanyProfile;
use App\Models\Article;

class ArticleCompanyProfile extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $company_profiles = CompanyProfile::all();

        Article::all()->each(function (Article $article) {
            $company_profiles = CompanyProfile::inRandomOrder()->take(random_int(0,5))->get()->pluck('id');
            $article->company_profiles()->sync($company_profiles);
        });





        //
    }
}
