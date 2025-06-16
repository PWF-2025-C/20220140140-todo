<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TodoController;
use App\Http\Controllers\CategoryController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/todos/search', [TodoController::class, 'search']);
    Route::apiResource('/todos', TodoController::class);

    Route::get('/my-categories', [CategoryController::class, 'myCategories']);


Route::middleware('auth:api')->get('/my-categories', [CategoryController::class, 'myCategories']);

});
