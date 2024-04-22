<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Generat Key 
$router->get('/key', function(){
    return str_random(32);
});


$router->group(['prefix' => '/user'], function () use ($router) {
    $router->post('create',  ['uses' => 'UserController@createUser']);
    $router->post('changePassword',  ['uses' => 'UserController@changePassword']);
    $router->post('setPass',  ['uses' => 'UserController@setPassword']);
    $router->get('getVersion',  ['uses' => 'UserController@getVersionAPK']);
});

$router->group(['prefix' => '/undangan'], function () use ($router) {
    $router->post('login',['uses' => 'AuthController@authenticate']);

    $router->group(['middleware' => 'jwt.auth'], function() use ($router) {
        
        $router->get('getBarcode',  ['uses' => 'UndanganController@getDisplayUndangan']);
        $router->get('searchDataUndangan',  ['uses' => 'UndanganController@getDataUndangan']);
        $router->get('dataTitipan',  ['uses' => 'UndanganController@getTitipan']);
        $router->post('submitUndangan',  ['uses' => 'UndanganController@simpanData']);
	    $router->post('updateSouvenir',  ['uses' => 'UndanganController@updateSouvenir']);
	    $router->post('cetakTitipan',  ['uses' => 'UndanganController@updateTitipan']);
        $router->post('submitUndanganTambahan',  ['uses' => 'UndanganController@saveUndanganTambahan']);
        $router->get('getKategori',  ['uses' => 'UndanganController@getListKategori']);  
        
        $router->get('getDaftarHadir', ['uses' => 'LapUndangan@get_daftar_hadir']);
        $router->get('getDaftarBelum', ['uses' => 'LapUndangan@get_daftar_belum']);
        $router->get('getDaftarTidakHadir', ['uses' => 'LapUndangan@get_daftar_tidak_hadir']);
        $router->get('getDaftarKurang', ['uses' => 'LapUndangan@get_daftar_kurang']);
        $router->get('getDaftarTambahan', ['uses' => 'LapUndangan@get_daftar_tambahan']);
        $router->get('getDaftarMelebihi', ['uses' => 'LapUndangan@get_daftar_melebihi']);
        $router->get('getRekapUndangan', ['uses' => 'LapUndangan@get_rekap_undangan']);
        $router->get('getTotalRekap', ['uses' => 'LapUndangan@get_total_rekap']);
		$router->get('getJmlUndangan',  ['uses' => 'LapUndangan@getJmlUndangan']); 


        $router->get('getParkir',  ['uses' => 'UndanganController@getParkir']);
		$router->get('getZona',  ['uses' => 'UndanganController@getListZona']);  
		

    });
});