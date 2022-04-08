<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

// Categories
Route::group([
    'prefix' => 'categories'
], function () {
    Route::get('{id}', 'CategoryController@get');
    Route::get('', 'CategoryController@getAll');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('', 'CategoryController@create');
        Route::put('{id}', 'CategoryController@update');
        Route::delete('{id}', 'CategoryController@delete');
    });
});

// Posts
Route::group([
    'prefix' => 'posts'
], function () {
    Route::get('{id}', 'PostController@get');
    Route::get('', 'PostController@getAll');
    Route::get('by-category/{id}', 'PostController@getPostsByCategoryId');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('', 'PostController@create');
        Route::put('{id}', 'PostController@update');
        Route::delete('{id}', 'PostController@delete');
    });
});

// Products
Route::group([
    'prefix' => 'products'
], function () {
    Route::get('{id}', 'ProductController@get');
    Route::get('', 'ProductController@getAll');
    Route::get('by-category/{id}', 'ProductController@getProductsByCategoryId');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('', 'ProductController@create');
        Route::put('{id}', 'ProductController@update');
        Route::delete('{id}', 'ProductController@delete');
    });
});

// Comments
Route::group([
    'prefix' => 'comments'
], function () {
    Route::get('{id}', 'CommentController@get');
    Route::get('', 'CommentController@getAll');
    Route::get('by-post/{id}', 'CommentController@getCommentsByPostId');
    Route::get('by-user/{id}', 'CommentController@getCommentsByUserId');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('', 'CommentController@create');
        Route::put('{id}', 'CommentController@update');
        Route::delete('{id}', 'CommentController@delete');
    });
});

// Users
Route::group([
    'prefix' => 'users',
    'middleware' => 'auth:sanctum'
], function () {
    Route::get('{id}', 'AuthController@get');
    Route::get('', 'AuthController@getAll');
    Route::put('{id}', 'AuthController@update');
    Route::delete('{id}', 'AuthController@delete');
    Route::post('change-password', 'AuthController@changePassword');
});

// Authenticate
Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('renew-forgot-password', 'AuthController@renewForgotPassword');
    Route::post('get-verify-code', 'AuthController@getAuthVerifyCode');

    // login with google
    Route::get('{provider}/url', 'SocialController@socialLoginUrl');
    Route::get('{provider}/callback', 'SocialController@loginSocialCallback');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('logout/all', 'AuthController@logoutAllDevices');
    });
});
