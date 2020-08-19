<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api'], function() {

    Route::post('/access/register', 'RegistrasiPlatformController@register')->name('register.acceess');
    Route::post('/access/login', 'LoginPlatformController@login')->name('login.acceess');

    Route::group(['middleware' => ['signature:api']], function (){
        Route::post('/pegawai/verif', "RegistrasiController@verified");
        Route::post('/register', 'RegistrasiController@register')->name('register');
        Route::post('/login', 'LoginController@login')->name('login');
        Route::get('/pegawai', 'PegawaiController@getPegawai')->name('pegawai.all');
        Route::get('/pegawai/{pegawai}', 'PegawaiController@getPegawaiDetail')->name('pegawai.detail');

        Route::group(["middleware" => ["cors:api",]], function() {
            Route::post('/absen', 'AbsenController@postAbsen')->name('absen');
            Route::post('/daftar/absen', 'AbsenController@postDaftarAbsen')->name('daftar.absen');
        });
    });
});