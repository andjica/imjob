<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\City;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CompanyType;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    /**
     * Static properties to cache data and improve performance.
     */
    protected static $citiesByCountry = null;
    protected static $categories = null;
    protected static $subCategoriesByCategory = null;
    protected static $companyTypes = null;

    protected static $logos = ['img-40.jpg', 'img-39.jpg', 'img-48.jpg', 'img-20.png', 'img-36.jpg'];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        if (self::$companyTypes === null) {
            // Preload all company type IDs (assuming there are 3 types)
            self::$companyTypes = CompanyType::pluck('id')->toArray();
        }
        // Initialize static caches if not already done
        if (self::$citiesByCountry === null) {
            // Preload all cities and group them by country_id
            self::$citiesByCountry = City::all()->groupBy('country_id')->map(function ($cities) {
                return $cities->pluck('id')->toArray();
            })->toArray();
        }

        if (self::$categories === null) {
            // Preload all category IDs
            self::$categories = Category::pluck('id')->toArray();
        }

        if (self::$subCategoriesByCategory === null) {
            // Preload all subcategories and group them by category_id
            self::$subCategoriesByCategory = SubCategory::all()->groupBy('category_id')->map(function ($subcategories) {
                return $subcategories->pluck('id')->toArray();
            })->toArray();
        }

        $companyTypeId = $this->faker->randomElement(self::$companyTypes);

        // Select a random country_id
        $countryIds = array_keys(self::$citiesByCountry);
        $countryId = $this->faker->randomElement($countryIds);

        // Select a random city_id from the selected country
        $cityId = $this->faker->randomElement(self::$citiesByCountry[$countryId] ?? [null]);

        // Select a random category_id
        $categoryId = $this->faker->randomElement(self::$categories);

        // Select a random sub_category_id from the selected category
        $subCategoryIds = self::$subCategoriesByCategory[$categoryId] ?? [null];
        $subCategoryId = $this->faker->randomElement($subCategoryIds);

        // Select a random logo
        $randomLogo = $this->faker->randomElement(self::$logos);

        return [
            'country_id' => $countryId,
            'city_id' => $cityId,
            'company_type_id' => $companyTypeId, // New field added
            'user_id' => $this->faker->numberBetween(1, 15),
            'owner_title' => $this->faker->randomElement(['CEO', 'Founder', 'Head']),
            'name' => $this->faker->company,
            'registration_number' => $this->faker->unique()->numerify('CRN#####'),
            'tax_number' => $this->faker->unique()->numerify('TAX#####'),
            'phone_number' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->companyEmail,
            'address' => $this->faker->address,
            'logo' => $randomLogo, 
            'active' => $this->faker->boolean(),
            'category_id' => $categoryId,
            'sub_category_id' => $subCategoryId,
        ];
    }
}
