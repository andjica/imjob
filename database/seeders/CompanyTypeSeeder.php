<?php

namespace Database\Seeders;

use App\Models\CompanyType;
use Illuminate\Database\Seeder;

class CompanyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companyTypes = [
            ['name' => 'Basic'],
            ['name' => 'Agency'],
            ['name' => 'Freelancer'],
        ];

        foreach ($companyTypes as $type) {
            CompanyType::create($type);
        }
    }
}
