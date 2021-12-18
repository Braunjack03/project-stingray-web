<?php

namespace Database\Factories;

use App\Models\JobPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Utils;
//use Illuminate\Support\Str;

class JobPostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JobPost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->jobTitle,
            'content' => $this->getFakeParagraphs(rand(5,12)),
            'apply_url' => $this->faker->url,
            'slug' => $this->faker->slug,
            'explevel_id' =>$this->faker->numberBetween(1,4),
            'remotetype_id' => $this->faker->numberBetween(1,4),
            'location_id' => rand(99,102),
            'job_cat_id' => rand(2001,2014),
            'is_published' => 1,

        ];
    }

    private function getFakeParagraphs($num)
    {
        $paragraphs = $num;
        $i = 0;
        $ret = "";
        while ($i < $paragraphs) {
            $ret .= "<p>" . $this->faker->paragraph(rand(3, 8)) . "</p>";
            $i++;
        }
        return $ret;
    }

    
}
