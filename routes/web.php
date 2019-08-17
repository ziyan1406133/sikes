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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/register', function(){
    return redirect('/');
});
Route::get('/elements', function(){
    return view('elements');
});
Route::resource('user', 'UserController');
Route::resource('tahunajaran', 'TahunAjaranController');
Route::resource('jenisk', 'JeniskController');
Route::resource('jenist', 'JenistController');
Route::resource('BOS', 'BosController');
Route::resource('pemasukanlain', 'LainController');
Route::resource('pengeluaranrutin', 'PengeluaranRutinController');
Route::resource('pengeluarannonrutin', 'PengeluaranNonRutinController');

//Kelola kelas
Route::resource('kelas', 'KelasController');
Route::post('/kelas/tambah', 'KelasController@tambah')->name('kelasuser.tambah');
Route::put('/kelas/{id}/edit', 'KelasController@ubah')->name('kelasuser.ubah');
Route::delete('/kelas/{id}/hapus', 'KelasController@hapus')->name('kelasuser.hapus');

//Kelola Tagihan
Route::get('/tagihan', 'TagihanController@index')->name('tagihan.index');
Route::post('/tagihan/tambah', 'TagihanController@tambah')->name('tagihan.tambah');
Route::post('/tagihan/tambahspp', 'TagihanController@tambahspp')->name('tagihan.tambahspp');
Route::post('/tagihan/tambahlain', 'TagihanController@tambahlain')->name('tagihan.tambahlain');
Route::get('/tagihan/{id}', 'TagihanController@show')->name('tagihan.show');
Route::delete('/tagihan/{id}/hapusspp', 'TagihanController@hapusspp')->name('tagihan.hapusspp');
Route::delete('/tagihan/{id}/hapuslain', 'TagihanController@hapuslain')->name('tagihan.hapuslain');
Route::put('/tagihan/{id}/editspp', 'TagihanController@editspp')->name('tagihan.editspp');
Route::put('/tagihan/{id}/editlain', 'TagihanController@editlain')->name('tagihan.editlain');

//Verifikasi pengeluaran non rutin
Route::put('/pengeluarannonrutin/{id}/terima', 'PengeluaranNonRutinController@terima')->name('terima');
Route::put('/pengeluarannonrutin/{id}/tolak', 'PengeluaranNonRutinController@tolak')->name('tolak');

//Laporan
Route::get('/laporanmasuk', 'LaporanController@indexmasuk')->name('masuk.index');
Route::get('/laporankeluar', 'LaporanController@indexkeluar')->name('keluar.index');
Route::get('/laporanrutin', 'LaporanController@indexrutin')->name('rutin.index');
Route::get('/laporanspp', 'LaporanController@indexspp')->name('spp.index');
Route::post('/laporanmasuk/filter', 'LaporanController@filtermasuk')->name('tagihan.filtermasuk');
Route::post('/laporankeluar/filter', 'LaporanController@filterkeluar')->name('tagihan.filterkeluar');
Route::post('/laporanrutin/filter', 'LaporanController@filterrutin')->name('tagihan.filterrutin');
Route::post('/laporanspp/filter', 'LaporanController@filterspp')->name('tagihan.filterspp');
Route::post('/laporanmasuk/pdf', 'LaporanController@pdfmasuk')->name('tagihan.pdfmasuk');
Route::post('/laporankeluar/pdf', 'LaporanController@pdfkeluar')->name('tagihan.pdfkeluar');
Route::post('/laporanrutin/pdf', 'LaporanController@pdfrutin')->name('tagihan.pdfrutin');
Route::post('/laporanspp/pdf', 'LaporanController@pdfspp')->name('tagihan.pdfspp');

//edit password
Route::get('/editpassword/{id}/user', 'UserController@editpassword')->name('edit');
Route::put('/editpassword/{id}', 'UserController@editpassword1')->name('password');