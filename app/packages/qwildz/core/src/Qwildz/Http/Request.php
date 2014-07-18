<?php namespace Qwildz\Http;

use Symfony\Component\HttpFoundation\FileBag;
use Illuminate\Http\Request as LaravelRequest;
use Symfony\Component\HttpFoundation\ParameterBag;

class Request extends LaravelRequest {

    protected static $cleaned = false;

    /**
     * Constructor.
     *
     * @param array  $query      The GET parameters
     * @param array  $request    The POST parameters
     * @param array  $attributes The request attributes (parameters parsed from the PATH_INFO, ...)
     * @param array  $cookies    The COOKIE parameters
     * @param array  $files      The FILES parameters
     * @param array  $server     The SERVER parameters
     * @param string $content    The raw body data
     *
     * @api
     */
    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        static::_sanitize();
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    /**
     * Creates a new request with values from PHP's super globals.
     *
     * @return Request A new request
     *
     * @api
     */
    public static function createFromGlobals()
    {
        static::_sanitize();
        return parent::createFromGlobals();
    }

    protected static function _sanitize()
    {
        if(static::$cleaned) return;

        // Sanitize GET
        $_GET = static::_clean($_GET);
        
        // Sanitize POST
        $_POST = static::_clean($_POST);
        

        // Sanitize FILES
        $_FILES = static::_clean($_FILES);

        static::$cleaned = true;
    }

    protected static function _clean($data)
    {
        if(is_array($data))
        {
            foreach($data as &$value)
            {
                $value = Security::xss_clean($value);
            }
        }
        else
        {
            $data = Security::xss_clean($data);
        }

        return $data;
    }
}