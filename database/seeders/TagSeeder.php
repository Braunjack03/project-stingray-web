<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->load_tags();
    }

    function load_tags(){

        $tags = ['Investment' => 'pink', 
                 'Hiring' => 'cyan', 
                 'Productivity' => 'violet', 
                 'Culture' => 'green', 
                 'Wellness' => 'gray',
                 'Startup' => 'blue'];

        foreach($tags as $tag=>$color){
        DB::table('tags')->insert([
            'name' => $tag,
            'color' => $color,
            'created_at' => now(),
            'updated_at' => now(),

        ]);
    }

    }

}
