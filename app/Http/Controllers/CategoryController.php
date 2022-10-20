<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function category(){
        return view('admin.category.category');
    }
    
    function category_store(Request $request){
        $request->validate([
            'category_name'=>'required',
            'category_image'=>'required|mimes:png,jpg,jpeg,gif,webp|max:1024',
        ]);
      
    }
}
