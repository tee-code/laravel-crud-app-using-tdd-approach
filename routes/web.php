<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

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

Route::get("/categories", [CategoryController::class, 'index']);

Route::get("/categories/create", [CategoryController::class, 'create']);

Route::get("/categories/{category}", [CategoryController::class, 'show']);

Route::get("/categories/{category}/edit", [CategoryController::class, 'edit'])->name("categories.edit");

Route::post("/categories", [CategoryController::class, 'store'])->name("categories.store");

Route::put("/categories/{category}", [CategoryController::class, 'update'])->name("categories.update");

Route::delete("/categories/{category}", [CategoryController::class, "destroy"])->name("categories.delete");

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
