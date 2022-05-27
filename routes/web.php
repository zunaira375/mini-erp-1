<?php

use App\Http\Controllers\FrontController;
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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/cards', function () {
//     return view('layouts.cards');
// });
Route::get('/cards', [FrontController::class, 'cards']);
Route::get('/progress-steps', [FrontController::class, 'steps']);

// Route::get('/progress-steps', function () {
//     return view('layouts.progress-steps');
// });
Route::get('/search-wizard', [FrontController::class, 'search']);

// Route::get('/search-wizard', function () {
//     return view('layouts.search-wizard');
// });
Route::get('/blurryloading', [FrontController::class, 'blurry']);
// Route::get('/blurryloading', function () {
//     return view('layouts.blurryloading');
// });
Route::get('/scrollanimation', [FrontController::class, 'scroll']);
// Route::get('/scrollanimation', function () {
//     return view('layouts.scrollanimation');
// });
Route::get('/splitpage',[FrontController::class,'split']);
