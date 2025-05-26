<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\Sub_CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SliderController;

//
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\productController as productFront;
use App\Http\Controllers\PaymentController;


Route::get('admin', [AuthController::class, 'login_admin']);
Route::post('admin', [AuthController::class, 'auth_login_admin']);
Route::get('admin/logout', [AuthController::class, 'logout_admin']);



Route::get('admin/dashboard', [DashboardController::class, 'dashboard']);
//Route::get('admin/dashboard', function () {
//   return view('admin.dashboard');
//});

Route::get('admin/admin/list', function () {
    $data['header_title'] = "Admin";
    return view('admin.admin.list', $data);
});
//
Route::get('admin/orders/list', [OrderController::class, 'list']);

Route::get('admin/category/list', [CategoryController::class, 'list']);
Route::get('admin/category/add', [CategoryController::class, 'add']);
Route::post('admin/category/add', [CategoryController::class, 'insert']);
Route::get('admin/category/edit/{id}', [CategoryController::class, 'edit']);
Route::post('admin/category/edit/{id}', [CategoryController::class, 'update']);
Route::get('admin/category/delete/{id}', [CategoryController::class, 'delete']);
//
Route::get('admin/sub_category/list', [Sub_CategoryController::class, 'list']);
Route::get('admin/sub_category/add', [Sub_CategoryController::class, 'add']);
Route::post('admin/sub_category/add', [Sub_CategoryController::class, 'insert']);
Route::get('admin/sub_category/edit/{id}', [Sub_CategoryController::class, 'edit']);
Route::post('admin/sub_category/edit/{id}', [Sub_CategoryController::class, 'update']);
Route::get('admin/sub_category/delete/{id}', [Sub_CategoryController::class, 'delete']);
Route::post('admin/get_sub_category', [Sub_CategoryController::class, 'get_sub_category']);
//
Route::get('admin/brand/list', [BrandController::class, 'list']);
Route::get('admin/brand/add', [BrandController::class, 'add']);
Route::post('admin/brand/add', [BrandController::class, 'insert']);
Route::get('admin/brand/edit/{id}', [BrandController::class, 'edit']);
Route::post('admin/brand/edit/{id}', [BrandController::class, 'update']);
Route::get('admin/brand/delete/{id}', [BrandController::class, 'delete']);
//
Route::get('admin/color/list', [ColorController::class, 'list']);
Route::get('admin/color/add', [ColorController::class, 'add']);
Route::post('admin/color/add', [ColorController::class, 'insert']);
Route::get('admin/color/edit/{id}', [ColorController::class, 'edit']);
Route::post('admin/color/edit/{id}', [ColorController::class, 'update']);
Route::get('admin/color/delete/{id}', [ColorController::class, 'delete']);
//
Route::get('admin/product/list', [ProductController::class, 'list']);
Route::get('admin/product/add', [ProductController::class, 'add']);
Route::post('admin/product/add', [ProductController::class, 'insert']);
Route::get('admin/product/edit/{id}', [ProductController::class, 'edit']);
Route::post('admin/product/edit/{id}', [ProductController::class, 'update']);
Route::get('admin/product/delete/{id}', [ProductController::class, 'delete']);

Route::get('admin/product/image_delete/{id}', [ProductController::class, 'image_delete']);

Route::get('admin/slider/list', [SliderController::class, 'list']);
Route::get('admin/slider/add', [SliderController::class, 'add']);
Route::post('admin/slider/add', [SliderController::class, 'insert']);
Route::get('admin/slider/edit/{id}', [SliderController::class, 'edit']);
Route::post('admin/slider/edit/{id}', [SliderController::class, 'update']);
Route::get('admin/slider/delete/{id}', [SliderController::class, 'delete']);




//
Route::get('/', [HomeController::class,'home']);
Route::post('auth_register', [AuthController::class, 'auth_register']);
Route::post('auth_login', [AuthController::class, 'auth_login']);


//
Route::get('checkout', [PaymentController::class, 'checkout']);
Route::get('cart', [PaymentController ::class,'cart']);
Route::post('update_cart', [PaymentController ::class,'update_cart']);

Route::get('cart/delete/{id}', [PaymentController ::class,'cart_delete']);

Route::post('product/add-to-cart', [PaymentController ::class,'add_to_cart']);
Route::get('search', [productFront ::class,'getProductSearch']);//  من أجل البحث routeهذا ال   
Route::post('get_filter_product_ajax', [productFront ::class,'getFilterProductAjax']);
Route::get('{category?}/{subcategory?}', [productFront ::class,'getCategory']);

Route::post('checkout/place_order', [PaymentController::class, 'place_order']);