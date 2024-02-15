<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['prefix' => 'auth', 'namespace' => 'Api'], function () {
    Route::get('test',function (){
       return 'ciao';
    });
    Route::post('register', [AuthController::class, 'register']);

    /* ------------------------ For Personal Access Token ----------------------- */
    Route::post('login', 'AuthController@login');
    /* -------------------------------------------------------------------------- */

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@getUser');
    });

    /* ------------------------ For Password Grant Token ------------------------ */
    Route::post('login_grant', [AuthController::class, 'loginGrant']);
    Route::post('refresh',[AuthController::class, 'refreshToken']);
    /* -------------------------------------------------------------------------- */

    /* -------------------------------- Fallback -------------------------------- */
    Route::any('{segment}', function () {
        return response()->json([
            'error' => 'Invalid url.'
        ]);
    })->where('segment', '.*');
});

Route::get('unauthorized', function () {
    return response()->json([
        'error' => 'Unauthorized.'
    ], 401);
})->name('unauthorized');

