<?php

namespace App\Interfaces;

interface SubCategoryInterface
{
    public function getAllByCategoryId(int $categoryId);
    public function getAll();
}