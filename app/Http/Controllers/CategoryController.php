<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    function category()
    {
        $categories = Category::all();
        $trashed_categories = Category::onlyTrashed()->get();
        return view('admin.category.category', [
            'categories' => $categories,
            'trashed_categories' => $trashed_categories,
        ]);
    }

    function category_store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:categories',
            'category_image' => 'required|mimes:png,jpg,jpeg,gif,webp|max:1024',
        ]);

        $category_id = Category::insertGetId([
            'category_name' => $request->category_name,
            'added_by' => Auth::id(),
        ]);

        $uploaded_file = $request->category_image;
        $extension = $uploaded_file->getClientOriginalExtension();
        $file_name = Str::lower(str_replace(' ', '-', $request->category_name)) . '-' . rand(100000, 999999) . '.' . $extension;
        Image::make($uploaded_file)->resize(100, 100)->save(public_path('uploads/category/' . $file_name));

        Category::find($category_id)->update([
            'category_image' => $file_name
        ]);

        return back()->with('addSuccess', 'New category added successfully!');
    }

    function category_delete($category_id)
    {
        Category::find($category_id)->delete();
        return back()->with('delSuccess', 'New category deleted successfully!');
    }

    function category_restore($category_id)
    {
        Category::onlyTrashed()->find($category_id)->restore();
        return back()->with('restoreSuccess', 'New category restored successfully!');
    }
}
