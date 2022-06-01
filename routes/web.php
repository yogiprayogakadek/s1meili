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
    return view('templates.master');
})->name('main')->middleware('auth');
Route::prefix('/')->namespace('Main')->middleware('auth')->group(function(){
    Route::prefix('/barang')->group(function(){
        Route::get('/', 'BarangController@index')->name('barang.index');
        Route::get('/create', 'BarangController@create')->name('barang.create');
        Route::get('/edit/{id}', 'BarangController@edit')->name('barang.edit');
        Route::get('/render', 'BarangController@render')->name('barang.render');
        Route::post('/store', 'BarangController@store')->name('barang.store');
        Route::post('/update', 'BarangController@update')->name('barang.update');
        Route::get('/delete/{id}', 'BarangController@delete')->name('barang.delete');
        Route::get('/print/{id}', 'BarangController@print')->name('barang.print');
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
