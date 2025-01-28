<?php

namespace Database\Seeders;

use App\Models\ContributorType;
use Illuminate\Database\Seeder;

class ContributorTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contributorTypes = [
            'Ministry of Medicine',
            'Airline Oganization',
            'Embassy',
            'Technology Oganization',
            'Non-Profit Organization',
            'Educational Institution',
            'Hospital',
            'Pharmaceutical Oganization',
            'Media Agency',
            'Construction Oganization',
            'Automotive Manufacturer',
            'Retail Store',
            'Restaurant Chain',
            'Logistics Oganization',
            'Bank',
            'Insurance Oganization',
            'Tourism Agency',
            'Consulting Firm',
            'Entertainment Studio',
            'Government Agency',
            'Other(Specify)'
        ];

        foreach ($contributorTypes as $type) {
            ContributorType::create(['name' => $type]);
        }
    }
}
