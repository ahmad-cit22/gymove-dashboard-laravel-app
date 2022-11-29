<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\SubCategory;
use App\Models\Thumbnail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    function product_add_view()
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
        $request->validate(
            [
                'product_category' => 'required',
                'product_subcategory' => 'required',
                'product_name' => 'required|regex:/^[a-zA-Z\s]+$/',
                'price' => 'required|numeric',
                'discount' => 'numeric',
                'short_description' => 'required',
                'preview' => 'required|mimes:png,jpg,jpeg,gif,webp|max:5120',
                'thumbnails' => 'required',
                'thumbnails.*' => 'mimes:png,jpg,jpeg,gif,webp|max:5120',
            ],
            [
                'product_name.regex' => "Product name can't contain numbers!",
            ]
        );

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
        Image::make($uploaded_img)->resize(470, 580)->save(public_path('uploads/productPreview/' . $img_name));

        Product::find($product_id)->update([
            'preview' => $img_name
        ]);

        $thumbnails = $request->thumbnails;
        foreach ($thumbnails as $thumbnail) {
            $img_ext = $thumbnail->getClientOriginalExtension();
            $img_name = Str::lower(str_replace(' ', '-', $request->product_name)) . '-' . rand(100000, 999999) . '.' . $img_ext;
            Image::make($thumbnail)->resize(470, 580)->save(public_path('uploads/thumbnails/' . $img_name));

            Thumbnail::insert([
                'product_id' => $product_id,
                'thumbnail' => $img_name,
                'created_at' => Carbon::now(),
            ]);
        }

        return back()->with('addSuccess', 'Product Added Successfully!');
    }


    function product_list_view()
    {
        $products = Product::all();
        $trashed_products = Product::onlyTrashed()->get();
        return view('admin.products.product_list', [
            'products' => $products,
            'trashed_products' => $trashed_products,
        ]);
    }

    function product_delete($product_id)
    {
        Product::find($product_id)->delete();
        return back()->with('delSuccess', 'Product deleted successfully!');
    }

    function product_restore($product_id)
    {
        Product::onlyTrashed()->find($product_id)->restore();
        return back()->with('restoreSuccess', 'Product restored successfully!');
    }

    function product_delete_force($product_id)
    {
        $preview_img = Product::find($product_id)->preview;
        $preview_path = public_path('uploads/productPreview/' . $preview_img);
        unlink($preview_path);

        $thumbnails = Thumbnail::where('product_id', $product_id)->get();
        foreach ($thumbnails as $key => $thumbnail) {
            $thumb = $thumbnail->thumbnail;
            $thumbnail_path = public_path('uploads/thumbnails/' . $thumb);
            unlink($thumbnail_path);
        }
        Product::find($product_id)->delete();
        return back()->with('fDelSuccess', 'Product deleted permanently!');
    }

    function product_inventory_view($product_id)
    {
        $product = Product::find($product_id);
        return view('admin.products.product_inventory', [
            'product' => $product
        ]);
    }
   
    function inventory_store($product_id)
    {
        // $product = Product::find($product_id);
        // return view('admin.products.product_inventory', [
        //     'product' => $product
        // ]);
    }



    function product_variation_view()
    {
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.products.variation', [
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes,
        ]);
    }

    function color_store(Request $request)
    {
        $request->validate(
            [
                'color_name' => 'required|regex:/^[a-zA-Z\s]+$/',
                'color_code' => 'required',
            ],
            [
                'color_name.regex' => "Color name can't contain numbers!",
            ]
        );

        Color::insert([
            'color_name' => $request->color_name,
            'color_code' => $request->color_code,
            'created_at' => Carbon::now(),
        ]);

        return back()->with('addSuccess', 'Color Added Successfully!');
    }

    function size_store(Request $request)
    {
        $request->validate(
            [
                'size_name' => 'required',
            ]
        );

        Size::insert([
            'size_name' => $request->size_name,
            'created_at' => Carbon::now(),
        ]);

        return back()->with('addSuccessSize', 'Size Added Successfully!');
    }
}
