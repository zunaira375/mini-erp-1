<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\SubGroupController;
use App\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::resource('companies', CompanyController::class)->middleware('CustomAuth');
Route::resource('groups', GroupController::class)->middleware('CustomAuth');
Route::resource('subgroups', SubGroupController::class)->middleware('CustomAuth');
Route::resource('brands', BrandController::class)->middleware('CustomAuth');

// Route::get('/home', [FrontController::class, 'home'])->name('home');
// Route::get('/about-us', [FrontController::class, 'aboutUs'])->name('about.us');

Route::get('/home', [FrontController::class, 'home'])->middleware('CustomAuth')->name('home');
Route::get('/about-us', [FrontController::class, 'aboutUs'])->middleware('CustomAuth')->name('about.us');
