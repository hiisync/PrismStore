<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Payments\PaymentController;
use App\Http\Controllers\Payments\PayPalController;
use App\Http\Controllers\ProductController;
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

Route::resource('/', ProductController::class, [
    'only' => ['index'],
    'names' => [
        'index' => 'home',
    ],
]);

Route::get('lang/{locale}', [App\Http\Controllers\LangController::class, 'index'])->name('lang');
Route::get('/files/{path}', function ($path) {
    return response()->file(storage_path('app/public/'.$path));
})->where('path', '.*')->name('storage');
Route::get('p/{page}', [PageController::class, 'show']);
Route::resource('orders', OrderController::class)->only(['index', 'store']);
Route::middleware(['auth', 'web'])->name('payments.')->prefix('payments')->group(function () {
    Route::get('/', [PaymentController::class, 'index'])->name('index');
    Route::get('success', [PaymentController::class, 'success'])->name('success');
    Route::get('fail', [PaymentController::class, 'fail'])->name('fail');
    Route::get('paypal', [PayPalController::class, 'index'])->name('paypal');
    Route::post('paypal/pay', [PayPalController::class, 'pay'])->name('paypal.payment');
    Route::get('paypal/success', [PayPalController::class, 'success'])->name('paypal.success');
    Route::get('paypal/error', [PayPalController::class, 'error'])->name('paypal.error');
});
