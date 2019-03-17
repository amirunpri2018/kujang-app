<?php
$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->register();

session_start();
require __DIR__ . '/../config/bootstrap.php';

// Run app
$app->run();
