<?php

namespace App\Repositories;

use App\Http\Requests\ProductCategoryRequest;
use App\Interfaces\ProductCategoryInterface;
use App\Models\ProductCategory;
use App\Traits\ResponseAPI;
use Illuminate\Support\Facades\DB;

class ProductCategoryRepository implements ProductCategoryInterface
{
    use ResponseAPI;

    public function getAllProductCategories()
    {
        try {
            $productCategories = ProductCategory::all();
            return $this->success("All Product Categories", $productCategories);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getProductCategoryBySlug($slug)
    {
        try {
            $productCategory = ProductCategory::findBySlug($slug);
            if (!$productCategory) return $this->error("No Product Category with slug $slug", 404);
            return $this->success("Product Category Detail", $productCategory);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function requestUser(ProductCategoryRequest $request, $id = null)
    {
        DB::beginTransaction();
        try {
            $productCategory = $id ? ProductCategory::find($id) : new ProductCategory();

            if ($id && !$productCategory) return $this->error("No Product Category with ID $id", 404);

            $productCategory->name = $request->name;
            $productCategory->save();
            DB::commit();
            return $this->success(
                $id ? "Product Category Updated" : "Product Category Created",
                $productCategory,
                $id ? 200 : 201
            );
        } catch (\Exception $e) {
            DB::rollback();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function deleteProductCategory($id)
    {
        DB::beginTransaction();
        try {
            $productCategory = ProductCategory::find($id);
            if (!$productCategory) return $this->error("No Product Category with ID $id");
            $productCategory->delete();
            DB::commit();
            return $this->success("Product Category Deleted", $productCategory);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
