<?php

include('configs/database.php');

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'mysql',
            'host' => DB_HOST,
            'name' => 'production_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'mysql',
            'host' => DB_HOST,
            'name' => DB_NAME,
            'user' => DB_USER,
            'pass' => DB_PASS,
            'port' => DB_PORT,
            'charset' => 'utf8',
            'suffix' => ".db"
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => DB_HOST,
            'name' => 'testing_db',
            'user' => DB_USER,
            'pass' => DB_PASS,
            'port' => DB_PORT,
            'charset' => 'utf8',
            'memory' => true
        ]
    ],
    'version_order' => 'creation'
];
