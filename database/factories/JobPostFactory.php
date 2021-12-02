<?php

namespace Database\Factories;

use App\Models\JobPost;
use Illuminate\Database\Eloquent\Factories\Factory;
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
            'content' => $this->faker->paragraph(70),
            'apply_url' => $this->faker->url,
            'slug' => $this->faker->slug,
            'explevel_id' =>$this->faker->numberBetween(1,4),
            'remotetype_id' => $this->faker->numberBetween(1,4),
            'location_id' => rand(99,102),
            'job_cat_id' => rand(2001,2014),
            'is_published' => 1,

        ];
    }
}
