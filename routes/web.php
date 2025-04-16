<?php

use App\Exports\SalesExport;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/loginAttempt', [AuthController::class, 'loginStore'])->name('loginStore')->middleware('guest');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function (){

    Route::get('/', [AuthController::class, 'index'])->name('dashboard');

    Route::middleware(['admin'])->group(function () {
        Route::resource('users', UserController::class);
    });

    Route::resources([
        'products' => ProductController::class,
        'sales' => SaleController::class,
    ]);

    Route::patch('/{id}/update-stock', [ProductController::class, 'updateStock'])->name('updateStock');

    Route::post('/sales/post', [SaleController::class, 'confirmTransaction'])->name('sales.transaction');
    Route::get('/sales/create/member/{id}', [SaleController::class, 'createMember'])->name('sales.createMember');
    Route::put('/sales/store-member/{id}', [SaleController::class, 'storeMember'])->name('sales.storeMember');
    Route::get('/sales/invoice/{sale}', [SaleController::class, 'invoice'])->name('sales.invoice');
    Route::get('/sales/invoice/pdf/{sale}', [SaleController::class, 'downloadInvoice'])->name('sales.invoice.pdf');
    Route::get('/sales/{sale}', [SaleController::class, 'show'])->where('sale', '[0-9]+')->name('sales.show');
    Route::get('/export-laporan-penjualan', [SaleController::class, 'exportExcel'])
    ->name('export.laporan.penjualan');
});
