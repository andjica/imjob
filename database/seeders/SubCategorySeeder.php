<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subcategories = [
            'Healthcare' => [
                'Doctors',
                'Nurses',
                'Pharmacists',
                'Therapists',
                'Medical Researchers',
                'Healthcare Administrators',
                //'Other' + dodati
            ],
            'IT & Software' => [
                'Software Developers',
                'System Administrators',
                'Data Scientists',
                'UI/UX Designers',
                'IT Security Analysts',
                'Network Engineers',
            ],
            'Construction & Building' => [
                'Architects',
                'Civil Engineers',
                'Masonry Workers',
                'Project Managers',
                'Plumbers',
                'Heavy Equipment Operators',
            ],
            'Fashion' => [
                'Fashion Designers',
                'Stylists',
                'Textile Experts',
                'Pattern Makers',
                'Fashion Photographers',
                'Retail Fashion Specialists',
            ],
            'Music' => [
                'Musicians',
                'Sound Engineers',
                'Composers',
                'Vocal Coaches',
                'Music Producers',
                'DJs',
            ],
            'Electrical Engineering' => [
                'Circuit Designers',
                'Electrical Technicians',
                'Power System Engineers',
                'Instrumentation Engineers',
                'Renewable Energy Specialists',
                'Control Systems Engineers',
            ]
        ];

        foreach ($subcategories as $categoryName => $subcats) {
            // Fetch category ID by name
            $categoryId = DB::table('categories')->where('name', $categoryName)->value('id');

            foreach ($subcats as $subcategoryName) {
                DB::table('sub_categories')->insert([
                    'category_id' => $categoryId,
                    'name' => $subcategoryName,
                    'description' => $subcategoryName . ' description.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
