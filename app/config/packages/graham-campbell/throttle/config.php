<?php

/**
 * This file is part of Laravel Throttle by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

return array(

    /*
    |--------------------------------------------------------------------------
    | Throttler Class
    |--------------------------------------------------------------------------
    |
    | This defines the throttler class to be used.
    |
    | Default: 'GrahamCampbell\Throttle\Throttlers\CacheThrottler'
    |
    */

    'throttler' => 'GrahamCampbell\Throttle\Throttlers\CacheThrottler',

    /*
    |--------------------------------------------------------------------------
    | Cache Driver
    |--------------------------------------------------------------------------
    |
    | This defines the cache driver to be used. It may be the name of any
    | driver set in app/config/cache.php. Setting it to null will use the
    | driver you have set as default in app/config/cache.php. Please note that
    | a driver that supports cache tags is required.
    |
    | Default: null
    |
    */

    'driver' => null

);
