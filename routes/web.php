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
    return redirect('/home');
});

//Localization
Route::get('/lang/{locale}', 'LanguageController@index');

//Test
Route::get('/test', function () {
	$booking = App\Booking::find(1);
	$itinerary = App\Itinerary::find(1);
	$seats = [13,14,15];
    return new App\Mail\TicketSent($booking, $itinerary, $seats);
});

//PHP information
Route::get('/phpinfo', function () {
	return phpinfo();
});

//Frontend
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/detailSearch', 'HomeController@detailSearch')->name('detailSearch');
Route::get('/customerform', 'HomeController@customerform')->name('customerform');
Route::get('/itinerary/{id}', 'HomeController@itineraryDetail')->name('itineraryDetail');
Route::post('/search', 'HomeController@search')->name('search');
Route::post('/book', 'HomeController@book')->name('book');

//Api

//Auth
Auth::routes(['verify' => true]);
Route::middleware(['auth', 'verified'])->group(function () {
	Route::get('dashboard', function() {
		return view('backend.dashboard');
	})->name('dashboard');

	Route::resources([
		'locations' => 'LocationController',
		'companies' => 'CompanyController',
		'buses' => 'BusController',
		'itineraries' => 'ItineraryController',
		'bookings' => 'BookingController'
	]);
});