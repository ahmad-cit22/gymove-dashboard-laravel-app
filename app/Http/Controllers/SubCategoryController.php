<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class SubCategoryController extends Controller
{
    function subCategory()
    {
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $trashedSubCategories = SubCategory::onlyTrashed()->get();
        return view('admin.subCategory.subCategory', [
            'categories' => $categories,
            'subCategories' => $subCategories,
            'trashedSubCategories' => $trashedSubCategories,
        ]);
    }

    function subcategory_store(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
            'subcategory_name' => 'required|unique:sub_categories',
            'subcategory_image' => 'required|mimes:png,jpg,jpeg,webp,gif|max:1024',
        ]);

        $subcategory_id = SubCategory::insertGetId([
            'category_id' => $request->category_name,
            'subcategory_name' => $request->subcategory_name,
            'added_by' => Auth::id(),
            'created_at' => Carbon::now(),
        ]);

        $uploaded_file = $request->subcategory_image;
        $img_ext = $uploaded_file->getClientOriginalExtension();
        $name_lower = Str::lower(str_replace(' ', '-', $request->subcategory_name));
        $img_name = $name_lower . '-' . rand(100000, 999999) . '.' . $img_ext;
        echo $img_name;

        Image::make($uploaded_file)->resize(100, 100)->save(public_path('uploads/subCategory/' . $img_name));

        SubCategory::find($subcategory_id)->update([
            'subcategory_image' => $img_name,
        ]);

        return back()->with('addSuccess', 'New sub-category added successfully!');
    }

    function subCategory_delete($subCategory_id)
    {
        SubCategory::find($subCategory_id)->delete();
        return back()->with('delSuccess', 'Sub-category deleted successfully!');
    }

    function subcategory_restore($subCategory_id)
    {
        SubCategory::onlyTrashed()->find($subCategory_id)->restore();
        return back()->with('restoreSuccess', 'Sub-category restored permanently!');
    }

    function subcategory_force_delete($subCategory_id)
    {
        $img_name = SubCategory::onlyTrashed()->find($subCategory_id)->subcategory_image;
        $img_path = public_path('uploads/subCategory/' . $img_name);
        unlink($img_path);
        SubCategory::onlyTrashed()->find($subCategory_id)->forceDelete();
        return back()->with('forceDelSuccess', 'Sub-category deleted permanently!');
    }

    function subCategory_edit_view($subCategory_id)
    {
        $categories = Category::all();
        $subCategory = SubCategory::find($subCategory_id);
        return view('admin.subCategory.edit', [
            'categories' => $categories,
            'subCategory' => $subCategory,
        ]);
    }

    function subCategory_update(Request $request, $subCategory_id)
    {
        $request->validate([
            'category_name' => 'required',
        ]);

        if (SubCategory::where('id', $subCategory_id)->where('subcategory_name', $request->subcategory_name)->exists()) {
            $request->validate([
                'subcategory_name' => 'required',
            ]);
        } else {
            $request->validate([
                'subcategory_name' => 'required|unique:sub_categories',
            ]);
        }

        if ($request->subcategory_image == '') {
            SubCategory::find($subCategory_id)->update([
                'category_id' => $request->category_name,
                'subcategory_name' => $request->subcategory_name,
                'added_by' => Auth::id(),
            ]);
            return back()->with('updateSuccess', 'Category updated successfully!');
        } else {
            $request->validate([
                'subcategory_image' => 'required|mimes:png,jpg,jpeg,webp,gif|max:1024'
            ]);

            $old_img_name = SubCategory::find($subCategory_id)->subcategory_image;
            $old_img_path = public_path('uploads/subCategory/' . $old_img_name);
            unlink($old_img_path);

            $uploaded_file = $request->subcategory_image;
            $img_ext = $uploaded_file->getClientOriginalExtension();
            $name_lower = Str::lower(str_replace(' ', '-', $request->subcategory_name));
            $new_img_name = $name_lower . '-' . rand(100000, 999999) . '.' . $img_ext;
            Image::make($uploaded_file)->resize(100, 100)->save(public_path('uploads/subCategory/' . $new_img_name));
            echo $new_img_name;
            SubCategory::find($subCategory_id)->update([
                'category_id' => $request->category_name,
                'subcategory_name' => $request->subcategory_name,
                'subcategory_image' => $new_img_name,
                'added_by' => Auth::id(),
            ]);
            return back()->with('updateSuccess', 'Sub-category updated successfully!');
        }
    }
}

