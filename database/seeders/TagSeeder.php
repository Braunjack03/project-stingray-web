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

        $tags = ['Investment', 'Hiring', 'Productivity', 'Culture', 'Startup'];

        foreach($tags as $tag){
        DB::table('tags')->insert([
            'name' => $tag,
            'created_at' => now(),
            'updated_at' => now(),

        ]);
    }

    }

}
