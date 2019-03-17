<?php
// Instantiate the app
$settings = require 'app.php';
$app      = new System\App( $settings );
// Set up dependencies
require 'dependencies.php';
// Register middleware
require 'middleware.php';
// Register routes
require 'routes.php';

foreach ($settings['settings']['modules'] as $module => $class) {
	$moduleClass 	= $class['class'];
	$moduleClass 	= new $moduleClass();
	$routers 		= require __DIR__.'/../modules/'.ucfirst($module).'/'.$moduleClass->route;
	foreach($routers as $router => $controller)
	{
		$app->get($router,'\\'.$moduleClass->nameSpace.'\\'.$controller);
	}
}