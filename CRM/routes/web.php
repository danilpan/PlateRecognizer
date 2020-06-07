<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
Route::post('/recognize', 'Recognizer@recognizeAction');
Route::get('/home', 'HomeController@index')->name('home');
Route::redirect('/', '/home');
Route::view('/team', 'team');

Route::middleware(['auth'])->group(function () {
    Route::resource('companies', 'CompanyController');
    Route::resource('offices', 'OfficeController');
    Route::resource('gates', 'GateController');
    Route::resource('cars', 'CarController');
    Route::get('/history', 'HomeController@entersAction');
});
