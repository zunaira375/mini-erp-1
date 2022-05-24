<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CompanyController;

use App\Http\Controllers\FrontController;

use App\Http\Controllers\GroupController;

use App\Http\Controllers\SubGroupController;

use App\Http\Controllers\BrandController;

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
    return view('welcome');
});



Route::resource('companies', CompanyController::class);

Route::resource('groups', GroupController::class);

use App\Http\Controllers\ProductController;

Route::resource('subgroups', SubGroupController::class);


Route::resource('brands', BrandController::class);

Route::get('home', [FrontController::class, 'home'])->name('home');
Route::get('about-us', [FrontController::class, 'aboutUs'])->name('about.us');
