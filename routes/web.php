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
/*
Route::get('/', function () {
    return view('home');
});
*/

use App\Http\Controllers\FormulasiController;

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index');
/*
Route::get('/user', 'UserController@index');
Route::get('/user-register', 'UserController@create');
Route::post('/user-register', 'UserController@store');
Route::get('/user-edit/{id}', 'UserController@edit');
*/
Route::resource('user', 'UserController');

Route::resource('anggota', 'AnggotaController');

Route::resource('buku', 'BukuController');
Route::get('/format_buku', 'BukuController@format');
Route::post('/import_buku', 'BukuController@import');

Route::resource('transaksi', 'TransaksiController');
Route::get('/laporan/trs', 'LaporanController@transaksi');
Route::get('/laporan/trs/pdf', 'LaporanController@transaksiPdf');
Route::get('/laporan/trs/excel', 'LaporanController@transaksiExcel');

Route::get('/laporan/buku', 'LaporanController@buku');
Route::get('/laporan/buku/pdf', 'LaporanController@bukuPdf');
Route::get('/laporan/buku/excel', 'LaporanController@bukuExcel');


Route::get('/livetable', 'LiveTableController@index');
Route::get('/livetable/fetch_data', 'LiveTableController@fetch_data');
Route::post('/livetable/add_data', 'LiveTableController@add_data')->name('LiveTableController.add_data');
Route::post('/livetable/update_data', 'LiveTableController@update_data')->name('LiveTableController.update_data');
Route::post('/livetable/delete_data', 'LiveTableController@delete_data')->name('LiveTableController.delete_data');

Route::resource('/inline', 'InlineController');

Route::get('formulasi/create/{formid}', 'FormulasiController@create')->name('formulasi.create');
//Route::get('formulasi/edit/{projectid}/{projectidx}', 'FormulasiController@edit');
Route::resource('formulasi', 'FormulasiController');

// Route::get('mobil', 'MobilController@index')->name('mobil.index');
// Route::get('mobil/create', 'MobilController@create')->name('mobil.create');
// Route::post('mobil', 'MobilController@store')->name('mobil.store');
