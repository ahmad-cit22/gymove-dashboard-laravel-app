<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    function product_view()
    {
        $categories = Category::all();
        return view('admin.products.add', [
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
        $request->validate([
            'product_category' => 'required',
            'product_subcategory' => 'required',
            'product_name' => 'required',
            'price' => 'required|numeric',
            'discount' => 'numeric',
            'short_description' => 'required',
            'preview' => 'required|mimes:png,jpg,jpeg,gif,webp|max:5120',
        ]);

        $product_id = Product::insertGetId([
            'product_category' => $request->product_category,
            'product_subcategory' => $request->product_subcategory,
            'product_name' => $request->product_name,
            'slug' => Str::lower(str_replace(' ', '-', $request->product_name)) . '-' . rand(10000000, 99999999),
            'price' => $request->price,
            'discount' => $request->discount,
            'after_discount' => $request->price - ($request->price * $request->discount / 100),
            'brand' => $request->brand,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'created_at' => Carbon::now(),
        ]);

        $uploaded_img = $request->preview;
        $img_ext = $uploaded_img->getClientOriginalExtension();
        $img_name = Str::lower(str_replace(' ', '-', $request->product_name)) . '-' . rand(100000, 999999) . '.' . $img_ext;
        Image::make($uploaded_img)->resize(100, 100)->save(public_path('uploads/productPreview/' . $img_name));

        Product::find($product_id)->update([
            'preview' => $img_name
        ]);

        return back();
    }
}
