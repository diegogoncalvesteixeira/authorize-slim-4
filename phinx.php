<?php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$env = $_ENV['APP_ENV'];
$connection = $_ENV['DB_DRIVER'];
$host = $_ENV['DB_HOST'];
$port = $_ENV['DB_PORT'];
$dbname = $_ENV['DB_NAME'];
$user = $_ENV['DB_USERNAME'];
$pass = $_ENV['DB_PASSWORD'];

return [
    'paths' => [
        'bootstrap' => 'bootstrap/console.php',
        'migrations' => '%%PHINX_CONFIG_DIR%%/database/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/database/seeders',
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default_database' => 'dev',
        'dev' => [
            'adapter' => $connection,
            'host' => $host,
            'name' => $dbname,
            'user' => $user,
            'pass' => $pass,
            'port' => $port,
            'charset' => 'utf8'
        ],
        'test' => [
          'adapter' => $connection,
          'host' => $host,
          'name' => $dbname,
          'user' => $user,
          'pass' => $pass,
          'port' => $port,
          'charset' => 'utf8'
        ],
        'prod' => [
          'adapter' => $connection,
          'host' => $host,
          'name' => $dbname,
          'user' => $user,
          'pass' => $pass,
          'port' => $port,
          'charset' => 'utf8'
        ]
    ],
    'version_order' => 'creation'
];