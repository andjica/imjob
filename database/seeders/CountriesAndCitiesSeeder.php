<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Country;
use App\Models\City;

class CountriesAndCitiesSeeder extends Seeder
{
    public function run()
    {
        // Optional: Increase memory limit if necessary
        ini_set('memory_limit', '1024M'); // 1GB

        // Start a database transaction
        DB::transaction(function () {
            // Path to the JSON data file
            $jsonPath = database_path('seeders/data/countries.json');

            if (!File::exists($jsonPath)) {
                $this->command->error("Data file not found at: {$jsonPath}");
                return;
            }

            // Read and decode the JSON file
            $json = File::get($jsonPath);
            $data = json_decode($json, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->command->error("JSON Decode Error: " . json_last_error_msg());
                return;
            }

            // Initialize an array to collect skipped entries
            $skippedEntries = [];

            // Iterate through each country in the data
            foreach ($data as $index => $countryData) {
                // Validate required keys
                if (!isset($countryData['name']) || !isset($countryData['iso_code']) || !isset($countryData['cities'])) {
                    $skippedEntries[] = [
                        'index' => $index,
                        'data' => $countryData,
                        'missing_keys' => $this->getMissingKeys($countryData)
                    ];
                    $this->command->warn("Skipping country at index {$index} due to missing required fields.");
                    continue; // Skip this entry
                }

                // Insert country using Eloquent
                $country = Country::create([
                    'name' => $countryData['name'],
                    'iso_code' => $countryData['iso_code'],
                ]);

                // Prepare cities associated with the current country
                $cities = array_map(function ($cityName) use ($country) {
                    return [
                        'country_id' => $country->id,
                        'name' => $cityName,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }, $countryData['cities']);

                // Insert cities in chunks to optimize memory usage
                $chunks = array_chunk($cities, 500); // Adjust chunk size as needed

                foreach ($chunks as $chunk) {
                    City::insert($chunk);
                    unset($chunk);
                    gc_collect_cycles();
                }

                // Log progress every 100 countries
                if (($index + 1) % 100 === 0) {
                    $this->command->info("Inserted " . ($index + 1) . " countries.");
                }

                // Free memory
                unset($cities, $country);
                gc_collect_cycles();
            }

            // Report skipped entries, if any
            if (!empty($skippedEntries)) {
                $this->command->warn("Some entries were skipped due to missing required fields:");
                foreach ($skippedEntries as $entry) {
                    $this->command->warn("Index {$entry['index']}: Missing " . implode(', ', $entry['missing_keys']));
                }
            } else {
                $this->command->info("No entries were skipped.");
            }
        });

        $this->command->info("Countries and Cities seeding completed successfully.");
    }

    /**
     * Helper function to identify missing keys in country data.
     */
    private function getMissingKeys($countryData)
    {
        $requiredKeys = ['name', 'iso_code', 'cities'];
        $missing = [];

        foreach ($requiredKeys as $key) {
            if (!isset($countryData[$key])) {
                $missing[] = $key;
            }
        }

        return $missing;
    }
}
