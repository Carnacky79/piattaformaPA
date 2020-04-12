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

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();


Route::group(['middleware' => 'auth'], function () {
    Route::get('/download/{file}', 'DownloadsController@download')->name('download');

    Route::get('/home', 'ConvocazioneController@index')->name('dashboard');
    Route::get('/listaconv', 'ConvocazioneController@listaConv')->name('listaConv');
    Route::get('/creaconv', 'ConvocazioneController@create')->name('creaConv');
    Route::post('/addconv', 'ConvocazioneController@store')->name('addConv');
    Route::get('/listaconv/{conv}', 'ConvocazioneController@show')->name('showConv');
    Route::get('/delconv/{conv}', 'ConvocazioneController@destroy')->name('delConv');
    Route::post('/update/{conv}', 'ConvocazioneController@update')->name('updateConv');

    Route::get('/listadoc', 'DocumentoController@listaDoc')->name('listaDoc');
    Route::get('/listadocpref', 'DocumentoController@listaDocPref')->name('listadocPref');
    Route::delete('/deldoc/{doc}', 'DocumentoController@destroy')->name('delDoc');
    Route::delete('/deltag/{doc}', 'DocumentoController@deltag')->name('delTag');
    Route::get('/addfav/{doc}', 'DocumentoController@addDocFav')->name('addDocFav');

    //ROTTE dei TAGS

    //ROTTE degli Ordini del Giorno

    Route::delete('/delord/{ord}', 'OrdineController@destroy')->name('delOrd');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::patch('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::patch('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'PageController@index']);
});

