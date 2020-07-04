<?php

namespace App\Interfaces;

use App\Http\Requests\ProductCategoryRequest;

interface ProductCategoryInterface
{
    public function getAllProductCategories();

    public function getProductCategoryBySlug($slug);

    public function requestUser(ProductCategoryRequest $request, $id = null);

    public function deleteProductCategory($id);
}
