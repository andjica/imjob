<?php

namespace App\Http\Controllers;

use App\Interfaces\SubCategoryInterface;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    protected $subCategoriesServies;

    public function __construct(SubCategoryInterface $subCategoriesServies)
    {
        $this->subCategoriesServies = $subCategoriesServies;
    }

    public  function getSubCategoriesByCategory(int $categoryId)
    {
        $subcategories = $this->subCategoriesServies->getAllByCategoryId($categoryId);

        return response()->json([
            'subcategories'=>$subcategories
        ]);
    }
}
