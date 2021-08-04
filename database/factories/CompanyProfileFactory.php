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
            'profile_title' => $this->faker->catchPhrase,
            'description' => $this->faker->paragraph(9),
            'slug' => $this->faker->slug,
            'name' => $this->faker->company,
            'local_employees' => rand(10,500),
            'year_founded' => rand(1980, 2021),
            'global_employees' => rand(10,50000),
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
            'featured' => rand(0,1)
        ];
    }
}
