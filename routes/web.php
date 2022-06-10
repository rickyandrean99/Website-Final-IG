<?php

use Illuminate\Support\Facades\Route;
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

Route::middleware(['auth'])->group(function() {
    Route::get('/', 'ToPostController@dashboard')->name('peserta');
    Route::get('/test', 'UpgradePostController@dashboard')->name('panitia');
    Route::post('/buy-ingredient', 'IngredientController@buyIngredient')->name('buy-ingredient');
    
    // sementara halaman panitianya di arahkan ke controller UpgradePostController
    // nanti halaman panitia punya dashboardnya masing" sesuai role
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
