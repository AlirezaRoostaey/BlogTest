<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Client\BlogController;
use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;

Route::prefix('v1')->group(function () {

    Route::prefix('auth')
        ->controller(AuthController::class)
        ->group(function () {


        Route::post('/send-otp', 'sendOtp');
        Route::post('/resend-otp', 'reSendOtp');
        Route::post('/verify-otp', 'verifyOtp');
        Route::post('/login', 'login');
        Route::post('/forget-password/send-otp', 'forgetPasswordSendOtp');
        Route::post('/forget-password/verify-otp', 'forgetPasswordVerifyOtp');
    });

    Route::controller(BlogController::class)
        ->group(function () {


            Route::get('/blogs', 'allBlogs');
            Route::get('/blogs/{slug}', 'show');
    });


    Route::controller(CategoryController::class)
        ->group(function () {


            Route::get('/categories', 'allCategories');
            Route::get('/categories/{id}', 'show');
        });

    Route::prefix('admin')
        ->middleware(['auth:sanctum', 'admin'])
        ->group(function () {


            Route::prefix('categories')
                ->controller(AdminCategoryController::class)
                ->group(function () {


                    Route::get('/', 'index');
                    Route::post('/', 'store');
                    Route::get('/{id}', 'show');
                    Route::put('/{id}', 'update');
                    Route::delete('/{id}', 'destroy');
            });


            Route::prefix('blogs')
                ->controller(AdminBlogController::class)
                ->group(function () {


                    Route::get('/', 'index');
                    Route::post('/', 'store');
                    Route::get('/{id}', 'show');
                    Route::put('/{id}', 'update');
                    Route::delete('/{id}', 'destroy');
                    Route::put('/{id}/restore', 'restore');
                });
    });
});





