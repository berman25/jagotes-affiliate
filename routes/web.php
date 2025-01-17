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
    Route::get('/affiliator-performance', [App\Http\Controllers\HomeController::class, 'affiliatePerformance'])->name('affiliator-performance');
    Route::get('/pendaftar', [App\Http\Controllers\HomeController::class, 'pendaftar'])->name('pendaftar');
    Route::get('/transaksi', [App\Http\Controllers\HomeController::class, 'transaksi'])->name('transaksi');
    Route::get('/saldo', [App\Http\Controllers\HomeController::class, 'saldo'])->name('saldo');
    Route::get('/account-setting', [App\Http\Controllers\HomeController::class, 'accountSetting'])->name('account-setting');
    
    Route::post('/email-verification', [App\Http\Controllers\UserController::class, 'emailVerification'])->name('email-verification');
    Route::post('/add-bank-account', [App\Http\Controllers\UserController::class, 'AddBankAccount'])->name('add-bank-account');
    Route::get('/get-bank-account', [App\Http\Controllers\UserController::class, 'GetBankAccount'])->name('get-bank-account');
    Route::post('/withdrawal', [App\Http\Controllers\UserController::class, 'withdrawal'])->name('withdrawal');
    

    //site setting
    Route::get('/site-setting/index', [App\Http\Controllers\SiteSettingController::class, 'index'])->name('site-setting');
    Route::get('/site-setting/appearance/{site_id}', [App\Http\Controllers\SiteSettingController::class, 'appearance'])->name('site-appearance');
    Route::put('/site/update/1/{site_id}', [App\Http\Controllers\SiteSettingController::class, 'update1'])->name('site.update1');
    Route::put('/site/update/menu/{site_id}', [App\Http\Controllers\SiteSettingController::class, 'updateMenu'])->name('site.update-menu');
    Route::put('/site/update/color/{site_id}', [App\Http\Controllers\SiteSettingController::class, 'updateColor'])->name('site.update-color');


    //course
    Route::get('/course/index', [App\Http\Controllers\CourseController::class, 'index'])->name('course-index');    
    Route::get('/course/view/{site_id}', [App\Http\Controllers\CourseController::class, 'view'])->name('course-view');
    Route::put('/course/update/{course_id}', [App\Http\Controllers\CourseController::class, 'update'])->name('course.update');
    
    Route::get('/course/detail/{course_id}', [App\Http\Controllers\CourseController::class, 'detail'])->name('course-detail');
    
    Route::get('/product', [App\Http\Controllers\ProductController::class, 'index'])->name('product');
    Route::put('/product/update/{product_id}', [App\Http\Controllers\ProductController::class, 'update'])->name('product.update');
    
    
});

Route::get('/account-verification', [App\Http\Controllers\UserController::class, 'verifyEmail']);