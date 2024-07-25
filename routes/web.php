<?php

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


Auth::routes();
Route::get('/u/{referral_code}', function ($referral_code) {
    $user = \App\Models\AffiliateUser
        ::where('referral_code', $referral_code)
        ->firstOrFail();

        return view('linktree')->with(compact('user')); 
});
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/pendaftar', [App\Http\Controllers\HomeController::class, 'pendaftar'])->name('pendaftar');
    Route::get('/transaksi', [App\Http\Controllers\HomeController::class, 'transaksi'])->name('transaksi');
    Route::get('/saldo', [App\Http\Controllers\HomeController::class, 'saldo'])->name('saldo');
    Route::get('/account-setting', [App\Http\Controllers\HomeController::class, 'accountSetting'])->name('account-setting');
    
    Route::post('/email-verification', [App\Http\Controllers\UserController::class, 'emailVerification'])->name('email-verification');
    Route::post('/add-bank-account', [App\Http\Controllers\UserController::class, 'AddBankAccount'])->name('add-bank-account');
    Route::get('/get-bank-account', [App\Http\Controllers\UserController::class, 'GetBankAccount'])->name('get-bank-account');
    Route::post('/withdrawal', [App\Http\Controllers\UserController::class, 'withdrawal'])->name('withdrawal');
    
});

Route::get('/account-verification', [App\Http\Controllers\UserController::class, 'verifyEmail']);