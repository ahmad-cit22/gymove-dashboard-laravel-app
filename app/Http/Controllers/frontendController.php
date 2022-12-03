<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    function index()
    {
        $categories = Category::all();
        $top_categories = Category::take(8)->get();
        $subCategories = SubCategory::all();
        $products = Product::all();
        $colors = Color::all();
        $sizes = Size::all();
        return view('frontend.index', [
            'categories' => $categories,
            'top_categories' => $top_categories,
            'subCategories' => $subCategories,
            'products' => $products,
            'colors' => $colors,
            'sizes' => $sizes,
        ]);
    }
}
