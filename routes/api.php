<?php

use Illuminate\Http\Request;
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


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('aws-upload', 'HelloController@AwsUploadFile');

// Route::post("login", "AuthController@userLogin");

Route::post('signup', 'AuthController@register');
Route::post('login', 'AuthController@login');



Route::group([

    'middleware' => 'auth:api',
    'prefix' => 'auth'

], function () {
    Route::auth();

    // Route::post('login', 'LoginController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::get('details', 'AuthController@details');
    Route::get("user/{email}", "AuthController@userDetail");
});

//Users
Route::get('list-users', 'UserController@listUsers');
Route::get('get-user', 'UserController@getUser');
Route::post('add-user', 'UserController@addUser');
Route::put('edit-user', 'UserController@editUser');
Route::delete('delete-user', 'UserController@deleteUser');

//Countries
Route::get('list-countries', 'CountryController@listCountries');
Route::get('get-country', 'CountryController@getCountry');
Route::post('add-country', 'CountryController@addCountry');
Route::put('edit-country', 'CountryController@editCountry');
Route::delete('delete-country', 'CountryController@deleteCountry');

//States
Route::get('list-states', 'StateController@listStates');
Route::get('get-state', 'StateController@getState');
Route::post('add-state', 'StateController@addState');
Route::put('edit-state', 'StateController@editState');
Route::delete('delete-state', 'StateController@deleteState');

//Categories
Route::get('list-categories', 'CategoryController@listCategories');
Route::get('get-category', 'CategoryController@getCategory');
Route::post('add-category', 'CategoryController@addCategory');
Route::put('edit-category', 'CategoryController@editCategory');
Route::delete('delete-category', 'CategoryController@deleteCategory');

//SubCategories
Route::get('list-subcategories', 'SubCategoryController@listSubCategories');
Route::get('get-subcategory', 'SubCategoryController@getSubCategory');
Route::post('add-subcategory', 'SubCategoryController@addSubCategory');
Route::put('edit-subcategory', 'SubCategoryController@editSubCategory');
Route::delete('delete-subcategory', 'SubCategoryController@deleteSubCategory');