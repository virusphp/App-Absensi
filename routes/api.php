<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

Route::get('/tanggalserver', function(){
    date_default_timezone_set('Asia/Jakarta');
    $data = [
        'tanggal' => date('Y-m-d'),
        'waktu' => date('H:i:s')
    ];
    return response()->jsonSuccess(200, "OK",$data);
});

Route::group(['namespace' => 'Api'], function() {

    Route::post('/access/register', 'RegistrasiPlatformController@register')->name('register.acceess');
    Route::post('/access/login', 'LoginPlatformController@login')->name('login.acceess');

    Route::group(['middleware' => ['signature:api']], function (){
        Route::post('/pegawai/verif', "RegistrasiController@verified");
        Route::post('/register', 'RegistrasiController@register')->name('register.api');
        Route::post('/login', 'LoginController@login')->name('login.api');
        Route::post('/edit/smartphone', 'UpdateSmartphoneController@editSmartphone')->name('edit.smartphone');
        Route::post('/update/smartphone', 'UpdateSmartphoneController@updateSmartphone')->name('update.smartphone');
        Route::get('/pegawai', 'PegawaiController@getPegawai')->name('pegawai.all');
        Route::get('/pegawai/{pegawai}', 'PegawaiController@getPegawaiDetail')->name('pegawai.detail');
        Route::get('/subunit', 'UnitController@getSubunit')->name('subunit.all');

        Route::group(["middleware" => ["cors:api",]], function() {
            Route::post('/absen', 'AbsenController@postAbsen')->name('absen');
            Route::post('/absen/ulang', 'AbsenController@reAbsen')->name('absen');
            Route::post('/daftar/absen', 'AbsenController@postDaftarAbsen')->name('daftar.absen');
            Route::post('/daftar/absen/unit', 'AbsenController@postDaftarAbsenUnit')->name('daftar.absen.unit');
        });
    });
});