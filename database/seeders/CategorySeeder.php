<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Healthcare', 'description' => 'Jobs in the healthcare industry.'],
            ['name' => 'IT & Software', 'description' => 'Jobs in the IT and software industry.'],
            ['name' => 'Construction & Building', 'description' => 'Jobs in the construction and building sector.'],
            ['name' => 'Fashion', 'description' => 'Careers in the fashion industry.'],
            ['name' => 'Music', 'description' => 'Jobs in the music and audio industry.'],
            ['name' => 'Electrical Engineering', 'description' => 'Careers in electrical engineering and technology.']
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'description' => $category['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
