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
            'title' => ucwords($this->faker->words($this->faker->numberBetween(3,6), true)),
            'sub_title' => $this->faker->words($this->faker->numberBetween(6,10), true),
            'created_at' => now(),
            'publish_date' => now(),
            'is_published' => 1,
            'author_id' => rand(2,5),
            'content' => $this->getFakeParagraphs(rand(3,12)),
            'header_image' => 'https://ik.imagekit.io/stingray/article/test/'. $this->getRandPhoto(),
            'slug' => $this->faker->slug,
        ];
    }


    private function getRandPhoto(){
        $photos = ['brooke-cagle-g1Kr4Ozfoac-unsplash.jpg',  
                    'luca-bravo-9l_326FISzk-unsplash.jpg',
                    'brooke-cagle-WHWYBmtn3_0-unsplash.jpg',     
                    'mario-gogh-VBLHICVh-lI-unsplash.jpg',
                    'christin-hume-Hcfwew744z4-unsplash.jpg',  
                    'sarah-dorweiler-x2Tmfd1-SgA-unsplash.jpg',
                    'headway-5QgIuuBxKwM-unsplash.jpg',
                    'thisisengineering-raeng-TXxiFuQLBKQ-unsplash.jpg',
                    'israel-andrade-YI_9SivVt_s-unsplash.jpg',
                    'tim-van-der-kuip-CPs2X8JYmS8-unsplash.jpg',
                    'joanna-kosinska-1_CMoFsPfso-unsplash.jpg'];

        $num = count($photos);
        return $photos[rand(0,$num-1)];

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
