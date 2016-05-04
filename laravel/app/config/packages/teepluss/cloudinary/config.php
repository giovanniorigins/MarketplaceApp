<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Cloudinary API configuration
    |--------------------------------------------------------------------------
    |
    | Before using Cloudinary you need to register and get some detail
    | to fill in below, please visit cloudinary.com.
    |
    */

    'cloudName'  => 'agora',
    'baseUrl'    => 'http://res.cloudinary.com/agora',
    'secureUrl'  => 'https://res.cloudinary.com/agora',
    'apiBaseUrl' => 'https://api.cloudinary.com/v1_1/agora',
    'apiKey'     => '566343585235781',
    'apiSecret'  => 'Ugv3Ccc-WDHaluDEYwDT1_mEOaQ',

    /*
    |--------------------------------------------------------------------------
    | Default image scaling to show.
    |--------------------------------------------------------------------------
    |
    | If you not pass options parameter to Cloudy::show the default
    | will be replaced.
    |
    */

    'scaling'    => array(
        'format' => 'png',
        'width'  => 300,
        'height' => 300,
        'crop'   => 'fit',
        'effect' => null
    )

);
