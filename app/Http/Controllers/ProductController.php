<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Inventory;
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
                // 'discount' => 'numeric',
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
        Image::make($uploaded_img)->resize(470, '')->save(public_path('uploads/productPreview/' . $img_name));

        Product::find($product_id)->update([
            'preview' => $img_name
        ]);

        $thumbnails = $request->thumbnails;
        foreach ($thumbnails as $thumbnail) {
            $img_ext = $thumbnail->getClientOriginalExtension();
            $img_name = Str::lower(str_replace(' ', '-', $request->product_name)) . '-' . rand(100000, 999999) . '.' . $img_ext;
            Image::make($thumbnail)->resize(470, '')->save(public_path('uploads/thumbnails/' . $img_name));

            Thumbnail::insert([
                'product_id' => $product_id,
                'thumbnail' => $img_name,
                'created_at' => Carbon::now(),
            ]);
        }

        return back()->with('addSuccess', 'Product Added Successfully!');
    }


    // function filter_products(Request $request)
    // {
    //     $category_id = $request->category_id;
    //     $filtered_products = Product::where('category_id', $category_id)->get();
    //     $str = '';
    //     foreach ($filtered_products as $key => $product) {
    //         $str .= '<tr>
    //                                 <td>{{ $key + 1 }}</td>
    //                                 <td>{{ $product->rel_to_subcategory->subcategory_name }}</td>
    //                                 <td>{{ $product->product_name }}</td>
    //                                 <td>{{ $product->price }}</td>
    //                                 <td>{{ $product->discount }}</td>
    //                                 <td>{{ $product->after_discount }}</td>
    //                                 <td>{{ $product->brand }}</td>
    //                                 <td>
    //                                     <img src="'. asset('uploads/productPreview/' . $product->preview) ."
    //                                         alt="preview_img" width="70">
    //                                 </td>
    //                                 <td class="d-flex" style="align-items: center; height: 100px;">
    //                                     @foreach (App\Models\Thumbnail::where('product_id', $product->id)->get() as $thumb)
    //                                         <img class="ml-1"
    //                                             src="{{ asset('uploads/thumbnails/' . $thumb->thumbnail) }}"
    //                                             alt="thumbnail" width="40">
    //                                     @endforeach
    //                                 </td>
    //                                 <td>
    //                                     <div class="dropdown">
    //                                         <button type="button" class="btn btn-primary light sharp"
    //                                             data-toggle="dropdown">
    //                                             <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1">
    //                                                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
    //                                                     <rect x="0" y="0" width="24" height="24" />
    //                                                     <circle fill="#000000" cx="5" cy="12"
    //                                                         r="2" />
    //                                                     <circle fill="#000000" cx="12" cy="12"
    //                                                         r="2" />
    //                                                     <circle fill="#000000" cx="19" cy="12"
    //                                                         r="2" />
    //                                                 </g>
    //                                             </svg>
    //                                         </button>
    //                                         <div class="dropdown-menu">
    //                                             <a class="dropdown-item"
    //                                                 href="{{ route('product.inventory', $product->id) }}">Inventory</a>
    //                                             <a class="dropdown-item" href="">Edit</a>
    //                                             <a class="dropdown-item"
    //                                                 href="{{ route('product.delete', $product->id) }}">Delete</a>
    //                                         </div>
    //                                     </div>
    //                                 </td>
    //                             </tr>';
    //     }
    //     return $str;
    // }
    
    function product_list_view()
    {
        $products = Product::all();
        $trashed_products = Product::onlyTrashed()->get();
        $categories = Category::all();
        return view('admin.products.product_list', [
            'products' => $products,
            'trashed_products' => $trashed_products,
            'categories' => $categories,
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
        $preview_img = Product::onlyTrashed()->find($product_id)->preview;
        $preview_path = public_path('uploads/productPreview/' . $preview_img);
        unlink($preview_path);

        $thumbnails = Thumbnail::where('product_id', $product_id)->get();
        foreach ($thumbnails as $key => $thumbnail) {
            $thumb = $thumbnail->thumbnail;
            $thumbnail_path = public_path('uploads/thumbnails/' . $thumb);
            unlink($thumbnail_path);
        }
        Product::onlyTrashed()->find($product_id)->forceDelete();
        return back()->with('fDelSuccess', 'Product deleted permanently!');
    }

    function product_inventory_view($product_id)
    {
        $product = Product::find($product_id);
        $colors = Color::all();
        $sizes = Size::all();
        $inventories = Inventory::where('product_id', $product_id)->get();
        return view('admin.products.product_inventory', [
            'product' => $product,
            'colors' => $colors,
            'sizes' => $sizes,
            'inventories' => $inventories,
        ]);
    }

    function inventory_store(Request $request, $product_id)
    {
        $request->validate(
            [
                'color' => 'required',
                'size' => 'required',
                'quantity' => 'required',
            ],
            [
                'color.required' => "You must select a color!",
                'size.required' => "You must select a size!",
                'quantity.required' => "You must enter the quantity!",
            ]
        );

        Inventory::insert([
            'product_id' => $product_id,
            'color_id' => $request->color,
            'size_id' => $request->size,
            'quantity' => $request->quantity,
            'created_at' => Carbon::now(),
        ]);

        return back()->with('InventoryAddSuccess', 'Inventory Added Successfully!');
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
                // 'color_name' => 'required|regex:/^[a-zA-Z\s]+$/',
                'color_name' => 'required',
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
