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
    // TO atau peserta
    Route::get('/', 'ToPostController@dashboard')->name('peserta');
    Route::post('/add-coin', 'ToPostController@addCoin')->name('add-coin');
    Route::post('/info-hutang', 'ToPostController@infoHutang')->name('info-hutang');
    Route::post('/bayar-hutang', 'ToPostController@bayarHutang')->name('bayar-hutang');
    Route::post('/upgrade-inventory', 'InventoryController@upgradeInventory')->name('upgrade-inventory');
    Route::post('/buy-ingredient', 'IngredientController@buyIngredient')->name('buy-ingredient');
    Route::post('/machine', 'MachineController@getMachineById')->name('machine.getbyid');
    Route::post('/buy-machine', 'MachineController@buyMachine')->name('buy-machine');
    Route::post('/sell-machine', 'MachineController@sellMachine')->name('machine.sell');
    Route::post('/transportation', 'TransportationController@getTransportById')->name('transportation.getbyid');
    Route::post('/buy-transportation', 'TransportationController@buyTransportation')->name('buy-transportation');
    Route::post('/sell-transportation', 'TransportationController@sellTransport')->name('transportation.sell');
    Route::post('/add-production', 'ProductionController@addProduction')->name('add-production');
    Route::post('/change-production', 'ProductionController@changeProduction')->name('change-production');
    Route::post('/start-production', 'ProductionController@startProduction')->name('start-production');
    
    // Pos upgrade
    Route::get('/upgrade', 'UpgradePostController@dashboard')->name('upgrade');
    Route::post('/buy-fridge', 'UpgradePostController@buyFridge')->name('buy-fridge');
    Route::post('/update-level', 'UpgradePostController@updateLevel')->name('update-level');
    Route::post('/get-machine', 'UpgradePostController@getMachineById')->name('machine.getbyid2');
    Route::post('/upgrade-machine', 'UpgradePostController@upgradeMachine')->name('upgrade-machine');

    // Pos pasar
    Route::get('/market', 'MarketPostController@dashboard')->name('market');
    Route::post('/sell-produk', 'MarketPostController@sellProduct')->name('product.sell');
    Route::post('/update-market', 'MarketPostController@updateMarket')->name('update-market');

    // Superadmin
    Route::get('/batch', "BatchController@index")->name('batch');
    Route::post('/update-batch', "BatchController@updateBatch")->name('update-batch');
    Route::post('/update-preparation', "BatchController@updatePreparation")->name('update-preparation');

    // Rekap Skor
    Route::get('/score-recap', "AcaraController@index")->name('score-recap');
    Route::get('/demand', "AcaraController@demand")->name('demand');

    // Routing khusus penilaian [Kalian sesuaiin aja, testnya mau pakai method get atau post]
    Route::get('/calculate-profit', "BatchController@calculateProfit")->name('calculate-profit');
    Route::get('/calculate-pangsa', "BatchController@calculatePangsa")->name('calculate-pangsa');
    Route::post('/calculate-sigma', "BatchController@calculateSigma")->name('calculate-sigma');

    // Realtime Modal
    Route::post('/load-transportation', "ToPostController@loadTransportation")->name('load-transportation');
    Route::post('/load-inventory', "ToPostController@loadInventory")->name('load-inventory');
    Route::post('/load-history', "ToPostController@loadHistory")->name('load-history');
});

Auth::routes(['register' => false]);
Route::get('/home', 'HomeController@index')->name('home');

