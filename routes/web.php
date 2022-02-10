<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Users\HomeController;
use App\Http\Controllers\Users\PostController as UserPostController;
use App\Http\Controllers\Users\UserCategoryController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
|
*/
Route::get('lang/{lang}', [
    'as' => 'lang.switch',
    'uses' => 'LanguageController@switchLang']);

Auth::routes();

Route::get('/', 'Users\HomeController@show')->name('home.index');
Route::get('/show/{id}', 'Users\HomeController@show')->name('home.category');
Route::get('/search', 'Users\HomeController@search')->name('home.search');

Route::get('/category/show/{id}', 'Users\UserCategoryController@show')->name('userCategory.show');
Route::get('/category/showCategory/{id}', 'Users\UserCategoryController@showCategory')->name('userCategory.showCategory');

Route::get('/show/{id}', 'Users\UserPostController@show')->name('userPost.show');

// ==================================== ADMIN ====================================
$prefix_admin = 'admin';
Route::prefix($prefix_admin)->middleware('is_admin')->group(function ()
{
    Route::get("/", [
        "as" => 'admin.index',
        "uses" => 'Admin\AdminController@index',
    ]);
    // ------------------------------- Admin Post ---------------------------------
    Route::get("/admin/post", [
        "as" => 'post.index',
        "uses" => 'Admin\PostController@index',
    ]);
    Route::get("/admin/create", [
        "as" => 'post.create',
        "uses" => 'Admin\PostController@create',
    ]);
    Route::post("/admin/store", [
        "as" => 'post.store',
        "uses" => 'Admin\PostController@store',
    ]);
    Route::get("/admin/show/{id}", [
        "as" => 'post.show',
        "uses" => 'Admin\PostController@show',
    ]);
    Route::get("admin/edit/{post_id}", [
        "as" => 'post.edit',
        "uses" => 'Admin\PostController@edit',
    ]);
    Route::put("admin/update/{id}", [
        "as" => 'post.update',
        "uses" => 'Admin\PostController@update',
    ]);
    Route::delete("admin/delete/{id}", [
        "as" => 'post.destroy',
        "uses" => 'Admin\PostController@destroy',
    ]);
    Route::delete("admin/deleteAll", [
        "as" => 'post.deleteAll',
        "uses" => 'Admin\PostController@deleteAll',
    ]);
    Route::get("admin/post/search/", [
        "as" => 'post.search',
        "uses" => 'Admin\PostController@search',
    ]);
    // ------------------------------- Admin User ---------------------------------
    Route::get("admin/user", [
        "as" => 'user.index',
        "uses" => 'Admin\UserController@index',
    ]);
    Route::get("admin/user/create/", [
        "as" => 'user.create',
        "uses" => 'Admin\UserController@create',
    ]);
    Route::post("admin/user/store", [
        "as" => 'user.store',
        "uses" => 'Admin\UserController@store',
    ]);
    Route::get("admin/user/show/{id}", [
        "as" => 'user.show',
        "uses" => 'Admin\UserController@show',
    ]);
    Route::get("admin/user/edit/{id}", [
        "as" => 'user.edit',
        "uses" => 'Admin\UserController@edit',
    ]);
    Route::put("admin/user/update/{id}", [
        "as" => 'user.update',
        "uses" => 'Admin\UserController@update',
    ]);
    Route::delete("admin/user/delete/{id}", [
        "as" => 'user.destroy',
        "uses" => 'Admin\UserController@destroy',
    ]);
    Route::delete("admin/user/deleteAll", [
        "as" => 'user.deleteAll',
        "uses" => 'Admin\UserController@deleteAll',
    ]);
    Route::get("admin/user/search/", [
        "as" => 'user.search',
        "uses" => 'Admin\UserController@search',
    ]);
    // ------------------------------- Admin Category ---------------------------------
    Route::get("admin/category", [
        "as" => 'category.index',
        "uses" => 'Admin\CategoryController@index',
    ]);
    Route::get("admin/category/create/", [
        "as" => 'category.create',
        "uses" => 'Admin\CategoryController@create',
    ]);
    Route::get("admin/categorySub", [
        "as" => 'categorysub.create',
        "uses" => 'Admin\CategoryController@createSubCategory',
    ]);
    Route::post("admin/category/store", [
        "as" => 'category.store',
        "uses" => 'Admin\CategoryController@store',
    ]);
    Route::get("admin/category/show/{id}", [
        "as" => 'category.show',
        "uses" => 'Admin\CategoryController@show',
    ]);
    Route::get("admin/category/edit/{post_id}", [
        "as" => 'category.edit',
        "uses" => 'Admin\CategoryController@edit',
    ]);
    Route::put("admin/category/update/{id}", [
        "as" => 'category.update',
        "uses" => 'Admin\CategoryController@update',
    ]);
    Route::delete("admin/category/delete/{id}", [
        "as" => 'category.destroy',
        "uses" => 'Admin\CategoryController@destroy',
    ]);
    Route::delete("admin/category/deleteAll", [
        "as" => 'category.deleteAll',
        "uses" => 'Admin\CategoryController@deleteAll',
    ]);
    Route::get("admin/category/search/", [
        "as" => 'category.search',
        "uses" => 'Admin\CategoryController@search',
    ]);
});
