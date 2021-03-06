<?php
use TCG\Voyager\Facades\Voyager;
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

// Route::get('/', function () {
//     return view('pages.app');
// });

// Route::get('/index', function () {
//     return view('pages.index');
// });

// Route::get('/hello', 'HelloController@hello');
// Route::get('/login','PagesController@loginPage');
// Route::get('/register', 'PagesController@signupPage');




Route::view('/{path?}', 'pages.main');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
