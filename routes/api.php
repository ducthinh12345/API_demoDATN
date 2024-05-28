<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;


Route::group(['prefix' => 'v1'], function () {
    //Không cần đăng nhập vẫn dùng được
    Route::post('login', [AuthController::class, 'login'])->name('v1.login');
    Route::post('register', [AuthController::class, 'register'])->name('v1.register');

    Route::post('forgotPassword', [AuthController::class, 'forgotPassword'])->name('v1.forgotPassword'); //chua co
    Route::post('resetPassword', [AuthController::class, 'resetPassword'])->name('v1.resetPassword'); //chua co

    Route::group(['prefix' => 'product'], function () {
        Route::get('index', [ProductController::class, 'index'])->name('v1.product.getAllProduct');
    });
    Route::group(['prefix' => 'cart'], function () {
        Route::get('/cart', [CartController::class, 'index'])->name('v1.cart.index');
        Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('v1.cart.add');
        Route::post('/cart/remove/{productId}', [CartController::class, 'remove'])->name('v1.cart.remove');
        Route::post('/cart/update/{productId}', [CartController::class, 'update'])->name('v1.cart.update');
    });


    //không đăng nhập sẽ không dùng được
    Route::group(['prefix' => 'auth'], function () {
        Route::middleware('auth:api')->group(function () {
            Route::get('logout', [AuthController::class, 'logout'])->name('v1.logout');
            Route::get('me', [AuthController::class, 'me'])->name('auth.v1.me');

            Route::get('detail/{id}', [ProductController::class, 'show'])->name('v1.auth.user.getProductDetail');
            // Là admin mới dùng được
            Route::middleware('admin')->group(function () {
                Route::group(['prefix' => 'product'], function () {
                    Route::post('created', [ProductController::class, 'create'])->name('v1.auth.admin.product.createProduct');
                    Route::post('destroy', [ProductController::class, 'destroy'])->name('v1.auth.admin.product.destroyProduct');
                    Route::post('update', [ProductController::class, 'update'])->name('v1.auth.admin.updateProduct');
                });
                Route::group(['prefix' => 'productType'], function () {
                    Route::post('addProductTypes', [ProductController::class, 'addProductTypes'])->name('v1.auth.admin.productType.addProductTypes');
                    Route::post('destroyProductTypes', [ProductController::class, 'destroyProductTypes'])->name('v1.auth.admin.productType.destroyProductTypes');
                    Route::post('updateProductTypes', [ProductController::class, 'updateProductTypes'])->name('v1.auth.admin.productType.updateProductTypes');
                });
            });
        });
    });
});
