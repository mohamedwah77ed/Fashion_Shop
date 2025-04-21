<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\CartController;


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

Route::get('/', function () { //test route
    return 3;
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Home route for guests
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/home/product', [HomeController::class, 'show'])->name('home.products.show');
Route::get('/home/categories', [CategoriesController::class, 'index'])->name('categories');
Route::post('/categories/show', [CategoriesController::class, 'show'])->name('categories.show');
Route::post('/categories/subcategory-products', [CategoriesController::class, 'showSubcategoryProducts'])->name('categories.subcategory-products');
Route::post('/search', [SearchController::class, 'search']);
Route::post('/filter', [FilterController::class, 'filter']);

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'getCart']);
    Route::post('/add', [CartController::class, 'add']);
    Route::put('/update', [CartController::class, 'update']);
    Route::delete('/remove', [CartController::class, 'remove']);
    Route::get('/total', [CartController::class, 'total']);
});

require __DIR__ . '/auth.php';
