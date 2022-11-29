<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\frontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Routing\Events\Routing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/blog', [frontendController::class, 'blog']);
Route::get('/services', [frontendController::class, 'services']);

Auth::routes();

//home routes
Route::get('/home', [HomeController::class, 'index'])->name('home');

//user related routes
Route::get('/users', [UserController::class, 'users'])->name('users');
Route::get('/users/delete/{user_id}', [UserController::class, 'user_delete'])->name('user.delete');

//profile related routes
Route::get('/profile', [UserController::class, 'profile'])->name('profile');
Route::post('/profile/update', [UserController::class, 'profile_update'])->name('profile.update');
Route::post('/profile/update/password', [UserController::class, 'password_update'])->name('pass.update');
Route::post('/profile/update/profile-picture', [UserController::class, 'picture_update'])->name('picture.update');
Route::post('/profile/update/cover-photo', [UserController::class, 'cover_photo_update'])->name('cover.photo.update');

//category related routes
Route::get('/category', [CategoryController::class, 'category'])->name('categories');
Route::post('/category/store', [CategoryController::class, 'category_store'])->name('category.store');
Route::get('/category/delete/{category_id}', [CategoryController::class, 'category_delete'])->name('category.delete');
Route::get('/category/restore/{category_id}', [CategoryController::class, 'category_restore'])->name('category.restore');
Route::get('/category/force-delete/{category_id}', [CategoryController::class, 'category_delete_force'])->name('category.delete.force');
Route::get('/category/edit/{category_id}', [CategoryController::class, 'category_edit_view'])->name('category.edit.view');
Route::post('/category/edit', [CategoryController::class, 'category_edit'])->name('category.edit');

//sub-category related routes
Route::get('/category/sub-category', [SubCategoryController::class, 'subCategory'])->name('subCategories');
Route::post('/category/sub-category/store', [SubCategoryController::class, 'subcategory_store'])->name('subCategory.store');
Route::get('/category/sub-category/delete/{subCategory_id}', [SubCategoryController::class, 'subcategory_delete'])->name('subCategory.delete');
Route::get('/category/sub-category/force-delete/{subCategory_id}', [SubCategoryController::class, 'subcategory_force_delete'])->name('subCategory.delete.force');
Route::get('/category/sub-category/restore/{subCategory_id}', [SubCategoryController::class, 'subcategory_restore'])->name('subCategory.restore');
Route::get('/category/sub-category/edit/{subCategory_id}', [SubCategoryController::class, 'subCategory_edit_view'])->name('subCategory.edit');
Route::post('/category/sub-category/update/{subCategory_id}', [SubCategoryController::class, 'subCategory_update'])->name('subCategory.update');

//product related routes
Route::get('/products/add-new-product', [ProductController::class, 'product_add_view'])->name('product.add');
Route::post('/getSubcategory', [ProductController::class, 'get_subcategory']);
Route::post('/products/store', [ProductController::class, 'product_store'])->name('product.store');
Route::get('/products/list', [ProductController::class, 'product_list_view'])->name('product.list');
Route::get('/products/delete/{product_id}', [ProductController::class, 'product_delete'])->name('product.delete');
Route::get('/products/force-delete/{product_id}', [ProductController::class, 'product_delete_force'])->name('product.delete.force');
Route::get('/products/restore/{product_id}', [ProductController::class, 'product_restore'])->name('product.restore');
Route::get('/products/inventory/{product_id}', [ProductController::class, 'product_inventory_view'])->name('product.inventory');
Route::get('/products/inventory/store', [ProductController::class, 'inventory_store'])->name('inventory.store');

Route::get('/products/variation', [ProductController::class, 'product_variation_view'])->name('product.variation');
Route::post('/colors/store', [ProductController::class, 'color_store'])->name('color.store');
Route::post('/sizes/store', [ProductController::class, 'size_store'])->name('size.store');
