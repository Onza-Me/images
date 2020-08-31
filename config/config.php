<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'limits' => [
        'canvas_sizes' => convert_canvas_limits_to_array(env('ONZA_ME_IMAGES_CANVAS_SIZE_LIMITS', 'default:5000*5000,1920*1920;photos:5000*5000,1920*1920')),
        'preview_canvas_sizes' => convert_preview_canvas_limits_to_array(env('ONZA_ME_IMAGES_PREVIEW_CANVAS_SIZE_LIMITS', 'default:default|480*290;photos:default|480*290,small|360*180')),
        'file_size' => env('ONZA_ME_IMAGES_MAX_FILE_SIZE', 10000), // kB
        'mimes' =>  env('ONZA_ME_IMAGES_MIMES', 'jpg,jpeg,png,gif'),
    ],
    'krakenio' => [
        'api_key' => env('ONZA_ME_KRAKENIO_API_KEY', null),
        'api_secret' => env('ONZA_ME_KRAKENIO_API_SECRET', null),
    ]
];
