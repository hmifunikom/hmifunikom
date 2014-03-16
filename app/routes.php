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

if(App::environment('production'))
{
    $domain = '.hmifunikom.org';
}
else
{
    $domain = '.localhmifunikom.com';   
}


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

    $routename = str_replace('/', '.', $resource);

    Route::get($urllist,                           array( 'as' => $suffix_name.$routename.'.index', 'uses' => $controller . '@index' ));
    Route::get($urllist.'/create',                 array( 'as' => $suffix_name.$routename.'.create', 'uses' => $controller . '@create' ));
    Route::get($urlitem,        array( 'as' => $suffix_name.$routename.'.show', 'uses' => $controller . '@show' ));
    Route::post($urllist,                          array( 'as' => $suffix_name.$routename.'.store', 'uses' => $controller . '@store'));
    Route::get($urlitem.'/edit',   array( 'as' => $suffix_name.$routename.'.edit', 'uses' => $controller . '@edit' ));
    Route::put($urlitem,        array( 'as' => $suffix_name.$routename.'.update', 'uses' => $controller . '@update' ));
    Route::delete($urlitem,     array( 'as' => $suffix_name.$routename.'.destroy', 'uses' => $controller . '@destroy' ));
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

Route::model('ifgames', 'IFGCabang');
Route::model('cabang', 'IFGCabang');
Route::model('tim', 'IFGTim');
Route::model('anggota', 'IFGAnggotaTim');

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
    Route::group(array('prefix' => 'ifgames'), function()
   {
        Route::get('/', array('uses' => 'IFGamesController@index', 'as' => 'ifgames.index'));    
        Route::get('pendaftaran', array('uses' => 'IFGamesController@pendaftaran', 'as' => 'ifgames.pendaftaran'));
        route_resource('anggota', 'IFGamesAnggota', 'ifgames');

        Route::get('register', array('uses' => 'IFGamesController@cabang', 'as' => 'ifgames.cabang'));
        Route::get('register/{cabang}', array('uses' => 'IFGamesController@create', 'as' => 'ifgames.create'));
        Route::post('register/{cabang}', array('uses' => 'IFGamesController@store', 'as' => 'ifgames.store'));

        Route::get('login', array('uses' => 'IFGamesSessionsController@create', 'as' => 'ifgames.sessions.create'));
        Route::post('login', array('uses' => 'IFGamesSessionsController@store', 'as' => 'ifgames.sessions.store'));
        Route::get('logout', array('uses' => 'IFGamesSessionsController@destroy', 'as' => 'ifgames.sessions.destroy'));
    });

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
    Route::get('event/{event}/peserta/download', array('uses' => 'PanelEventPesertaController@xls', 'as' => 'panel.event.peserta.xls'));
    Route::get('event/{event}/peserta/contact', array('uses' => 'PanelEventPesertaController@vcf', 'as' => 'panel.event.peserta.vcf'));
    route_resource('event.peserta', 'PanelEventPesertaController', 'panel');
    Route::get('event/{event}/peserta/{peserta}/pay', array('uses' => 'PanelEventPesertaController@pay', 'as' => 'panel.event.peserta.pay'));

    route_resource('ifgames', 'PanelIFGamesCabangController', 'panel');
    route_resource('ifgames.jabatan', 'PanelIFGamesJabatanController', 'panel');
    route_resource('ifgames.tim', 'PanelIFGamesTimController', 'panel');
    Route::get('ifgames/{ifgames}/tim/{tim}/pay', array('uses' => 'PanelIFGamesTimController@pay', 'as' => 'panel.ifgames.tim.pay'));
    route_resource('ifgames.tim.anggota', 'PanelIFGamesAnggotaTimController', 'panel');
    Route::get('ifgames/{ifgames}/tim/{tim}/anggota/{anggota}/ska', array('uses' => 'PanelIFGamesAnggotaTimController@ska', 'as' => 'panel.ifgames.tim.anggota.ska'));
    Route::get('ifgames/{ifgames}/tim/{tim}/anggota/{anggota}/ktm', array('uses' => 'PanelIFGamesAnggotaTimController@ktm', 'as' => 'panel.ifgames.tim.anggota.ktm'));


    route_resource('arsip', 'PanelArsipController', 'panel');

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