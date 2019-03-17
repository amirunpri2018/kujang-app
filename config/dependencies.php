<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container[ 'renderer' ] = function ( $c ) {
    $settings = $c->get( 'settings' )[ 'renderer' ];
    return new System\Views\PhpRenderer( $settings[ 'template_path' ] );
};

$container[ 'view' ] = function ( $c ) {
    $view = new \System\Views\Twig( dirname( __DIR__ ) . '/templates', [
        'cache' => dirname( __DIR__ ) . '/templates_c'
    ] );
    
    // Instantiate and add System specific extension
    $router = $c->get( 'router' );
    $uri    = \System\Http\Uri::createFromEnvironment( new \System\Http\Environment( $_SERVER ) );
    $view->addExtension( new \System\Views\TwigExtension( $router, $uri ) );
    
    return $view;
};

// monolog
$container[ 'logger' ] = function ( $c ) {
    $settings = $c->get( 'settings' )[ 'logger' ];
    $logger   = new Monolog\Logger( $settings[ 'name' ] );
    $logger->pushProcessor( new Monolog\Processor\UidProcessor() );
    $logger->pushHandler( new Monolog\Handler\StreamHandler( $settings[ 'path' ], $settings[ 'level' ] ) );
    return $logger;
};

// flash
$container[ 'flash' ] = function () {
    return new System\Flash\Messages();
};
$container[ 'csrf' ]  = function ( $c ) {
    return new System\Csrf\Guard;
};
