<?php namespace HMIF\Libraries;

class Helper {

    /*
    |--------------------------------------------------------------------------
    | Typhograph Helper
    |--------------------------------------------------------------------------
    */
   
    public static function nl2p($string, $line_breaks = true, $xml = true)
    {
        // Remove existing HTML formatting to avoid double-wrapping things
        $string = str_replace(array('<p>', '</p>', '<br>', '<br />'), '', $string);
        
        // It is conceivable that people might still want single line-breaks
        // without breaking into a new paragraph.
        if ($line_breaks == true)
            return '<p>'.preg_replace(array("/([\n]{2,})/i", "/([^>])\n([^<])/i"), array("</p>\n<p>", '<br'.($xml == true ? ' /' : '').'>'), trim($string)).'</p>';
        else 
            return '<p>'.preg_replace("/([\n]{1,})/i", "</p>\n<p>", trim($string)).'</p>';
    }

    public static function fa($icon)
    {
        return "<i class='fa fa-{$icon}'></i>";
    }

    public static function parsedown($text, $striptags = false)
    {
        $parsedown = new \Parsedown();
        return ($striptags) ? strip_tags($parsedown->parse($text)) : $parsedown->parse($text);
    }

    /*
    |--------------------------------------------------------------------------
    | Date Helper
    |--------------------------------------------------------------------------
    */

    public static function parseDate($date)
    {
        return date('j', strtotime($date));
    }

    public static function parseMonth($date)
    {
        return date('M', strtotime($date));
    }

    public static function parseYear($date)
    {
        return date('Y', strtotime($date));
    }

    /*
    |--------------------------------------------------------------------------
    | Array Helper
    |--------------------------------------------------------------------------
    */
   
    public static function implode($array, $key)
    {
        $array = $array->toArray();
        $array = array_fetch($array, $key);
        return implode($array, ', ');
    }

    /*
    |--------------------------------------------------------------------------
    | Menu Helper
    |--------------------------------------------------------------------------
    */
   
    // http://www.laravel-tricks.com/tricks/active-states-based-on-route-names
    public static function active($route, $class = true)
    {   
        if(strpos(\Request::url(), route($route)) !== false)
        {
            return ($class) ? 'class="active"' : 'active';
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Former Helper
    |--------------------------------------------------------------------------
    */

    public static function FormerConfig($key, $value)
    {{
        \Config::set('former::'.$key, $value);
    }}

    public static function createQR($text)
    {
        $qrCode = new \Endroid\QrCode\QrCode();
        $qrCode->setText($text);
        $qrCode->setSize(300);
        $qrCode->setPadding(10);
        $qrCode->render('media/qr/'.$text.'.jpg');
    }
}