<?php namespace HMIF\ServiceProviders;
 
use Illuminate\Support\ServiceProvider;
 
class Libraries extends ServiceProvider {
 
    public function register()
    {
        $namespace = 'HMIF\\Libraries\\';
        $list = array(
            'Helper',
            'ImageManipulation'
        );

        $this->app->booting(function() use ($namespace, $list)
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            
            foreach($list as $v)
            {
                $loader->alias($v, $namespace.$v);
            }
                
        });
    }
}