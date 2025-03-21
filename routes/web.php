<?php

use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Artisan;
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
Route::get('/fetch/{count?}', function($count = null){
    Artisan::call('gsheet:fetch', ['count' => $count]);
    dd(Artisan::output());
});
Route::controller(ProductsController::class)->prefix('products')->group(function (){
    Route::get('index', 'index');
    Route::get('update', 'edit');
    Route::post('update', 'update');
    Route::get('create', 'create');
    Route::post('create', 'store');
    Route::get('destroy', 'delete');
    Route::post('destroy', 'destroy');
    Route::post('generate', 'generate');
    Route::post('clear', 'clear');
});