<?php

namespace Database\Seeders;

use App\Models\JobType;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class JobTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define the job types you want to seed
       // Define the job types with associated icons
        $jobTypes = [
            'Full-Time'   => 'fa-solid fa-briefcase',
            'Part-Time'   => 'fa-solid fa-briefcase',
            'Contract'    => 'fa-solid fa-file-contract',
            'Temporary'   => 'fa-solid fa-hourglass',
            'Internship'  => 'fa-solid fa-user-tie',
            'Freelance'   => 'fa-solid fa-user-cog',
            'Remote'      => 'fa-solid fa-house-user',
            'On-Site'     => 'fa-solid fa-building',
            'Commission'  => 'fa-solid fa-percent',
            'Volunteer'   => 'fa-solid fa-hands-helping',
        ];

        // Insert or update each job type into the database
        foreach ($jobTypes as $type => $icon) {
            JobType::updateOrCreate(
                ['name' => $type],
                [
                    'slug' => Str::slug($type, '-'),
                    'description' => "Job type: {$type}",
                    'icon' => $icon,
                ]
            );
        }
    }
}
