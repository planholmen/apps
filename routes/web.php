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

use App\CustomOption;

Route::get('/', 'HomeController@index')->name('home');

Route::get('/login', function() {
   return redirect(CustomOption::get('WP_SSO_AUTH_URL') . CustomOption::get('WP_SSO_PUB_KEY') . "&redirect_uri=" . CustomOption::get('WP_SSO_RET_URL'));
})->name('login');

Route::get('/auth/login', 'LoginController@login');

Route::middleware(['auth'])->group(function () {
    Route::get('/auth/logout', 'LoginController@logout')->name('logout');

    Route::get('/expense/create', 'ExpenseController@create');
    Route::post('/expense/store', 'ExpenseController@store');

    Route::get('/drive', 'DriveController@index');
    Route::get('/drive/create', 'DriveController@create');
    Route::get('/drive/transfer', 'DriveController@transfer');
    Route::post('/drive/store', 'DriveController@store');

    Route::get('/user/me', 'UserController@settings');
    Route::post('/user/me/update', 'UserController@update');
});

Route::middleware(['auth', 'can:accessApprovals'])->group(function () {
    Route::get('/expenses', 'ExpenseController@index');
    Route::get('/expense/approve/{id?}', 'ExpenseController@approve');
    Route::get('/expense/{id}/accept/{next?}', 'ExpenseController@accept');
    Route::get('/expense/{id}/decline/{next?}', 'ExpenseController@decline');
});

Route::middleware(['auth', 'can:accessAdmin'])->group(function () {
    Route::get('/expense/transfer', 'ExpenseController@transfer');

    Route::get('/driveapi/auth', 'GoogleController@update');
    Route::post('/driveapi/auth/code', 'GoogleController@saveAuthCode');

    Route::prefix('settings')->group(function () {
        Route::get('', 'HomeController@settings');

        Route::get('options', 'CustomOptionController@index');
        Route::get('options/create', 'CustomOptionController@create');
        Route::post('options/store', 'CustomOptionController@store');
    });


    Route::get('/queue', 'JobsController@index');
    Route::get('/queue/size', function () {
        dd(\Illuminate\Support\Facades\Queue::size());
    });
});
