<?php

use Illuminate\Http\Request;
use App\Http\Actions\AddPointAction;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ping', function() {
    return response()->json(['message' => 'pong']);
});

Route::put('/customers/add_point', AddPointAction::class);