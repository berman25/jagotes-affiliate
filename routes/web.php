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
Route::get('/u/{referral_code}', [App\Http\Controllers\LinkTreeController::class, 'showPublicBiolink']);
    
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/affiliator-performance', [App\Http\Controllers\HomeController::class, 'affiliatePerformance'])->name('affiliator-performance');
    Route::get('/pendaftar', [App\Http\Controllers\HomeController::class, 'pendaftar'])->name('pendaftar');
    Route::get('/transaksi', [App\Http\Controllers\HomeController::class, 'transaksi'])->name('transaksi');
    Route::get('/saldo', [App\Http\Controllers\HomeController::class, 'saldo'])->name('saldo');
    Route::get('/organization-perfomance', [App\Http\Controllers\HomeController::class, 'organizationPerformance'])->name('organization-perfomance');
    Route::get('/free-to-perfomance', [App\Http\Controllers\HomeController::class, 'freeTryoutPerformance'])->name('free-to-perfomance');
    
    Route::get('/affiliator-performance/overview', [App\Http\Controllers\DataController::class, 'affiliatorPerformanceOverview'])->name('affiliator-performance-overview');
    



    Route::get('/affiliator-profile/{referral_code}', [App\Http\Controllers\AffiliatorController::class, 'showUser']);
    Route::get('/affiliator-profile', [App\Http\Controllers\AffiliatorController::class, 'showUser']);
    
    
    
    Route::get('/account-setting', [App\Http\Controllers\HomeController::class, 'accountSetting'])->name('account-setting');
    
    Route::get('/biolink/settings', [App\Http\Controllers\LinkTreeController::class, 'settings']);
    Route::put('/biolink/save-settings', [App\Http\Controllers\LinkTreeController::class, 'saveSettings'])->name('affiliate.biolink.save');
    
    Route::post('/email-verification', [App\Http\Controllers\UserController::class, 'emailVerification'])->name('email-verification');
    Route::post('/add-bank-account', [App\Http\Controllers\UserController::class, 'AddBankAccount'])->name('add-bank-account');
    Route::get('/get-bank-account', [App\Http\Controllers\UserController::class, 'GetBankAccount'])->name('get-bank-account');
    Route::post('/withdrawal', [App\Http\Controllers\UserController::class, 'withdrawal'])->name('withdrawal');
    
    Route::get('/get-user', [App\Http\Controllers\StudentController::class, 'getUser'])->name('get.user');
    
    
    //site setting
    Route::get('/site-setting/index', [App\Http\Controllers\SiteSettingController::class, 'index'])->name('site-setting');
    Route::get('/site-setting/appearance/{site_id}', [App\Http\Controllers\SiteSettingController::class, 'appearance'])->name('site-appearance');
    Route::put('/site/update/1/{site_id}', [App\Http\Controllers\SiteSettingController::class, 'update1'])->name('site.update1');
    Route::put('/site/update/menu/{site_id}', [App\Http\Controllers\SiteSettingController::class, 'updateMenu'])->name('site.update-menu');
    Route::put('/site/update/color/{site_id}', [App\Http\Controllers\SiteSettingController::class, 'updateColor'])->name('site.update-color');
    Route::put('/site/update/dashboard-banner/{site_id}', [App\Http\Controllers\SiteSettingController::class, 'updateDashboardBanner'])->name('site.update-dashboard-banner');
    Route::put('/site/update/login-banner/{site_id}', [App\Http\Controllers\SiteSettingController::class, 'updateLoginBanner'])->name('site.update-login-banner');


    //course
    Route::get('/course/index', [App\Http\Controllers\CourseController::class, 'index'])->name('course-index');    
    Route::get('/course/view/{site_id}', [App\Http\Controllers\CourseController::class, 'view'])->name('course-view');
    Route::put('/course/update/{course_id}', [App\Http\Controllers\CourseController::class, 'update'])->name('course.update');
    
    Route::get('/course/detail/{course_id}', [App\Http\Controllers\CourseController::class, 'detail'])->name('course-detail');
    
    Route::post('/course/module/create', [App\Http\Controllers\CourseController::class, 'moduleCreate'])->name('course-module.create');
    
    Route::put('/course/module/update/{module_id}', [App\Http\Controllers\CourseController::class, 'moduleUpdate'])->name('course-module.update');
    Route::get('/course/quiz/view/{module_id}', [App\Http\Controllers\CourseQuizController::class, 'viewQuiz'])->name('course-quiz.view');
    
    Route::get('/course/module-detail/view/{module_id}', [App\Http\Controllers\CourseModuleDetailController::class, 'view'])->name('course-module-detail.view');
    Route::post('/course/module-detail/add', [App\Http\Controllers\CourseModuleDetailController::class, 'add'])->name('course-module-detail.add');
    

    Route::post('/course/quiz/create/{module_id}', [App\Http\Controllers\CourseQuizController::class, 'createQuiz'])->name('course-quiz.create');
	Route::get('/course/quiz/show-question', [App\Http\Controllers\CourseQuizController::class, 'showQuestion'])->name('question.show');
    Route::put('/course/quiz/update-question', [App\Http\Controllers\CourseQuizController::class, 'updateQuestion'])->name('question.update');

    Route::get('/product', [App\Http\Controllers\ProductController::class, 'index'])->name('product');
    Route::put('/product/update/{product_id}', [App\Http\Controllers\ProductController::class, 'update'])->name('product.update');
    
    Route::get('/tryout/view', [App\Http\Controllers\TryoutController::class, 'view'])->name('tryout-view');
    Route::put('/tryout/update/{package_id}', [App\Http\Controllers\TryoutController::class, 'update'])->name('tryout.update');
    Route::get('/tryout/participant/{package_id}', [App\Http\Controllers\TryoutController::class, 'participants'])->name('tryout-participant');
    Route::get('/tryout/package/{package_id}', [App\Http\Controllers\TryoutController::class, 'package'])->name('tryout-package');
    Route::get('/tryout/question-management/{utbk_id}', [App\Http\Controllers\TryoutController::class, 'questionsManagement'])->name('tryout.question-management');
    Route::get('/tryout/question-view/{assessment_id}', [App\Http\Controllers\TryoutController::class, 'questionsView'])->name('tryout.question-view');
    
    
    Route::post('/assign-user', [App\Http\Controllers\TryoutController::class, 'assignUser'])->name('assign-user');
    
});

Route::get('/account-verification', [App\Http\Controllers\UserController::class, 'verifyEmail']);