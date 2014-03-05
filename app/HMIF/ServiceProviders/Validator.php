<?php namespace HMIF\ServiceProviders;
 
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Validator as LaravelValidator;
 
class Validator extends ServiceProvider {
 
    public function register()
    {
        LaravelValidator::resolver(function($translator, $data, $rules, $messages)
        {
            return new \HMIF\Validator\NimValidator($translator, $data, $rules, $messages);
        });
    }
}