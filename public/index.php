<?php

use PHPRouter\Config;
use PHPRouter\Router;

// Require definitions
require_once '../config/definitions.php';

// Require composite libraries
require_once DOCUMENT_ROOT . '../vendor/autoload.php';

// Require global configurations
require_once DOCUMENT_ROOT . '../config/application.php';

// Require global services
require_once DOCUMENT_ROOT . '../config/services.php';

try {
    $config = Config::loadFromFile(DOCUMENT_ROOT . '../config/routes.yaml');

    $router = Router::parseConfig($config);
    $router->matchCurrentRequest();

} catch (\Exception $e) {
    var_dump($e);
}