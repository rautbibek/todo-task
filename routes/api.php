<?php

use App\Http\Controllers\api\CardController;
use App\Http\Controllers\api\ProjectController;
use App\Http\Controllers\api\TaskController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login',[AuthController::class,'login']);
Route::middleware('auth:sanctum')->group(function(){
    Route::post('logout',[AuthController::class,'logout']);
    Route::get('/auth/user',[UserController::class,'authUser']);

    Route::group(['prefix'=>'project'], function(){
        Route::get('/',[ProjectController::class,'myProjects']);
        Route::post('/store',[ProjectController::class,'store']);
    });

    Route::group(['prefix'=>'card'], function(){
        Route::get('/{project_id}',[CardController::class,'getCard']);
        Route::post('/store',[CardController::class,'store']);
    });

    Route::group(['prefix'=>'task'], function(){
        //Route::get('/{project_id}',[CardController::class,'getCard']);
        Route::post('/store',[TaskController::class,'store']);
    });
});
