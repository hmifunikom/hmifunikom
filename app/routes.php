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

    Route::get($urllist,            array( 'as' => $suffix_name.$routename.'.index', 'uses' => $controller . '@index' ));
    Route::get($urllist.'/create',  array( 'as' => $suffix_name.$routename.'.create', 'uses' => $controller . '@create' ));
    Route::get($urlitem,            array( 'as' => $suffix_name.$routename.'.show', 'uses' => $controller . '@show' ));
    Route::post($urllist,           array( 'as' => $suffix_name.$routename.'.store', 'uses' => $controller . '@store'));
    Route::get($urlitem.'/edit',    array( 'as' => $suffix_name.$routename.'.edit', 'uses' => $controller . '@edit' ));
    Route::put($urlitem,            array( 'as' => $suffix_name.$routename.'.update', 'uses' => $controller . '@update' ));
    Route::delete($urlitem,         array( 'as' => $suffix_name.$routename.'.destroy', 'uses' => $controller . '@destroy' ));
}

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
        Route::model('cabang', 'IFGCabang');
        Route::model('anggota', 'IFGAnggotaTim');

        Route::get('/', array('uses' => 'IFGamesController@index', 'as' => 'ifgames.index'));    
        Route::get('pendaftaran', array('uses' => 'IFGamesController@pendaftaran', 'as' => 'ifgames.pendaftaran'));
        route_resource('anggota', 'IFGamesAnggota', 'ifgames');

        Route::get('kuitansi', array('uses' => 'IFGamesAnggota@download', 'as' => 'ifgames.anggota.download'));

        Route::get('register', array('uses' => 'IFGamesController@cabang', 'as' => 'ifgames.cabang'));
        Route::get('register/{cabang}', array('uses' => 'IFGamesController@create', 'as' => 'ifgames.create'));
        Route::post('register/{cabang}', array('uses' => 'IFGamesController@store', 'as' => 'ifgames.store'));

        Route::get('login', array('uses' => 'IFGamesSessionsController@create', 'as' => 'ifgames.sessions.create'));
        Route::post('login', array('uses' => 'IFGamesSessionsController@store', 'as' => 'ifgames.sessions.store'));
        Route::get('logout', array('uses' => 'IFGamesSessionsController@destroy', 'as' => 'ifgames.sessions.destroy'));
    });

    Route::model('event', 'HMIF\Model\Acara\Acara');
    Route::model('ticket', 'HMIF\Model\Acara\Peserta');

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

Route::group(array('domain' => 'session'.$domain), function()
{
    Route::get('/', function()
    {
        return Redirect::route('index');
    });

    Route::get('login', array('uses' => 'SessionsController@create', 'as' => 'sessions.create'));
    Route::post('login', array('uses' => 'SessionsController@store', 'as' => 'sessions.store'));
    Route::get('logout', array('uses' => 'SessionsController@destroy', 'as' => 'sessions.destroy'));

    Route::controller('password', 'RemindersController');
    Route::get('password/remind', array('uses' => 'RemindersController@getRemind', 'as' => 'sessions.password.forget'));
    Route::post('password/remind', array('uses' => 'RemindersController@postRemind', 'as' => 'sessions.password.send'));
    Route::get('password/reset', array('uses' => 'RemindersController@getReset', 'as' => 'sessions.password.reset'));
    Route::post('password/reset', array('uses' => 'RemindersController@postReset', 'as' => 'sessions.password.set'));
});

