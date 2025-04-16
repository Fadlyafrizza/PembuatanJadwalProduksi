<?php

use App\Http\Controllers\JadwalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MesinController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth', ])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/user', [DashboardController::class, 'user'])->name('dashboard.user');
    Route::get('/dashboard/mesin', [DashboardController::class, 'mesin'])->name('dashboard.mesin');
    Route::get('/dashboard/produk', [DashboardController::class, 'produk'])->name('dashboard.produk');
    Route::get('/dashboard/bahan', [DashboardController::class, 'bahanBaku'])->name('dashboard.bahan');
    Route::get('/dashboard/order', [DashboardController::class, 'order'])->name('dashboard.order');
    Route::get('/dashboard/produksi', [DashboardController::class, 'produksi'])->middleware('checkComplete')->name('dashboard.produksi');

    Route::middleware('role:admin')->group(function () {
        Route::post('/create-user', [AuthController::class, 'store'])->name('create.user');
        Route::delete('/user/{id}', [AuthController::class, 'destroy'])->name('user.destroy');
        Route::put('/user/{id}', [AuthController::class, 'update'])->name('user.update');

        Route::post('/create-produk', [ProdukController::class, 'store'])->name('create.produk');
        Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

        Route::post('/create-bahan', [BahanBakuController::class, 'store'])->name('create.bahan');
        Route::put('/bahan/{id}', [BahanBakuController::class, 'update'])->name('bahan.update');
        Route::delete('/bahan/{id}', [BahanBakuController::class, 'destroy'])->name('bahan.destroy');

        Route::post('/create-order', [OrderController::class, 'store'])->name('create.order');
        Route::put('/order/{id}', [OrderController::class, 'update'])->name('order.update');
        Route::delete('/order/{id}', [OrderController::class, 'destroy'])->name('order.destroy');
    });

    Route::post('/create-mesin', [MesinController::class, 'store'])->name('create.mesin');
    Route::put('/mesin/{id}', [MesinController::class, 'update'])->name('mesin.update');
    Route::delete('/mesin/{id}', [MesinController::class, 'destroy'])->name('mesin.destroy');

    Route::put('/jadwalkan/{id}', [JadwalController::class, 'jadwalkan'])->middleware('role:produksi')->name('jadwal.update');
});
