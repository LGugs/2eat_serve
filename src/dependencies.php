<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// controlador do banco de dados
$container['db'] = function($c){
    $settings = $c->get('settings')['db'];
    $pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'],
        $settings['user'], $settings['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

/*
// tentando criar uma função que me retorne a uma chave de autenticação!
// ta lindo!!
$container['apiKey'] = function($c){
    $settings = $c->get('settings')['apiKey'];
    session_start();
    $_SESSION['uid']=$settings['uid_value']; //o valor de $settings['uid_value'] é sempre 1
    $session_uid=$_SESSION['uid'];
    define("SITE_KEY", "2eat");
    $key = md5(SITE_KEY.$session_uid);
    return hash('sha256', $key.$_SERVER['REMOTE_ADDR']);
};
*/
