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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



// Admin Auth 

Route::group( [ 'prefix' => 'admin_area', 'middleware' => [ 'auth', 'admin' ] ], function () {


Route::get( '/', function () {

	return view( 'admin.index' );

} )->name( 'admin.index' );


// Blog Routes

Route::get('/create_vehicle','AdminController@addVehicle');
Route::post('/save_vehicle','AdminController@storeVehicle')->name('storeVehicle');
Route::any('/delete_vehicle/{id}','AdminController@deleteVehicle')->name('deleteVehicle');
 

Route::get('/create_transaction','AdminController@addtransaction');
Route::post('/save_transaction','AdminController@storeTransaction')->name('storeTransaction');
Route::any('/delete_transaction/{id}','AdminController@deleteTransaction')->name('deleteTransaction');


// Profile And Admins

Route::get('/update_profile','AdminController@profileUpdate');
Route::post('/store_profile', 'AdminController@storeProfile')->name('storeProfile');
Route::any('/delete_admin/{id}','AdminController@deleteAdmin')->name('deleteAdmin');
Route::post('/store_admin', 'AdminController@storeAdmin')->name('storeAdmin');


// Chart Routes

Route::get('/charts','AdminController@dashCharts');
 
 

});
