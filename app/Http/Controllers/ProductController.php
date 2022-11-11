<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function product_view()
    {
        $categories = Category::all();
        return view('admin.products.products', [
            'categories' => $categories
        ]);
    }

    function get_subcategory(Request $request)
    {
        $subCategories = SubCategory::where('category_id', $request->category_id)->get();
        $subCategoryStr = "<option value=''> -- Select Sub-category -- </option>";
        foreach ($subCategories as $subCategory) {
            $subCategoryStr .= "<option value='$subCategory->id'> $subCategory->subcategory_name </option>";
        }
        echo $subCategoryStr;
    }

    function product_store(Request $request)
    {
        // $subCategories = SubCategory::where('category_id', $request->category_id)->get();
        // $subCategoryStr = "<option value=''> -- Select Sub-category -- </option>";
        // foreach ($subCategories as $subCategory) {
        //     $subCategoryStr .= "<option value='$subCategory->id'> $subCategory->subcategory_name </option>";
        // }
        // echo $subCategoryStr;
    }
}
