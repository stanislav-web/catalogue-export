<?php
/**
 * BE CAREFUL!
 * This section contains the settings of global application
 * @version PRODUCTION
 */
ini_set('display_errors', 'Off');
error_reporting(0);
$config = [

    // Configure database driver
    'database'      => [
        'host'              => 'ru2.redumbrella.com.ua',
        'username'          => 'dev',
        'password'          => 'anZi28MZLp',
        'dbname'            => 'backend.local',
        'port'              => 3306,
        'charset'           => 'utf8',
        'persistent'        => false,
        'debug'             => PDO::ERRMODE_SILENT,
    ],
];