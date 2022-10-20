<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\frontendController;
use App\Http\Controllers\HomeController;
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

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/users', [UserController::class, 'users'])->name('users');

Route::get('/users/delete/{user_id}', [UserController::class, 'user_delete'])->name('user.delete');

Route::get('/profile', [UserController::class, 'profile'])->name('profile');
Route::post('/profile/update', [UserController::class, 'profile_update'])->name('profile.update');
Route::post('/profile/update/password', [UserController::class, 'password_update'])->name('pass.update');
Route::post('/profile/update/profile-picture', [UserController::class, 'picture_update'])->name('picture.update');
Route::post('/profile/update/cover-photo', [UserController::class, 'cover_photo_update'])->name('cover.photo.update');

Route::get('/category', [CategoryController::class, 'category'])->name('categories');
Route::post('/category/store', [CategoryController::class, 'category_store'])->name('category.store');
Route::get('/category/delete/{category_id}', [CategoryController::class, 'category_delete'])->name('category.delete');
Route::get('/category/restore/{category_id}', [CategoryController::class, 'category_restore'])->name('category.restore');
