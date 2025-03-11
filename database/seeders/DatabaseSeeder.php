<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\CompanyRecruiter;
use App\Models\Recruiter;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // seeders
        // $this->call(RolesTableSeeder::class);
        // $this->call(CategorySeeder::class);
        // $this->call(SubCategorySeeder::class);
        // $this->call(CountryTableSeeder::class);
        // $this->call(CitySeeder::class);
        // $this->call(CompanyTypeSeeder::class);
        // $this->call(JobTypesSeeder::class);
        // $this->call(ContributorTypeSeeder::class);
        // $this->call(AvailableSubphasesSeeder::class);
        // //factories
        // User::factory(10)->create();
        //Company::factory()->count(20)->create();
        //Recruiter::factory()->count(20)->create();
        // $this->call(CompanyRecruiterSeeder::class);

        //$this->call(CountriesAndCitiesSeeder::class);

        $this->call(UserRecruiterSeeder::class);



    }
}
