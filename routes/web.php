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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//master->bank
Route::get('/bank', 'MBankController@index')->name('bank');
Route::post('/bank', 'MBankController@store');
Route::get('/bank/create', 'MBankController@create');
Route::get('/bank/{id}', 'MBankController@show');
Route::put('/bank/{id}', 'MBankController@update');
Route::delete('/bank/{id}', 'MBankController@destroy');

//master->branch
Route::get('/branch', 'MBranchController@index')->name('branch');
Route::post('/branch', 'MBranchController@store');
Route::get('/branch/create','MBranchController@create');
Route::get('/branch/{id}', 'MBranchController@show');
Route::put('/branch/{id}', 'MBranchController@update');
Route::delete('/branch/{id}', 'MBranchController@destroy');
Route::get('/branch/get_by_bank_id/{id}', 'MBranchController@get_by_bank_id');

//master->bank_account
Route::get('/bank_account', 'MBankAccountController@index')->name('bank_account');
Route::post('/bank_account', 'MBankAccountController@store');
Route::get('/bank_account/create','MBankAccountController@create');
Route::get('/bank_account/{id}', 'MBankAccountController@show');
Route::put('/bank_account/{id}', 'MBankAccountController@update');
Route::delete('/bank_account/{id}', 'MBankAccountController@destroy');
Route::get('/get_supplier/{id}', 'MBankAccountController@get_supplier');
Route::put('/get_bank_account_status/{id}', 'MBankAccountController@get_status');

//payment->bank_account
Route::get('/payment_bill', 'PPaymentBillController@index')->name('payment_bill');
Route::post('/payment_bill', 'PPaymentBillController@store');
Route::get('/payment_bill/create','PPaymentBillController@create');
Route::get('/payment_bill/{id}', 'PPaymentBillController@show');
Route::put('/payment_bill/{id}', 'PPaymentBillController@update');
Route::delete('/payment_bill/{id}', 'PPaymentBillController@destroy');

