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
        $content = $this->getFakeParagraphs(rand(3,12));

        return [
            'title' => ucwords($this->faker->words($this->faker->numberBetween(3,6), true)),
            'sub_title' => $this->faker->words($this->faker->numberBetween(6,10), true),
            'created_at' => now(),
            'publish_date' => now(),
            'is_published' => 1,
            'author_id' => rand(2,5),
            'content' => $content,
            'header_image' => 'https://ik.imagekit.io/stingray/article/placeholder.jpg',
            'slug' => $this->faker->slug,
        ];
    }

    private function getFakeParagraphs($num)
    {
        $paragraphs = $num;
        $i = 0;
        $ret = "";
        while ($i < $paragraphs) {
            $ret .= "<p>" . $this->faker->paragraph(rand(3, 10)) . "</p>";
            $i++;
        }
        return $ret;
    }


}
