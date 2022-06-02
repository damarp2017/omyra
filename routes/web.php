<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StockInnerController;
use App\Http\Controllers\Admin\StockMasterController;
use App\Http\Controllers\Admin\StockPlasticController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => ['auth', 'role:admin'], 'prefix' => 'admin'], function () {
    Route::get('', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::prefix('user')->group(function () {
        Route::get('index', [UserController::class, 'index'])->name('admin.user.index');
        Route::get('create', [UserController::class, 'create'])->name('admin.user.create');
        Route::post('store', [UserController::class, 'store'])->name('admin.user.store');
    });
    Route::prefix('brand')->group(function () {
        Route::get('index', [BrandController::class, 'index'])->name('admin.brand.index');
        Route::get('create', [BrandController::class, 'create'])->name('admin.brand.create');
        Route::post('store', [BrandController::class, 'store'])->name('admin.brand.store');
    });
    Route::prefix('product')->group(function () {
        Route::get('index', [ProductController::class, 'index'])->name('admin.product.index');
        Route::get('create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('store', [ProductController::class, 'store'])->name('admin.product.store');
    });
    Route::prefix('material')->group(function () {
        Route::get('index', [MaterialController::class, 'index'])->name('admin.material.index');
        Route::get('create', [MaterialController::class, 'create'])->name('admin.material.create');
        Route::post('store', [MaterialController::class, 'store'])->name('admin.material.store');
    });
    Route::prefix('stock')->group(function () {
        Route::prefix('plastic')->group(function () {
            Route::get('index', [StockPlasticController::class, 'index'])->name('admin.stock.plastic.index');
            Route::get('create', [StockPlasticController::class, 'create'])->name('admin.stock.plastic.create');
            Route::post('store', [StockPlasticController::class, 'store'])->name('admin.stock.plastic.store');
        });
        Route::prefix('inner')->group(function () {
            Route::get('index', [StockInnerController::class, 'index'])->name('admin.stock.inner.index');
            Route::get('create', [StockInnerController::class, 'create'])->name('admin.stock.inner.create');
            Route::post('store', [StockInnerController::class, 'store'])->name('admin.stock.inner.store');
        });
        Route::prefix('master')->group(function () {
            Route::get('index', [StockMasterController::class, 'index'])->name('admin.stock.master.index');
            Route::get('create', [StockMasterController::class, 'create'])->name('admin.stock.master.create');
            Route::post('store', [StockMasterController::class, 'store'])->name('admin.stock.master.store');
        });
    });
});

require __DIR__ . '/auth.php';
