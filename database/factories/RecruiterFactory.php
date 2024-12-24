<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecruiterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $logos = ['300-2.jpg', '300-11.jpg', '300-12.jpg', '300-1.jpg', '300-3.jpg'];
        $randomLogo = $logos[array_rand($logos)];
        return [
            'user_id' => User::factory(),
            // 'company_id' => Company::factory(),
            'profile_image' => $randomLogo,
            'birthday' => $this->faker->date(),
            'title_function' => $this->faker->jobTitle(),
            'is_freelancer' => $this->faker->boolean(50)
        ];
    }
}
