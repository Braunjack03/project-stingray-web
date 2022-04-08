<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompanyProfile;
use App\Models\BenefitCat;

class CompanyProfileBenefitCat extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        CompanyProfile::all()->each(function (CompanyProfile $company_profile) {
            $benefit_cat_ids = BenefitCat::inRandomOrder()->take(random_int(0,12))->get()->pluck('id');
            $company_profile->benefit_cats()->syncWithoutDetaching($benefit_cat_ids);
        });

    }
}
