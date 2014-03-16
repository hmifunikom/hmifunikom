<?php namespace HMIF\ServiceProviders;
 
use Illuminate\Support\ServiceProvider;
 
class Repositories extends ServiceProvider {
 
    public function register()
    {
        $this->register_arsip();
        $this->register_event();
        $this->register_ifgames();
        $this->register_keanggotaan();
        $this->register_user();
        $this->register_perpustakaan();
        $this->register_if_center();
    }

    private function register_arsip()
    {
        $namespace = 'HMIF\\Repositories\\Arsip\\';
        $list = array(
            'DokumenRepo'      =>  'EloquentDokumenRepo',
        );

        $this->_register($list, $namespace);
    }

    private function register_event()
    {
        $namespace = 'HMIF\\Repositories\\Acara\\';
        $list = array(
            'AcaraRepo'      =>  'EloquentAcaraRepo',
            'WaktuAcaraRepo' =>  'EloquentWaktuAcaraRepo',
            'DivAcaraRepo'   =>  'EloquentDivAcaraRepo',
            'PanitiaRepo'    =>  'EloquentPanitiaRepo',
            'PesertaRepo'    =>  'EloquentPesertaRepo',
        );

        $this->_register($list, $namespace);
    }

    private function register_ifgames()
    {
        $namespace = 'HMIF\\Repositories\\IFGames\\';
        $list = array(
            'CabangRepo'     =>  'EloquentCabangRepo',
            'TimRepo'        =>  'EloquentTimRepo',
            'AnggotaTimRepo' =>  'EloquentAnggotaTimRepo',
        );

        $this->_register($list, $namespace);
    }

    private function register_keanggotaan()
    {
        $namespace = 'HMIF\\Repositories\\Keanggotaan\\';
        $list = array(
            'AnggotaRepo'      =>  'EloquentAnggotaRepo',
        );

        $this->_register($list, $namespace);
    }

    private function register_user()
    {

    }

    private function register_perpustakaan()
    {

    }

    private function register_if_center()
    {

    }

    private function _register($list, $namespace)
    {
        foreach($list as $k => $v)
        {
            $this->app->bind($namespace.$k, $namespace.$v);
        }

        $this->app->booting(function() use ($namespace, $list)
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            
            foreach($list as $k => $v)
            {
                $loader->alias($k, $namespace.$k);
            }
                
        });
    }
}