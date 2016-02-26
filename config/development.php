<?php
/**
 * BE CAREFUL!
 * This section contains the settings of global application
 * @version DEVELOPMENT
 */
ini_set('display_errors', 'On');
error_reporting(E_ALL & ~E_WARNING);

return [

    // Configure database driver
    'database'      => [
        'host'              => 'localhost',
        'username'          => 'root',
        'password'          => 'root',
        'dbname'            => 'backend.local',
        'port'              => 3306,
        'charset'           => 'utf8',
        'persistent'        => false,
        'debug'             => PDO::ERRMODE_EXCEPTION,
    ],
];