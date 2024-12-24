<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Recruiter;
use Illuminate\Database\Seeder;

class CompanyRecruiterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Recruiter::factory(10)->create()->each(function ($recruiter) {
            // Create 3 companies for each recruiter
            $companies = Company::factory(3)->create();
        
            foreach ($companies as $company) {
                $fromDate = now()->subMonths(rand(1, 24)); // From 1 to 24 months ago
                $untilDate = rand(0, 1) ? now()->subMonths(rand(0, 12)) : null; // 50% chance to be in the past
        
                $status = $untilDate ? 'past' : 'active'; // Determine status based on until_date
        
                $recruiter->companies()->attach($company->id, [
                    'from_date' => $fromDate,
                    'until_date' => $untilDate,
                    'status' => $status,
                ]);
            }
        });
    }
}
