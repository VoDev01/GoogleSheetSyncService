<?php

use App\Http\Controllers\API\V1\APIProductController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(APIProductController::class)->prefix('products')->group(function (){
    Route::get('index', 'index');
    Route::get('show', 'show');
    Route::patch('update/{id}', 'update');
    Route::post('create', 'store');
    Route::delete('destroy/{id}', 'destroy');
});