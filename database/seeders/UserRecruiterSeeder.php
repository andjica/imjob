<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Recruiter;
use Faker\Factory as Faker;

class UserRecruiterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 50; $i++) { // Creates 10 fake recruiters
            // Create user
            $user = User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'), // Default password
                'role_id' => 3, // Recruiter role
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create recruiter profile
            Recruiter::create([
                'user_id' => $user->id,
                'country_id' => 195, // Serbia
                'city_id' => $faker->randomElement([107673, $faker->numberBetween(107666, 107765)]), // Belgrade or another city
                'category_id' => rand(1, 20), // Assuming 20 job categories
                'sub_category_id' => rand(1, 50), // Assuming 50 subcategories
                'birthday' => $faker->date('Y-m-d', '2000-01-01'),
                'title_function' => $faker->jobTitle,
                'experience_level' => $faker->randomElement(['Junior', 'Mid', 'Senior']),
                'availability' => $faker->randomElement(['Full-time', 'Part-time', 'Freelance']),
                'phone_number' => $faker->phoneNumber,
                'is_freelancer' => $faker->boolean,
                'profile_image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
