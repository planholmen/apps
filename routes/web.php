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

Route::get('/login', function() {
   return redirect(env('WP_SSO_AUTH_URL') . env('WP_SSO_PUB_KEY') . "&redirect_uri=" . env('WP_SSO_RET_URL'));
})->name('login');

Route::get('/auth/login', 'LoginController@login');
Route::get('/driveapi/auth/code', 'GoogleController@saveAuthCode');

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
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
    Route::get('/queue/size', function () {
        dd(\Illuminate\Support\Facades\Queue::size());
    });
});
