<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
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


        $this->load_job_cats('');


        // Create some dummy users
        $users = User::factory()->count(3)->create();
    }

    function load_job_cats($file)
    {

        // Load the top level job categories
        $p_job_cats = [];

        $p_job_cats[] = ["name" => "Data and Analytics", "id" => 147];
        $p_job_cats[] = ["name" => "Design and UX", "id" => 148];
        $p_job_cats[] = ["name" => "Software Engineering", "id" => 149];
        $p_job_cats[] = ["name" => "Finance", "id" => 146];
        $p_job_cats[] = ["name" => "HR and Recruiting", "id" => 150];
        $p_job_cats[] = ["name" => "Marketing", "id" => 153];
        $p_job_cats[] = ["name" => "Operations", "id" => 154];
        $p_job_cats[] = ["name" => "Product", "id" => 155];
        $p_job_cats[] = ["name" => "Project Management", "id" => 156];
        $p_job_cats[] = ["name" => "Sales", "id" => 157];


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
