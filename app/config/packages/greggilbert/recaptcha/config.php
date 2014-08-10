<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| API Keys
	|--------------------------------------------------------------------------
	|
	| Set the public and private API keys as provided by reCAPTCHA.
	|
	*/
	'public_key'	=> $_ENV['CAPTCHA_PUB'],
	'private_key'	=> $_ENV['CAPTCHA_PRI'],
	
	/*
	|--------------------------------------------------------------------------
	| Template
	|--------------------------------------------------------------------------
	|
	| Set a template to use if you don't want to use the standard one.
	|
	*/
	'options' => array(
		'lang' => 'en',
        'theme' => 'white',
    ),
	'template'		=> '',

	
);