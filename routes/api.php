<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

if(!function_exists('j')){
    function j($data)
    {
        return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }
}

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('appusers/login','api\AppUserController@login');
Route::post('appusers/register','api\AppUserController@register');
Route::post('appusers/get_profile','api\AppUserController@get_profile');
Route::post('appusers/profile_update','api\AppUserController@profile_update');
Route::post('appusers/forgot_password','api\AppUserController@forgot_password');

/**
 * API Route
 */
Route::group(['prefix' => 'v1'], function(){
    
    Route::get('/', 'ApiController@index');

    /**
     * API login user
     */
    Route::post('/login', 'ApiController@login');

    Route::post('/forgot-password', 'ApiController@forgotPassword');

    /**
     * API Register new user from app
     */
    Route::post('/register', 'ApiController@register');

    /**
     * SOCIAL LOGIN
     */
    Route::post('/social-login', 'ApiController@socialLogin');

    /**
     * API REQUIRED AUTHENTICATION
     */
    Route::group(['middleware' => 'auth.api'], function () {
        // get current user profile
        Route::get('/profile', 'ApiController@profile');

        // logout user
        Route::get('/logout', 'ApiController@logout');

        // change password user
        Route::post('/change-password', 'ApiController@changePassword');

        // Update device token
        Route::post('/update-device-token', 'ApiController@updateDeviceToken');

        Route::post('/profile', 'ApiController@updateProfile');

        // Declare Users API
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', 'ApiController@users');
            Route::get('/{id}', 'ApiController@getUserDetail');
        });

        Route::post('/apps/{id}/comments', 'ApiController@postComment');      
        
        Route::get('/apps/v/my', 'ApiController@myApps');
        Route::get('/apps/v/recent', 'ApiController@getRecentApps');

        // declare payment API
        Route::get('/client-token', 'PaymentController@generateClientToken');
        Route::get('/get-card', 'PaymentController@getCard');
        Route::post('/save-card', 'PaymentController@saveCard');
        Route::get('/apps/{id}/download', 'PaymentController@downloadApp');
    });

    // categories API
    Route::get('/categories', 'ApiController@categories');
    Route::get('/categories/{id}/apps', 'ApiController@getCategoryApps');

    // home API
    Route::get('/home', 'ApiController@home');

    // App API
    Route::get('/apps/{id}', 'ApiController@appDetail');
    Route::get('/apps/{id}/related', 'ApiController@relatedApps');
    Route::get('/apps/v/top-rated', 'ApiController@topRatedApps');
    Route::get('/apps/v/newest', 'ApiController@newestApps');
    Route::get('/apps/{id}/comments', 'ApiController@getAppComments');
    
    // developer API
    Route::get('/developers/{id}', 'ApiController@developerDetail');
    Route::get('/developers/{id}/apps', 'ApiController@appFromDeveloper');

    // search API
    Route::post('/search', 'ApiController@search');
});


Route::get('/apps1', 'PaymentController@downloadApp');
