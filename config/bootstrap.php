<?php
// Instantiate the app
$settings = require 'app.php';
$app = new System\App($settings);
// Set up dependencies
require 'dependencies.php';
// Register middleware
require 'middleware.php';
// Register routes
require 'routes.php';