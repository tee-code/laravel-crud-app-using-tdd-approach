<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;

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

Route::get("/categories", [CategoryController::class, 'index'])->name("categories.index");

Route::get("/categories/create", [CategoryController::class, 'create'])->name("categories.create");

Route::get("/categories/{category}", [CategoryController::class, 'show'])->name("categories.show");

Route::get("/categories/{category}/edit", [CategoryController::class, 'edit'])->name("categories.edit");

Route::post("/categories", [CategoryController::class, 'store'])->name("categories.store");

Route::put("/categories/{category}", [CategoryController::class, 'update'])->name("categories.update");

Route::delete("/categories/{category}", [CategoryController::class, "destroy"])->name("categories.delete");

Route::get("/posts/{slug}", [PostController::class, "findBySlug"])->name("posts.slug");

Route::resource("posts", PostController::class);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
