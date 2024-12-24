<?php

namespace App\Services;

use App\Interfaces\CategoryInterface;
use App\Models\Category;

class CategoryServices implements CategoryInterface
{
    public function getAll()
    {
        $categories = Category::orderBy('name', 'asc')->get();

        return $categories;
    }
}