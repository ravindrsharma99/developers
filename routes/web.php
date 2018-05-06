<?php

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


Route::group(['prefix' => 'admin'], function() {
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
	Route::get('resetpassword','\App\Http\Controllers\Auth\ForgotPasswordController@reset_password');
    Route::post('sendemail','\App\Http\Controllers\Auth\ForgotPasswordController@send_password');
    Route::auth();
    Route::get('/','admin\DashboardController@index');
    Route::get('dashboard','admin\DashboardController@index');
    Route::resource('users', 'admin\UserController');
    Route::resource('appusers', 'admin\AppUserController');
    Route::resource('webusers', 'admin\WebUserController');
    Route::get('webusers/{id}/{appid}/app', 'admin\WebUserController@app_show')->name('admin.apps.detail');
    Route::resource('category', 'admin\CategoryController');
	Route::get('approvedapp','admin\DashboardController@app_approved');
    Route::get('pendingapp','admin\DashboardController@app_pending');
	Route::get('rejectedapp','admin\DashboardController@app_rejected');
    Route::get('app/status/{id}/{vid}', 'admin\DashboardController@update_status');
    Route::get('statusremark/{id}', 'admin\DashboardController@remark_status');
	Route::get('statusremark_approved/{id}', 'admin\DashboardController@remark_status_approved');
    Route::get('statusremark_pending/{id}', 'admin\DashboardController@remark_status_pending');
    Route::resource('staticpage', 'admin\StaticpageController');
    
    // settings controller
    Route::resource('/settings', 'admin\SettingController');
    Route::post('/update-settings', 'admin\SettingController@updateSettings');

    Route::resource('payments', 'admin\PaymentController');
    Route::resource('reports', 'admin\ReportController');
    Route::resource('withdraw-requests', 'admin\WithdrawRequestController', ['as' => 'admin']);
    Route::resource('reviews', 'admin\ReviewController', ['as' => 'admin']);
    Route::get('update-statistic', 'admin\PaymentController@updateStatistic')->name('admin.update-statistic');

    // forum routes
    Route::resource('/forums', 'admin\Forum\DiscussionController', ['as' => 'admin']);
    Route::delete('/posts/{id}', 'admin\Forum\DiscussionController@deletePost')->name('admin.posts.destroy');

    Auth::routes();
});


Route::get('/', 'website\HomeController@index');
Route::get('/login', 'website\UserController@login_view')->name('webuser.login');
Route::get('/login/state/country/{id}', 'website\UserController@sub_category');
Route::get('/login/city/{state}/{country}', 'website\UserController@sub_sub_category');
Route::get('/forgetpassword', 'website\UserController@forget_password_view');
Route::post('reset_password','website\UserController@reset_password');
Route::post('loggedin','website\UserController@loggedin');
Route::post('registration','website\UserController@registration');
Route::get('account_active/{id}','website\UserController@account_active');
Route::get('logout','website\UserController@logout')->middleware('userlogin');
Route::get('account','website\UserController@account')->middleware('userlogin');
Route::post('update_account','website\UserController@update_account')->middleware('userlogin');
Route::get('dashboard','website\DashboardController@index')->middleware('userlogin');
Route::get('submitted_app','website\SubmittedAppController@index')->middleware('userlogin');
Route::get('submitted_app/{id}/destroy','website\SubmittedAppController@destroy')->middleware('userlogin');
Route::get('step1','website\NewAppController@step1_view')->middleware('userlogin');
Route::post('step1_create','website\NewAppController@step1_create')->middleware('userlogin');
Route::get('step2','website\NewAppController@step2_view')->middleware('userlogin');
Route::post('step2_update','website\NewAppController@step2_update')->middleware('userlogin');
Route::get('step3','website\NewAppController@step3_view')->middleware('userlogin');
Route::get('step3/{id}/destroy','website\NewAppController@step3_destroy_image')->middleware('userlogin');
Route::post('step3_update','website\NewAppController@step3_update')->middleware('userlogin');
Route::get('upload_ajax','website\NewAppController@upload_ajax')->middleware('userlogin');
Route::get('step4','website\NewAppController@step4_view')->middleware('userlogin');
Route::post('step4_update','website\NewAppController@step4_update')->middleware('userlogin');
Route::get('search','website\NewAppController@search')->middleware('userlogin');
Route::get('terms','website\NewAppController@terms');


Route::get('step1/{id}','website\AppUpdateController@step1_edit')->middleware('userlogin');
Route::Post('step1/{id}','website\AppUpdateController@step1_update')->middleware('userlogin');

Route::get('step2/{id}','website\AppUpdateController@step2_edit')->middleware('userlogin');
Route::Post('step2/{id}','website\AppUpdateController@step2_update')->middleware('userlogin');

Route::get('step3/{id}','website\AppUpdateController@step3_edit')->middleware('userlogin');
Route::post('screenshot','website\AppUpdateController@screenshotimage')->middleware('userlogin');
Route::Post('step3/{id}','website\AppUpdateController@step3_update')->middleware('userlogin');

Route::get('step4/{id}','website\AppUpdateController@step4_edit')->middleware('userlogin');
Route::Post('step4/{id}','website\AppUpdateController@step4_update')->middleware('userlogin');

Route::get('payment','website\PaymentController@index')->middleware('userlogin');
Route::post('payment_update','website\PaymentController@payment_update')->middleware('userlogin');


Route::get('app_detail/{id}','website\AppUpdateController@app_detail')->middleware('userlogin')->name('webusers.apps.detail');

Route::post('admin/api/cms/webusers/assign','admin\WebUserController@assign');
Route::post('admin/api/cms/webusers/unassign','admin\WebUserController@unassign');

Route::post('admin/api/cms/approvedapp/assign','admin\DashboardController@assign');
Route::post('admin/api/cms/approvedapp/unassign','admin\DashboardController@unassign');

Route::get('/financial-dash', 'website\FinancialController@index')->name('financial.index');
Route::resource('/withdraw-requests', 'website\FinancialController');

Route::get('/reports', 'website\FinancialController@reports')->name('users.reports');

// stripe payment request
Route::get('/stripe/setup', 'website\StripeController@stripeSetup')->name('stripe.setup');
Route::get('/stripe/authorize', 'website\StripeController@stripeAuthorize')->name('stripe.authorize');
Route::any('/connect', 'website\StripeController@connect')->name('stripe.connect');
Route::any('/stripe/sale', 'website\StripeController@sale')->name('stripe.sale');
Route::post('/stripe/charge', 'website\StripeController@charge')->name('stripe.charge');


Route::get('/apps/download', 'PaymentController@downloadApp');
Route::get('/testcard', 'test@testcard');
Route::get('/cardpayment', 'test@cardpayment');

