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
    Route::post('/buy-machine', 'MachineController@buyMachine')->name('buy-machine');
    Route::post('/buy-transportation', 'TransportationController@buyTransportation')->name('buy-transportation');
    Route::post('/transportation', 'TransportationController@getTransportById')->name('transportation.getbyid');
    Route::post('/sell-transportation', 'TransportationController@sellTransport')->name('transportation.sell');
    Route::post('/machine', 'MachineController@getMachineById')->name('machine.getbyid');
    Route::post('/sell-machine', 'MachineController@sellMachine')->name('machine.sell');
    Route::post('/add-production', 'ProductionController@addProduction')->name('add-production');
    Route::post('/change-production', 'ProductionController@changeProduction')->name('change-production');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/market', function() { return view('market'); })->name('market');
