<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words($this->faker->numberBetween(3,9), true),
            'sub_title' => $this->faker->words($this->faker->numberBetween(6,10), true),
            'created_at' => now(),
            'publish_date' => now(),
            'is_published' => 1,
            'author_id' => rand(2,5),
            'content' => $this->faker->paragraphs(random_int(2,8), true),
            'header_image' => 'https://ik.imagekit.io/stingray/article/placeholder.jpg',
            'slug' => $this->faker->slug,
        ];
    }
}
