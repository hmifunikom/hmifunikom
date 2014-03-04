<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Model Binding
|--------------------------------------------------------------------------
*/

Route::model('keanggotaan', 'Anggota');
Route::model('divisi', 'Divisi');
Route::model('kas', 'Kas');
Route::model('hp', 'Hp');
Route::model('email', 'Email');

Route::model('event', 'Acara');
Route::model('waktu', 'WaktuAcara');
Route::model('div', 'DivAcara');
Route::model('panitia', 'Panitia');
Route::model('peserta', 'Peserta');
Route::model('ticket', 'Peserta');

Route::pattern('keanggotaan', '\d+');


/*
|--------------------------------------------------------------------------
| Frontend Controller
|--------------------------------------------------------------------------
*/

Route::get('/', array('uses' => 'HomeController@index', 'as' => 'index'));

Route::resource('event', 'EventController',
                array('only' => array('index', 'show')));

Route::get('event/{event}/book', array('uses' => 'EventBookController@create', 'as' => 'event.book.create'));
Route::post('event/{event}/book', array('uses' => 'EventBookController@store', 'as' => 'event.book.store'));
Route::get('event/{event}/book/{ticket}', array('uses' => 'EventBookController@show', 'as' => 'event.book.show'));

Route::resource('keanggotaan', 'KeanggotaanController',
                array('only' => array('index', 'show')));

Route::resource('perpustakaan', 'PerpustakaanController',
                array('only' => array('index', 'show')));

/*
|--------------------------------------------------------------------------
| Panel Controller
|--------------------------------------------------------------------------
*/

Route::get('login', array('uses' => 'SessionsController@create', 'as' => 'sessions.create'));
Route::post('login', array('uses' => 'SessionsController@store', 'as' => 'sessions.store'));
Route::get('logout', array('uses' => 'SessionsController@destroy', 'as' => 'sessions.destroy'));

Route::group(array('prefix' => 'panel', 'before' => 'auth|norole:publik'), function()
{
    Route::get('/', function()
    {
        return Redirect::route('panel.index');
    });

    Route::get('dashboard', array('uses' => 'PanelDashboardController@index', 'as' => 'panel.index'));

    Route::resource('keanggotaan', 'PanelKeanggotaanController');
    Route::resource('keanggotaan.kas', 'PanelKeanggotaanKasController');
    Route::resource('keanggotaan.hp', 'PanelKeanggotaanHpController');
    Route::resource('keanggotaan.email', 'PanelKeanggotaanEmailController');
    Route::resource('keanggotaan/divisi', 'PanelKeanggotaanDivisiController');

    Route::resource('event', 'PanelEventController');
    Route::resource('event.waktu', 'PanelEventWaktuController');
    Route::resource('event.div', 'PanelEventDivisiController');
    Route::resource('event.panitia', 'PanelEventPanitiaController');
    Route::resource('event.peserta', 'PanelEventPesertaController');

    Route::resource('arsip', 'PanelArsipController');

    Route::get('shut/the/application/down', function() 
    {
        touch(storage_path().'/meta/my.down');
    });

    Route::get('bring/the/application/back/up', function() 
    {
        @unlink(storage_path().'/meta/my.down');
    });
});

Route::when('login', 'csrf', array('post', 'put', 'patch'));
Route::when('panel/*', 'csrf', array('post', 'put', 'patch'));

/*
|--------------------------------------------------------------------------
| Application Error
|--------------------------------------------------------------------------
*/

App::missing(function($exception)
{
    return Response::view('pages.errors.404', array(), 404);
});

App::error(function(Illuminate\Session\TokenMismatchException $exception)
{
    return Response::view('pages.errors.csrf', array(), 400);
});

App::error(function(HMIF\Exceptions\RoleException $exception)
{
    return Response::view('pages.errors.401', array(), 401);
});
