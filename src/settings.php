<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        
        //banco de dados
        'db' => [
            'host' => 'localhost',
            'dbname' => '2eat',
            'user' => 'root',
            'pass' => 'ap310608039090lg'
        ],
        
        // inserindo chave de sessão TESTE
        'apiKey' => [
            'uid_value' => '1'   
        ]
        
    ],
];
