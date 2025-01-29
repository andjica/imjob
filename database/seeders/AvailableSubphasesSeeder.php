<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AvailableSubphasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subphases = [
            // Selection Phase
            ['phase' => 'selection', 'subphase' => 'Interview 1'],
            ['phase' => 'selection', 'subphase' => 'Interview 2'],
            ['phase' => 'selection', 'subphase' => 'Interview 3'],
            ['phase' => 'selection', 'subphase' => 'Professional Interview'],
            ['phase' => 'selection', 'subphase' => 'Language Proficiency Check'],
            ['phase' => 'selection', 'subphase' => 'Other'],

            // Preparation Phase
            ['phase' => 'preparation', 'subphase' => 'Language Course'],
            ['phase' => 'preparation', 'subphase' => 'Visa Request'],
            ['phase' => 'preparation', 'subphase' => 'Visa Issuance'],
            ['phase' => 'preparation', 'subphase' => 'Cultural Mediation'],
            ['phase' => 'preparation', 'subphase' => 'Other'],

            // Transfer Phase
            ['phase' => 'transfer', 'subphase' => 'Travel Arrangements'],
            ['phase' => 'transfer', 'subphase' => 'Candidate Reception'],
            ['phase' => 'transfer', 'subphase' => 'Other'],

            // Offer Stage
            ['phase' => 'offer_stage', 'subphase' => 'Administrative Preparation'],
            ['phase' => 'offer_stage', 'subphase' => 'Employment Date'],
            ['phase' => 'offer_stage', 'subphase' => 'Other'],
        ];

        DB::table('available_recruitment_subphases')->insert($subphases);
    }
}
