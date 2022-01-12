<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompanyProfile;
use App\Models\CompanyType;

class CompanyProfileCompanyType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        CompanyProfile::all()->each(function (CompanyProfile $company_profile) {
            $company_type_ids = CompanyType::inRandomOrder()->take(random_int(0,3))->get()->pluck('id');
            $company_profile->company_types()->syncWithoutDetaching($company_type_ids);
        });

    }
}
