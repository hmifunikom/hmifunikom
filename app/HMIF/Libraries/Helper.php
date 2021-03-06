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

    public static function code($number, $prefix = '', $digit = 3)
    {
        return $prefix . str_pad($number, $digit, 0, STR_PAD_LEFT);
    }

    public static function rp($nominal)
    {
        return 'Rp. '.number_format($nominal,2,',','.');
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
        if(Helper::is_active($route))
        {
            return ($class) ? 'class="active"' : 'active';
        }
    }

    public static function active_qs($field, $value, $class = true)
    {   
        if(\Input::has($field) && \Input::get($field) == $value)
        {
            return ($class) ? 'class="active"' : 'active';
        }
    }    

    public static function is_active($route)
    {   
        if(strpos(\Request::url(), route($route)) !== false)
            return true;
        else
            return false;
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

    /*
    |--------------------------------------------------------------------------
    | Media Helper
    |--------------------------------------------------------------------------
    */
   
    public static function pathFile($filename, $safe = TRUE)
    {
        if($safe)
        {
            return storage_path().'/files/'.$filename;
        }
        else
        {
            return public_path().'/media/datas/'.$filename;
        }
    }

    public static function createQR($text)
    {
        $qrCode = new \Endroid\QrCode\QrCode();
        $qrCode->setText($text);
        $qrCode->setSize(300);
        $qrCode->setPadding(10);
        $qrCode->render('media/qr/'.$text.'.jpg');
    }

    public static function deleteMedia($file)
    {
        \File::delete(public_path().'/media/images/'.$file);
        \File::delete(public_path().'/media/thumbs/'.$file);
    }

    public static function deleteFile($file, $safe = TRUE)
    {
        \File::delete(static::pathFile($file, $safe));
    }

    public static function formatBytes($bytes, $precision = 2) { 
        $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

        $bytes = max($bytes, 0); 
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1); 

        // Uncomment one of the following alternatives
        // $bytes /= pow(1024, $pow);
        $bytes /= (1 << (10 * $pow)); 

        return round($bytes, $precision) . ' ' . $units[$pow]; 
    } 

    public static function version($path)
    {
        $file = public_path($path);

        if(file_exists($file))
        {
            $parts = explode('.', $path);
            $extension = array_pop($parts);
            array_push($parts, filemtime($file), $extension);
            $path = implode('.', $parts);
            return $path;
        }
    }
}