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

$domain = '.localhmifunikom.com';

function route_resource($resource, $controller, $suffix_name = '')
{
    if($suffix_name != '')
        $suffix_name = $suffix_name.'.';

    $parents = explode('.', $resource);
    $path = array_pop($parents);

    $url = array();
    foreach($parents as $res)
    {
        $url[] = $res.'/{'.$res.'}';
    }

    $urllist = implode('/', $url).'/'.$path;
    $urlitem = implode('/', $url).'/'.$path.'/{'.$path.'}';

    Route::get($urllist,                           array( 'as' => $suffix_name.$resource.'.index', 'uses' => $controller . '@index' ));
    Route::get($urllist.'/create',                 array( 'as' => $suffix_name.$resource.'.create', 'uses' => $controller . '@create' ));
    Route::get($urlitem,        array( 'as' => $suffix_name.$resource.'.show', 'uses' => $controller . '@show' ));
    Route::post($urllist,                          array( 'as' => $suffix_name.$resource.'.store', 'uses' => $controller . '@store'));
    Route::get($urlitem.'/edit',   array( 'as' => $suffix_name.$resource.'.edit', 'uses' => $controller . '@edit' ));
    Route::put($urlitem,        array( 'as' => $suffix_name.$resource.'.update', 'uses' => $controller . '@update' ));
    Route::delete($urlitem,     array( 'as' => $suffix_name.$resource.'.destroy', 'uses' => $controller . '@destroy' ));
}

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

Route::group(array('domain' => 'www'.$domain), function()
{
    Route::get('/', array('uses' => 'HomeController@index', 'as' => 'index'));
});

Route::group(array('domain' => 'event'.$domain), function()
{
    Route::get('/', array('uses' => 'EventController@index', 'as' => 'event.index'));
    Route::get('{event}', array('uses' => 'EventController@show', 'as' => 'event.show'));
    Route::get('{event}/book', array('uses' => 'EventBookController@create', 'as' => 'event.book.create'));
    Route::post('{event}/book', array('uses' => 'EventBookController@store', 'as' => 'event.book.store'));
    Route::get('{event}/book/{ticket}', array('uses' => 'EventBookController@show', 'as' => 'event.book.show'));
    Route::get('{event}/book/{ticket}/download', array('uses' => 'EventBookController@download', 'as' => 'event.book.download'));
});

Route::group(array('domain' => 'team'.$domain), function()
{
    Route::get('/', array('uses' => 'KeanggotaanController@index', 'as' => 'keanggotaan.index'));
    Route::get('{keanggotaan}', array('uses' => 'KeanggotaanController@show', 'as' => 'keanggotaan.show'));
});

Route::group(array('domain' => 'library'.$domain), function()
{
    Route::get('/', array('uses' => 'PerpustakaanController@index', 'as' => 'perpustakaan.index'));
    Route::get('{perpustakaan}', array('uses' => 'PerpustakaanController@show', 'as' => 'perpustakaan.show'));
});

/*
|--------------------------------------------------------------------------
| Panel Controller
|--------------------------------------------------------------------------
*/

Route::get('login', array('uses' => 'SessionsController@create', 'as' => 'sessions.create'));
Route::post('login', array('uses' => 'SessionsController@store', 'as' => 'sessions.store'));
Route::get('logout', array('uses' => 'SessionsController@destroy', 'as' => 'sessions.destroy'));

Route::group(array('domain' => 'panel'.$domain, 'before' => 'auth|norole:publik'), function()
{
    Route::get('/', function()
    {
        return Redirect::route('panel.index');
    });

    Route::get('dashboard', array('uses' => 'PanelDashboardController@index', 'as' => 'panel.index'));

    route_resource('keanggotaan', 'PanelKeanggotaanController', 'panel');
    route_resource('keanggotaan.kas', 'PanelKeanggotaanKasController', 'panel');
    route_resource('keanggotaan.hp', 'PanelKeanggotaanHpController', 'panel');
    route_resource('keanggotaan.email', 'PanelKeanggotaanEmailController', 'panel');
    route_resource('keanggotaan/divisi', 'PanelKeanggotaanDivisiController', 'panel');

    route_resource('event', 'PanelEventController', 'panel');
    Route::post('event/{event}/poster', array('uses' => 'PanelEventController@posterStore', 'as' => 'panel.event.poster.store'));
    Route::delete('event/{event}/poster', array('uses' => 'PanelEventController@posterDelete', 'as' => 'panel.event.poster.destroy'));
    route_resource('event.waktu', 'PanelEventWaktuController', 'panel');
    route_resource('event.div', 'PanelEventDivisiController', 'panel');
    route_resource('event.panitia', 'PanelEventPanitiaController', 'panel');
    route_resource('event.peserta', 'PanelEventPesertaController', 'panel');
    Route::get('event/{event}/peserta/{peserta}/pay', array('uses' => 'PanelEventPesertaController@pay', 'as' => 'panel.event.peserta.pay'));

    route_resource('arsip', 'PanelArsipController', 'panel');

    Route::get('shut/the/application/down', function() 
    {
        touch(storage_path().'/meta/my.down');
    });

    Route::get('bring/the/application/back/up', function() 
    {
        @unlink(storage_path().'/meta/my.down');
    });
});
Route::group(array('prefix' => 'panel', 'before' => 'auth|norole:publik'), function()
{
    Route::resource('event.waktu', 'PanelEventWaktuController');
});

Route::when('*', 'csrf', array('post', 'put', 'patch'));

/*
|--------------------------------------------------------------------------
| Application Error
|--------------------------------------------------------------------------
*/

App::missing(function($exception)
{
    return Response::view('pages.errors.404', array('pagetitle' => 'Halaman tidak ditemukan'), 404);
});

App::error(function(Illuminate\Session\TokenMismatchException $exception)
{
    return Response::view('pages.errors.csrf', array('pagetitle' => 'Error terjadi'), 400);
});

App::error(function(HMIF\Exceptions\RoleException $exception)
{
    return Response::view('pages.errors.401', array('pagetitle' => 'Akses ditolak'), 401);
});