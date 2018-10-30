<?php

return [
    'settings' => [
        'displayErrorDetails'    => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // App Settings
        'app'                    => [
            'name' => 'IoT gathering',
            'url'  => 'http://192.168.10.5:9093',
            'env'  => 'local',
        ],

        // Renderer settings
        'renderer'               => [
            'template_path' => __DIR__ . '/templates/',
        ],

        // Database settings
        'database'               => [
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'database'  => 'iot',
            'username'  => 'root',
            'password'  => '',
            'port'      => '3306',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],
    ],
];