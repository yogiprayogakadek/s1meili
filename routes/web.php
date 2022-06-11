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
    Route::prefix('/barang')->name('barang.')->group(function(){
        Route::get('/', 'BarangController@index')->name('index');
        Route::get('/create', 'BarangController@create')->name('create');
        Route::get('/edit/{id}', 'BarangController@edit')->name('edit');
        Route::get('/render', 'BarangController@render')->name('render');
        Route::post('/store', 'BarangController@store')->name('store');
        Route::post('/update', 'BarangController@update')->name('update');
        Route::get('/delete/{id}', 'BarangController@delete')->name('delete');
        Route::get('/print/{id}', 'BarangController@print')->name('print');
    });

    Route::prefix('/pengadaan')->name('pengadaan.')->group(function(){
        Route::get('/', 'PengadaanController@index')->name('index');
        Route::get('/create', 'PengadaanController@create')->name('create');
        Route::get('/edit/{id}', 'PengadaanController@edit')->name('edit');
        Route::get('/render', 'PengadaanController@render')->name('render');
        Route::post('/store', 'PengadaanController@store')->name('store');
        Route::post('/update', 'PengadaanController@update')->name('update');
        Route::get('/delete/{id}', 'PengadaanController@delete')->name('delete');
        Route::get('/item-pengadaan/{id_pengadaan}', 'PengadaanController@itemPengadaan')->name('item-pengadaan');
        Route::get('/print/{id}', 'PengadaanController@print')->name('print');
        Route::post('/validasi', 'PengadaanController@validasi')->name('validasi');
        Route::get('/detail-validasi/{id_pengadaan}', 'PengadaanController@detailValidasi')->name('detail-validasi');
        Route::post('/unggah-nota', 'PengadaanController@unggahNota')->name('unggah-nota');
    });

    Route::prefix('/pengadaan-histori')->name('pengadaan-histori.')->group(function(){
        Route::get('/', 'PengadaanHistoriController@index')->name('index');
        Route::get('/render', 'PengadaanHistoriController@render')->name('render');
        Route::post('/validasi', 'PengadaanHistoriController@validasi')->name('validasi');
        Route::get('/detail-validasi/{id_pengadaan}', 'PengadaanHistoriController@detailValidasi')->name('detail-validasi');
    });

    Route::prefix('/perbaikan')->name('perbaikan.')->group(function(){
        Route::get('/', 'PerbaikanController@index')->name('index');
        Route::get('/create', 'PerbaikanController@create')->name('create');
        Route::get('/edit/{id}', 'PerbaikanController@edit')->name('edit');
        Route::get('/render', 'PerbaikanController@render')->name('render');
        Route::post('/store', 'PerbaikanController@store')->name('store');
        Route::post('/update', 'PerbaikanController@update')->name('update');
        Route::get('/delete/{id}', 'PerbaikanController@delete')->name('delete');
        Route::get('/item-perbaikan/{id_maintenance}', 'PerbaikanController@itemPerbaikan')->name('item-pengadaan');
        Route::get('/print/{id}', 'PerbaikanController@print')->name('print');
        Route::post('/validasi', 'PerbaikanController@validasi')->name('validasi');
        Route::get('/detail-validasi/{id_maintenance}', 'PerbaikanController@detailValidasi')->name('detail-validasi');
        Route::post('/unggah-nota', 'PerbaikanController@unggahNota')->name('unggah-nota');
    });

    Route::prefix('/kerusakan')->name('kerusakan.')->group(function(){
        Route::get('/', 'KerusakanController@index')->name('index');
        Route::get('/create', 'KerusakanController@create')->name('create');
        Route::get('/edit/{id}', 'KerusakanController@edit')->name('edit');
        Route::get('/render', 'KerusakanController@render')->name('render');
        Route::post('/store', 'KerusakanController@store')->name('store');
        Route::post('/update', 'KerusakanController@update')->name('update');
        Route::get('/delete/{id}', 'KerusakanController@delete')->name('delete');
        Route::get('/item-kerusakan/{id_maintenance}', 'KerusakanController@itemKerusakan')->name('item-pengadaan');
        Route::get('/print/{id}', 'KerusakanController@print')->name('print');
        Route::post('/validasi', 'KerusakanController@validasi')->name('validasi');
        Route::get('/detail-validasi/{id_maintenance}', 'KerusakanController@detailValidasi')->name('detail-validasi');
        Route::post('/unggah-nota', 'KerusakanController@unggahNota')->name('unggah-nota');
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
