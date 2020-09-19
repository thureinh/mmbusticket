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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test', function () {
	return view('test.gallery');
});
Route::get('dashboard', function() {
	return view('backend.dashboard');
})->name('dashboard');

Route::resources([
	'locations' => 'LocationController',
	'companies' => 'CompanyController',
	'buses' => 'BusController',
]);