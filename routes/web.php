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

Auth::routes();

Route::get('/', 'UserController@home')->name('home');

// User Profile
Route::get('profile', 'UserController@profile')->name('profile');
Route::patch('profile/{user}', 'UserController@update')->name('profile.update');
Route::get('preferences/{setting?}', 'UserController@preferences')->name('preferences');
Route::patch('preferences/{setting}', 'UserController@updatePreferences');

// Equipment/machines
Route::get('machines/stats', 'MachinesController@statistics')->name('machines.statistics');
Route::resource('machines', 'MachinesController');

// Filament Spools
Route::get('spools/{spool}/duplicate', 'FilamentSpoolsController@duplicate')->name('spools.duplicate');
Route::get('spools/{spool}/empty', 'FilamentSpoolsController@empty')->name('spools.empty');
Route::get('spools/stats', 'FilamentSpoolsController@statistics')->name('spools.statistics');
Route::get(
    'spools/{spool}/export',
    'FilamentSpoolsController@export'
)->name('spools.export')->middleware('can:export,spool');
Route::resource('spools', 'FilamentSpoolsController');

// 3D Printer Jobs
Route::resource('threedprinterjobs', 'ThreeDPrinterJobsController');

// Dashboard
Route::get('dashboard', 'DashboardController@index')->name('dashboard');

// Documentation
Route::get('docs/wishlist', 'DocsController@wishlist')->name('wishlist');
Route::get('docs/{page?}', 'DocsController@show')->name('docs');
