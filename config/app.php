<?php
return [
    'settings' => [
        'displayErrorDetails'    => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        
        // Renderer settings
        'renderer'               => [
            'template_path' => __DIR__ . '/../templates/',
        ],
        
        // Monolog settings
        'logger'                 => [
            'name'  => 'kujang-app',
            'path'  => isset( $_ENV[ 'docker' ] ) ? 'php://stdout' : __DIR__ . '/../logs/app-' . date( 'Y-m-d' ) . '.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        'db'                     => require 'database.php',
        'modules'                => require 'modules.php',
    ],
];