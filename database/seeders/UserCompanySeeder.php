<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UserCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Fake Company Logos (External URLs)
       

        // Create 20 users with role_id = 2 (Company Role)
        $users = [];
        for ($i = 0; $i < 20; $i++) {
            $userId = DB::table('users')->insertGetId([
                'first_name' => 'CompanyUser' . ($i + 1),
                'last_name' => 'Owner' . ($i + 1),
                'email' => 'company' . ($i + 1) . '@example.com',
                'password' => Hash::make('password'),
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $users[] = $userId;
        }

        // Create 20 companies linked to the users
        foreach ($users as $index => $userId) {
            DB::table('companies')->insert([
                'country_id' => 195, // Serbia
                'city_id' => $faker->randomElement([107673, $faker->numberBetween(107666, 107765)]), // Belgrade or another city
                'user_id' => $userId,
                'company_type_id' => rand(1, 2), // Only 1 or 2
                'category_id' => rand(1, 5), // Replace with valid categories
                'sub_category_id' => rand(1, 10), // Replace with valid subcategories
                'address' => 'Street ' . ($index + 1) . ', Business City',
                'owner_title' => 'CEO',
                'name' => $faker->company,
                'registration_number' => strtoupper(Str::random(10)),
                'tax_number' => strtoupper(Str::random(8)),
                'phone_number' => '+3816' . rand(1000000, 9999999), // Serbian phone format
                'email' => 'contact' . ($index + 1) . '@company.com',
                'active' => true,
                'number_of_employees' => rand(10, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
