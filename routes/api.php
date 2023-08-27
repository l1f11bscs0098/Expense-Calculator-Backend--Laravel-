<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ExpenseController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Password;
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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('register', [AuthController::class,'register']);
    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('profile', [AuthController::class,'profile']);

    Route::post('forgot-password', [AuthController::class,'validatePasswordRequest']);

});

Route::group([

    'middleware' => 'jwt.auth',
    'prefix' => 'expense'

], function ($router) {

    Route::post('list', [ExpenseController::class,'index']);
    Route::post('store', [ExpenseController::class,'store']);
    Route::post('delete', [ExpenseController::class,'destroy']);
    Route::post('update', [ExpenseController::class,'update']);
    Route::post('generate-pdf', [ExpenseController::class,'getPDF']);

});

