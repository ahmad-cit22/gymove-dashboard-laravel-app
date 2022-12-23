<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Size;
use App\Models\SubCategory;
use App\Models\Thumbnail;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    function index()
    {
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $products = Product::all();
        $latest_products = Product::latest()->get();
        $colors = Color::all();
        $sizes = Size::all();
        return view('frontend.index', [
            'categories' => $categories,
            'subCategories' => $subCategories,
            'products' => $products,
            'latest_products' => $latest_products,
            'colors' => $colors,
            'sizes' => $sizes,
        ]);
    }

    function product_single_view($slug)
    {
        $product_details = Product::where('slug', $slug)->get();
        $similar_products = Product::where('product_category', $product_details->first()->product_category)->where('id', '!=', $product_details->first()->id)->get();
        $available_colors = Inventory::where('product_id', $product_details->first()->id)->groupBy('color_id')
            ->selectRaw('sum(color_id) as sum, color_id')
            ->get();
        $available_sizes = Inventory::where('product_id', $product_details->first()->id)->groupBy('size_id')
            ->selectRaw('sum(size_id) as sum, size_id')
            ->get();
        $thumbnails = Thumbnail::where('product_id', $product_details->first()->id)->get();
        return view('frontend.product_details', [
            'product_details' => $product_details,
            'thumbnails' => $thumbnails,
            'similar_products' => $similar_products,
            'available_colors' => $available_colors,
            'available_sizes' => $available_sizes,
        ]);
    }

    function get_product_size(Request $request)
    {
        $product_id = $request->product_id;
        $color_id = $request->color_id;

        $available_sizes = Inventory::where('product_id', $product_id)->where('color_id', $color_id)->get();
        $str = '';
        foreach ($available_sizes as $size) {
            $str .=  '<div class="form-check size-option form-option form-check-inline mb-2">
                                    <input class="form-check-input" type="radio" name="size" value="' . $size->size_id . '" id="size' . $size->size_id . '">
                                    <label class="form-option-label" for="size' . $size->size_id . '">' . $size->rel_to_size->size_name . '</label>
                                </div>';
        };
        return $str;
    }
}
