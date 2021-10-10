<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\JobPost;
use App\Models\CompanyProfile;
use Illuminate\Support\Str;

class LocationSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->load_locations();
    }

    function load_locations(){


        $name = "Remote/Flexible";
        DB::table('locations')->insert([
            'name' => $name,
            'created_at' => now(),
            'updated_at' => now(),
            'slug' => Str::slug($name, '-'),
            'id' => 99

        ]);

        $name = "Tampa Bay";
        DB::table('locations')->insert([
            'name' => $name,
            'description' => 'All cities in the Tampa Bay area including Tampa, St. Petersburg, and Clearwater.',
            'created_at' => now(),
            'updated_at' => now(),
            'slug' => Str::slug($name, '-'),
            'id' => 1

        ]);

        $name = "Miami Area";
        DB::table('locations')->insert([
            'name' => $name,
            'description' => 'All cities in the Miami area including Miami, Ft. Lauderdale, and Palm Springs.',
            'created_at' => now(),
            'updated_at' => now(),
            'slug' => Str::slug($name, '-'),
            'id' => 2
        ]);

        $name = "Tampa";
        DB::table('locations')->insert([
            'name' => $name,
            'parent_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'slug' => Str::slug($name, '-'),
        ]);

        $name = "St. Petersburg";
        DB::table('locations')->insert([
            'name' => $name,
            'parent_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'slug' => Str::slug($name, '-'),
        ]);

        $name = "Clearwater";
        DB::table('locations')->insert([
            'name' => $name,
            'parent_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'slug' => Str::slug($name, '-'),
        ]);

        $name = "Miami";
        DB::table('locations')->insert([
            'name' => $name,
            'parent_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
            'slug' => Str::slug($name, '-'),
        ]);

        $name = 'Ft. Lauderdale';
        DB::table('locations')->insert([
            'name' => $name,
            'parent_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
            'slug' => Str::slug($name, '-'),
        ]);

    }

}
