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
Route::post('/login', 'API\Auth\LoginController@login');
Route::post('/register', 'API\Auth\RegisterController@register');
Route::get('/news', 'API\NewsController@list')->name('news_list');
Route::get('/categories', 'API\NewsCategoryController@list')->name('news_categories_list');
Route::get('/article/{id}', 'API\NewsController@getArticle')->name('get_article');

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/profile', 'API\UserController@getProfile')->name('user_profile');
    Route::post('/profile', 'API\UserController@updateProfile')->name('update_user_profile');
    Route::get('/logout', 'API\Auth\LoginController@logout')->name('logout');
});
