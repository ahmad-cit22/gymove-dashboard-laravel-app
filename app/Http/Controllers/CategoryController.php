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
        $category_name_lower = Str::lower(str_replace(' ', '-', $request->category_name));
        $file_name = $category_name_lower . '-' . rand(100000, 999999) . '.' . $extension;
        Image::make($uploaded_file)->resize(100, 100)->save(public_path('uploads/category/' . $file_name));

        Category::find($category_id)->update([
            'category_image' => $file_name
        ]);

        return back()->with('addSuccess', 'New category added successfully!');
    }

    function category_delete($category_id)
    {
        Category::find($category_id)->delete();
        return back()->with('delSuccess', 'Category deleted successfully!');
    }

    function category_restore($category_id)
    {
        Category::onlyTrashed()->find($category_id)->restore();
        return back()->with('restoreSuccess', 'Category restored successfully!');
    }

    function category_delete_force($category_id)
    {
        $file_name = Category::onlyTrashed()->find($category_id)->category_image;
        $delete_file_path = public_path('uploads/category/' . $file_name);
        unlink($delete_file_path);
        Category::onlyTrashed()->find($category_id)->forceDelete();
        return back()->with('forceDeleteSuccess', 'Category deleted permanently!');
    }

    function category_edit_view($category_id)
    {
        $category = Category::find($category_id);
        return view('admin.category.edit', [
            'category' => $category,
        ]);
    }

    function category_edit(Request $request)
    {

        if (Category::where('id', $request->category_id)->where('category_name', $request->category_name)->exists()) {
            $request->validate([
                'category_name' => 'required',
            ], [
                'category_name.required' => "You cant leave category name empty!"
            ]);
        } else {
            $request->validate([
                'category_name' => 'required|unique:categories',
            ], [
                'category_name.required' => "You cant leave category name empty!"
            ]);
        }

        if ($request->category_image == '') {
            Category::find($request->category_id)->update([
                'category_name' => $request->category_name,
                'added_by' => Auth::id(),
            ]);
            return back()->with('updateSuccess', 'Category updated successfully!');
        } else {
            $request->validate([
                'category_image' => 'required|mimes:png,jpg,jpeg,gif,webp|max:1024',
            ]);

            $old_image_name = Category::find($request->category_id)->category_image;
            $old_image_path = public_path('uploads/category/' . $old_image_name);
            unlink($old_image_path);

            $uploaded_file = $request->category_image;
            $extension = $uploaded_file->getClientOriginalExtension();
            $category_name_lower = Str::lower(str_replace(' ', '-', $request->category_name));
            $new_img_name = $category_name_lower . '-' . rand(100000, 999999) . '.' . $extension;
            Image::make($uploaded_file)->resize(100, 100)->save(public_path('uploads/category/' . $new_img_name));

            Category::find($request->category_id)->update([
                'category_name' => $request->category_name,
                'category_image' => $new_img_name,
                'added_by' => Auth::id(),
            ]);
            return back()->with('updateSuccess', 'Category updated successfully!');
        }
    }
}
