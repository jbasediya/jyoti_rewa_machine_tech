<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\HomeController;






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
    return view('/auth.login');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    // Route::get('/home', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('home');
    //Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/admin/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/admin/products/index', [ProductController::class, 'index'])->name('products.index');
    Route::get('/admin/products/edit/{product}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/admin/products/update/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/admin/products/delete/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    //Export Product
    Route::get('/admin/products/export', [ProductController::class, 'export'])->name('products.export');
    //Import Product
    Route::post('/admin/products/import', [ProductController::class, 'import'])->name('products.import');
});

Route::group(['middleware' => ['auth', 'role:vendor']], function () {
    Route::get('/vendor', [VendorController::class, 'index']);
});

Route::group(['middleware' => ['auth', 'role:customer']], function () {
    Route::get('/customer/index', [CustomerController::class, 'index']);
    Route::get('/customer/product_list', [CustomerController::class, 'product_list'])->name('customer.product_list');
    Route::get('/customer/single_product', [CustomerController::class, 'single_product'])->name('customer.single_product');
    Route::resource('orders', OrderController::class);

});