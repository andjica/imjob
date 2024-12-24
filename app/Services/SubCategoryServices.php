<?php

namespace App\Services;

use App\Interfaces\SubCategoryInterface;
use App\Models\Category;
use App\Models\SubCategory;

class SubCategoryServices implements SubCategoryInterface
{
    public function getAllByCategoryId(int $categoryId)
    {
        $category = Category::find($categoryId) ?? abort(404);

        if($category)
        {
            $subCategories = SubCategory::where('category_id', $category->id)->get();
            
            return $subCategories;
        }
        else
        {
            return abort(404);
        }
    }

    public function getAll()
    {
        $subCategories = SubCategory::all();
        return $subCategories;
    } 
    
}