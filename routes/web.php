<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SSLCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;
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

Auth::routes();

//home routes
Route::get('/home', [HomeController::class, 'home'])->name('home');

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
// Route::post('/filterProducts', [ProductController::class, 'filter_products']);
Route::get('/products/list', [ProductController::class, 'product_list_view'])->name('product.list');
Route::get('/products/delete/{product_id}', [ProductController::class, 'product_delete'])->name('product.delete');
Route::get('/products/force-delete/{product_id}', [ProductController::class, 'product_delete_force'])->name('product.delete.force');
Route::get('/products/restore/{product_id}', [ProductController::class, 'product_restore'])->name('product.restore');

Route::get('/products/inventory/{product_id}', [ProductController::class, 'product_inventory_view'])->name('product.inventory');
Route::post('/products/inventory/store/{product_id}', [ProductController::class, 'inventory_store'])->name('inventory.store');

Route::get('/products/variation', [ProductController::class, 'product_variation_view'])->name('product.variation');
Route::post('/colors/store', [ProductController::class, 'color_store'])->name('color.store');
Route::post('/sizes/store', [ProductController::class, 'size_store'])->name('size.store');

//coupon relate routes
Route::get('/coupons', [CouponController::class, 'coupon_view'])->name('coupon.view');
Route::post('/coupons/store', [CouponController::class, 'coupon_store'])->name('coupon.store');
Route::get('/coupons/edit/{coupon_id}', [CouponController::class, 'coupon_edit_view'])->name('coupon.edit');
Route::post('/coupons/update/{coupon_id}', [CouponController::class, 'coupon_update'])->name('coupon.update');
Route::get('/coupons/delete/{coupon_id}', [CouponController::class, 'coupon_delete'])->name('coupon.delete');
Route::get('/coupons/force-delete/{coupon_id}', [CouponController::class, 'coupon_delete_force'])->name('coupon.delete.force');
Route::get('/coupons/restore/{coupon_id}', [CouponController::class, 'coupon_restore'])->name('coupon.restore');

//orders related routes
Route::get('/orders', [OrderController::class, 'orders_view'])->name('orders.view');
Route::post('/order-status/update/{order_id}', [OrderController::class, 'order_status_update'])->name('orderStatus.update');




// frontend pages routes
Route::get('/', [FrontendController::class, 'index']);

//product single view
Route::get('products/details/{slug}', [FrontendController::class, 'product_single_view'])->name('product.single');
Route::post('/getProductSize', [FrontendController::class, 'get_product_size']);
// Route::post('/getQuantity', [FrontendController::class, '/get_quantity']);

// Customer related routes
Route::get('/customer-sign-in-login', [CustomerController::class, 'customer_reg_view'])->name('customer.reg');
Route::post('/customer-reg', [CustomerController::class, 'customer_signup'])->name('customer.signup');
Route::post('/customer/update', [CustomerController::class, 'customer_update'])->name('customer.update');
Route::post('/customer-login', [CustomerController::class, 'customer_login'])->name('customer.login');
Route::get('/customer-logout', [CustomerController::class, 'customer_logout'])->name('customer.logout');
Route::get('/customer/profile/view', [CustomerProfileController::class, 'customer_profile_view'])->name('customer.profile.view');
Route::post('/customer/profile/update', [CustomerProfileController::class, 'customer_profile_update'])->name('customer.profile.update');
Route::get('/customer/orders', [CustomerProfileController::class, 'customer_orders_view'])->name('customer.orders');

Route::get('/customer/password-reset', [CustomerController::class, 'customer_password_reset'])->name('customer.password.reset');
Route::post('/customer/password-reset', [CustomerController::class, 'password_reset'])->name('customer.password.reset');
Route::get('/customer/password-reset/form/{token}', [CustomerController::class, 'password_reset_form'])->name('customer.password.reset.form');
Route::post('/customer/password-reset/form/{token}', [CustomerController::class, 'password_reset_form_handle'])->name('customer.password.reset.handle');


//Cart and Wishlist related routes
Route::post('/cart-wishlist/store/{product_id}', [CartController::class, 'cart_wishlist_store'])->name('cart.wishlist.store');
Route::get('/cart/remove/{cart_id}', [CartController::class, 'cart_remove'])->name('cart.remove');
Route::get('/wishlist/remove/{wish_id}', [CartController::class, 'wish_remove'])->name('wish.remove');
Route::get('/shopping-cart', [CartController::class, 'cart_view'])->name('cart.view');
Route::get('/wishlist', [CartController::class, 'wish_view'])->name('wish.view');
Route::post('/cart/update', [CartController::class, 'cart_update'])->name('cart.update');

//Checkout related routes
Route::get('/checkout-page', [CheckoutController::class, 'checkout_view'])->name('checkout.view');
Route::post('/getCity', [CheckoutController::class, 'getCity']);
Route::post('/order/store', [CheckoutController::class, 'order_store'])->name('order.store');
Route::get('/order/success', [CheckoutController::class, 'order_success'])->name('order.success');

// SSLCOMMERZ Start
// Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
// Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::get('/pay', [SSLCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

Route::controller(StripePaymentController::class)->group(function () {
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});
// //Review
// Route::post('/review/{product_id}', [FrontendController::class, 'review'])->name('review');