Route::group(array('domain' => 'panel'.$domain, 'before' => 'auth|norole:publik'), function()
{
    if (Request::is('keanggotaan/*'))
    {     
        Route::model('keanggotaan', 'HMIF\Model\Keanggotaan\Anggota');
        Route::model('divisi', 'HMIF\Model\Keanggotaan\Divisi');
        Route::model('kas', 'HMIF\Model\Keanggotaan\Kas');
        Route::model('hp', 'HMIF\Model\Keanggotaan\Hp');
        Route::model('email', 'HMIF\Model\Keanggotaan\Email');
        Route::pattern('keanggotaan', '\d+');
    }

    if (Request::is('event/*'))
    {
        Route::model('event', 'HMIF\Model\Acara\Acara');
        Route::model('waktu', 'HMIF\Model\Acara\WaktuAcara');
        Route::model('div', 'HMIF\Model\Acara\DivAcara');
        Route::model('panitia', 'HMIF\Model\Acara\Panitia');
        Route::model('peserta', 'HMIF\Model\Acara\Peserta');
    }

    if (Request::is('ifgames/*'))
    {
        Route::model('ifgames', 'HMIF\Model\IFGames\Cabang');
        Route::model('cabang', 'HMIF\Model\IFGames\Cabang');
        Route::model('tim', 'HMIF\Model\IFGames\Tim');
        Route::model('anggota', 'HMIF\Model\IFGames\AnggotaTim');        
    }

    if (Request::is('pelatihan/*'))
    {
        Route::model('pelatihananggota', 'HMIF\Model\Pelatihan\Anggota');
    }

    if (Request::is('cakrawala/*'))
    {
        Route::model('tim', 'CakrawalaKompetisiTim');
    }    

    Route::get('/', function()
    {
        return Redirect::route('panel.index');
    });

    Route::get('dashboard', array('uses' => 'PanelDashboardController@index', 'as' => 'panel.index'));

    // Keanggotaan 
    
    route_resource('keanggotaan', 'PanelKeanggotaanController', 'panel');
    route_resource('keanggotaan.kas', 'PanelKeanggotaanKasController', 'panel');
    route_resource('keanggotaan.hp', 'PanelKeanggotaanHpController', 'panel');
    route_resource('keanggotaan.email', 'PanelKeanggotaanEmailController', 'panel');
    route_resource('keanggotaan/divisi', 'PanelKeanggotaanDivisiController', 'panel');

    // Event 
    
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

    // IF Games

    route_resource('ifgames', 'PanelIFGamesCabangController', 'panel');
    route_resource('ifgames.jabatan', 'PanelIFGamesJabatanController', 'panel');
    route_resource('ifgames.tim', 'PanelIFGamesTimController', 'panel');
    Route::get('ifgames/{ifgames}/tim/{tim}/pay', array('uses' => 'PanelIFGamesTimController@pay', 'as' => 'panel.ifgames.tim.pay'));
    route_resource('ifgames.tim.anggota', 'PanelIFGamesAnggotaTimController', 'panel');
    Route::get('ifgames/{ifgames}/tim/{tim}/anggota/{anggota}/ska', array('uses' => 'PanelIFGamesAnggotaTimController@ska', 'as' => 'panel.ifgames.tim.anggota.ska'));
    Route::get('ifgames/{ifgames}/tim/{tim}/anggota/{anggota}/ktm', array('uses' => 'PanelIFGamesAnggotaTimController@ktm', 'as' => 'panel.ifgames.tim.anggota.ktm'));

    // Pelatihan

    Route::get('pelatihan/anggota', array('uses' => 'PanelPelatihanAnggotaController@index', 'as' => 'panel.pelatihan.anggota.index'));
    Route::get('pelatihan/anggota/create', array('uses' => 'PanelPelatihanAnggotaController@create', 'as' => 'panel.pelatihan.anggota.create'));
    Route::get('pelatihan/anggota/{pelatihananggota}', array('uses' => 'PanelPelatihanAnggotaController@show', 'as' => 'panel.pelatihan.anggota.show'));
    Route::post('pelatihan/anggota', array('uses' => 'PanelPelatihanAnggotaController@store', 'as' => 'panel.pelatihan.anggota.store'));
    Route::get('pelatihan/anggota/{pelatihananggota}/edit', array('uses' => 'PanelPelatihanAnggotaController@edit', 'as' => 'panel.pelatihan.anggota.edit'));
    Route::put('pelatihan/anggota/{pelatihananggota}', array('uses' => 'PanelPelatihanAnggotaController@update', 'as' => 'panel.pelatihan.anggota.update'));
    Route::delete('pelatihan/anggota/{pelatihananggota}', array('uses' => 'PanelPelatihanAnggotaController@destroy', 'as' => 'panel.pelatihan.anggota.destroy'));

    // Cakrawala

    Route::group(array('prefix' => 'cakrawala'), function()
    {
        Route::get('/', array('uses' => 'PanelCakrawalaController@index', 'as' => 'panel.cakrawala.index'));

        Route::get('kompetisi', array('uses' => 'PanelCakrawalaKompetisiController@index', 'as' => 'panel.cakrawala.kompetisi.index'));
        route_resource('kompetisi.tim', 'PanelCakrawalaKompetisiTimController', 'panel.cakrawala');
        Route::get('kompetisi/{kompetisi}/tim/{tim}/pay', array('uses' => 'PanelCakrawalaKompetisiTimController@pay', 'as' => 'panel.cakrawala.kompetisi.tim.pay'));
        route_resource('kompetisi.tim.anggota', 'PanelCakrawalaKompetisiAnggotaController', 'panel.cakrawala');
    });

    // Arsip
    
    route_resource('arsip', 'PanelArsipController', 'panel');

    // User
    
    route_resource('user', 'PanelUserController', 'panel');

});

Route::group(array('domain' => 'pelatihan'.$domain), function()
{
    Route::get('/', array('uses' => 'PelatihanController@index', 'as' => 'pelatihan.index'));
    Route::post('/', array('uses' => 'PelatihanController@store', 'as' => 'pelatihan.store'));
});


Route::group(array('domain' => 'cakrawala'.$domain), function()
{
    Route::get('/', array('uses' => 'PelatihanController@index', 'as' => 'pelatihan.index'));
    Route::post('/', array('uses' => 'PelatihanController@store', 'as' => 'pelatihan.store'));
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