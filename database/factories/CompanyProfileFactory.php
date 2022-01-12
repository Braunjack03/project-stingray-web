<?php

namespace Database\Factories;

use App\Models\CompanyProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CompanyProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CompanyProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'logo_image_url' => $this->getRandomLogo(),
            'featured_image_url' => 'https://ik.imagekit.io/stingray/article/test/tr:w-500/'. $this->getRandPhoto(),
            'profile_title' => $this->faker->catchPhrase,
            'uuid' => $this->faker->uuid,
            'description' => $this->getFakeParagraphs(rand(2,4)),
            'slug' => $this->faker->slug,
            'name' => $this->faker->company,
            'local_employees' => rand(10, 500),
            'year_founded' => rand(1980, 2021),
            'global_employees' => rand(10, 50000),
            'website_url' => $this->faker->url,
            'mission' => $this->faker->bs,
            'twitter_user' => $this->faker->username,
            'linkedin_user' => $this->faker->username,
            'facebook_user' => $this->faker->username,
            'instagram_user' => $this->faker->username,
            'city' => $this->faker->city,
            'state_abbr' => $this->faker->stateAbbr,
            'postcode' => $this->faker->postcode,
            'email_contact' => $this->faker->email,
            'phone_contact' => $this->faker->phoneNumber,
            'lat' => $this->faker->latitude,
            'long' => $this->faker->longitude,
            'featured' => rand(0, 1),
            'location_id' => rand(99, 102),
            'unclaimed' => rand(0, 1)
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
            $ret .= "<p>" . $this->faker->paragraph(rand(1, 5)) . "</p>";
            $i++;
        }
        return $ret;
    }


    private function getRandomLogo()
    {
        /*
        $logos = [
            "after-effects-cc.svg",
            "amalie-motor-oil.svg",
            'amazon_- logo-500x151.jpg',
            "bmw-2.svg",
            "cc-design.svg",
            'cisco_- logo-500x285.jpg',
            "edge-animate-app-cc.svg",
            "instagram-5.svg",
            "nikon.svg",
            'samsung_- logo-500x166.jpg',
            "starbucks.svg",
            "storm-1.svg",
            "the-home-depot.svg",
            "zema_logo_vector_final.svg",
        ];

        */

        $logos = [
            'test logo (10).png',  
            'test logo (13).png',  
            'test logo (16).png', 
            'test logo (3).png',  
            'test logo (6).png',  
            'test logo (9).png',
            'test logo (11).png',
            'test logo (14).png',  
            'test logo (1).png',   
            'test logo (4).png',  
            'test logo (7).png',
            'test logo.png',
            'test logo (12).png',  
            'test logo (15).png',  
            'test logo (2).png',
            'test logo (5).png', 
            'test logo (8).png',
        ];

        $rand_logo = $logos[rand(0, count($logos) - 1)];
        return 'https://ik.imagekit.io/stingray/test_logos2/tr:w-300,h-300,fo-auto/' . $rand_logo;
    }
}
