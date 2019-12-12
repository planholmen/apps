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

Route::middleware(['auth'])->group(function () {
    Route::get('/', function() {
        return view('home');
    })->name('home');

    Route::get('/auth/logout', 'LoginController@logout');
});
