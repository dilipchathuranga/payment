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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home/bill_session', 'HomeController@bill_session');
Route::get('/get_session', 'HomeController@get_session');

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
Route::get('/get_accounts_by_supplier/{id}', 'MBankAccountController@get_accounts');


//payment->payment bill
Route::get('/payment_bill', 'PPaymentBillController@index')->name('payment_bill');
Route::post('/payment_bill/bulk_bill_receive', 'PPaymentBillController@bulk_bill_receive');
Route::get('/payment_bill/pending_payment_bills','PPaymentBillController@pending_payment_bills');
Route::get('/payment_bill/received_payment_bills','PPaymentBillController@received_payment_bills');
Route::post('/payment_bill/pending_payment_bills_datatable','PPaymentBillController@pending_payment_bills_datatable');
Route::post('/payment_bill/received_payment_bills_datatable','PPaymentBillController@received_payment_bills_datatable');
Route::get('/payment_bill/bill_receive/{id}', 'PPaymentBillController@bill_receive');
Route::post('/payment_bill/create_schedule', 'PPaymentBillController@create_schedule');
Route::put('/payment_bill/priority/{id}', 'PPaymentBillController@priority');
Route::put('/payment_bill/hold/{id}', 'PPaymentBillController@hold');
Route::put('/payment_bill/agent/{id}', 'PPaymentBillController@agent');

//payment->payment_schedule
Route::get('/payment_schedule', 'PScheduleController@index')->name('payment_schedule');
Route::post('/payment_schedule', 'PScheduleController@store');
Route::get('/payment_schedule/create','PScheduleController@create');
Route::get('/payment_schedule/view_payemt_bill/{id}','PScheduleController@view_payment_bill');
Route::get('/payment_schedule/check_schedule/{id}','PScheduleController@check_schedule');
Route::put('/payment_schedule/approve/{id}','PScheduleController@approve');
Route::put('/payment_schedule/pending/{id}','PScheduleController@pending');
Route::get('/payment_schedule/delete/{id}','PScheduleController@delete');
Route::put('/payment_schedule/add_all_approve','PScheduleController@add_all_approve');
Route::put('/payment_schedule/pay/{id}','PScheduleController@pay');

//payment->bank_account_attachment
Route::get('/bank_account_attachment', 'MBankAccountAttachmentController@index')->name('bank_account_attachment');
Route::post('/bank_account_attachment', 'MBankAccountAttachmentController@store');
Route::get('/bank_account_attachment/create','MBankAccountAttachmentController@create');
Route::get('/bank_account_attachment/{id}', 'MBankAccountAttachmentController@show');
Route::put('/bank_account_attachments/{id}', 'MBankAccountAttachmentController@update');
Route::delete('/bank_account_attachment/{id}', 'MBankAccountAttachmentController@destroy');
Route::get('/bank_account_attachment/show_table/{id}', 'MBankAccountAttachmentController@show_table');
Route::get('/bank_account_attachment/show_attachment/{id}', 'MBankAccountAttachmentController@show_attachment');
Route::get('/bank_account_attachment/download/{any}', 'MBankAccountAttachmentController@download');

//master->supplier
Route::get('/supplier', 'MSupplierController@index')->name('supplier');
Route::get('/supplier/create','MSupplierController@create');


//master->project
Route::get('/project', 'MProjectController@index')->name('project');
Route::get('/project/create','MProjectController@create');

//payment->payement_search
Route::get('/payment_search', 'PPaymentSearchController@index')->name('payment_search');
Route::get('/payment_search/create','PPaymentSearchController@create');
Route::get('/payment_search/tranfer_log/{id}','PPaymentSearchController@tranfer_log');


//payment->payement_export
Route::get('/billexport/{id}', 'Report\PPaymentExcelController@export');

//user_managment->role
Route::get('/role', 'URolesController@index')->name('role');
Route::post('/role', 'URolesController@store');
Route::get('/role/create', 'URolesController@create');
Route::get('/role/{id}', 'URolesController@show');
Route::put('/role/{id}', 'URolesController@update');
Route::delete('/role/{id}', 'URolesController@destroy');

//user_managment->user
Route::get('/user', 'UUserController@index')->name('user');
Route::post('/user', 'UUserController@store');
Route::get('/user/create', 'UUserController@create');
Route::get('/user/{id}', 'UUserController@show');
Route::put('/user/{id}', 'UUserController@update');
Route::delete('/user/{id}', 'UUserController@destroy');

//user->profile
Route::get('/profile', 'UProfileController@index')->name('profile');
Route::get('/change_password', 'UProfileController@store');




