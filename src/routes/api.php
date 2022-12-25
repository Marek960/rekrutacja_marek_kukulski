<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;

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

Route::post('/auth/register', [AuthController::class, 'createUser'])->name('api.register');
Route::post('/auth/login', [AuthController::class, 'loginUser'])->name('api.login');
Route::get('products', [ProductController::class, 'index'])->name('api.products.index');
Route::get('products/{id}', [ProductController::class, 'show'])->name('api.products.show');
Route::post('products', [ProductController::class, 'store'])->name('api.products.create')->middleware('auth:sanctum');
Route::put('products/{id}', [ProductController::class, 'update'])->name('api.products.update')->middleware('auth:sanctum');
Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('api.products.delete')->middleware('auth:sanctum');