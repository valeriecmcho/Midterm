<?php

namespace Config;

use CodeIgniter\Database\Config;

/**
 * Database Configuration
 */
class Database extends Config
{
    /**
     * The directory that holds the Migrations and Seeds directories.
     */
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    /**
     * Lets you choose which connection group to use if no other is specified.
     */
    public string $defaultGroup = 'default';

    /**
     * The default database connection.
     *
     * @var array<string, mixed>
     */
    public array $default = [
        'DSN'          => '',
        'hostname'     => 'localhost',
        'username'     => 'root',
        'password'     => '',
        'database'     => 'fourbeansdb',
        'DBDriver'     => 'MySQLi',
        'DBPrefix'     => '',
        'pConnect'     => false,
        'DBDebug'      => true,
        'charset'      => 'utf8mb4',
        'DBCollat'     => 'utf8mb4_general_ci',
        'swapPre'      => '',
        'encrypt'      => false,
        'compress'     => false,
        'strictOn'     => false,
        'failover'     => [],
        'port'         => 3306,
        'numberNative' => false,
        'foundRows'    => false,
        'dateFormat'   => [
            'date'     => 'Y-m-d',
            'datetime' => 'Y-m-d H:i:s',
            'time'     => 'H:i:s',
        ],
    ];

    /**
     * This database connection is used when running PHPUnit database tests.
     *
     * @var array<string, mixed>
     */
    public array $tests = [
        'DSN'         => '',
        'hostname'    => '127.0.0.1',
        'username'    => '',
        'password'    => '',
        'database'    => ':memory:',
        'DBDriver'    => 'SQLite3',
        'DBPrefix'    => 'db_',
        'pConnect'    => false,
        'DBDebug'     => true,
        'charset'     => 'utf8',
        'DBCollat'    => '',
        'swapPre'     => '',
        'encrypt'     => false,
        'compress'    => false,
        'strictOn'    => false,
        'failover'    => [],
        'port'        => 3306,
        'foreignKeys' => true,
        'busyTimeout' => 1000,
        'dateFormat'  => [
            'date'     => 'Y-m-d',
            'datetime' => 'Y-m-d H:i:s',
            'time'     => 'H:i:s',
        ],
    ];

    public function __construct()
    {
        parent::__construct();

        // 1. Support Railway URL format (MYSQL_URL or DATABASE_URL)
        $dbUrl = getenv('MYSQL_URL')
            ?: ($_SERVER['MYSQL_URL']
            ?? ($_ENV['MYSQL_URL']
            ?? (getenv('DATABASE_URL')
            ?: ($_SERVER['DATABASE_URL']
            ?? ($_ENV['DATABASE_URL'] ?? null)))));

        if ($dbUrl) {
            $parts = parse_url($dbUrl);
            if ($parts) {
                if (!empty($parts['host'])) {
                    $this->default['hostname'] = $parts['host'];
                }
                if (!empty($parts['port'])) {
                    $this->default['port'] = (int) $parts['port'];
                }
                if (!empty($parts['user'])) {
                    $this->default['username'] = $parts['user'];
                }
                if (isset($parts['pass'])) {
                    $this->default['password'] = $parts['pass'];
                }
                if (!empty($parts['path'])) {
                    $this->default['database'] = ltrim($parts['path'], '/');
                }
            }
        }

        // 2. Support individual Railway environment variables
        $host = getenv('MYSQLHOST') ?: ($_SERVER['MYSQLHOST'] ?? ($_ENV['MYSQLHOST'] ?? null));
        if ($host) {
            $this->default['hostname'] = $host;
            $this->default['username'] = getenv('MYSQLUSER') ?: ($_SERVER['MYSQLUSER'] ?? ($_ENV['MYSQLUSER'] ?? $this->default['username']));
            $this->default['password'] = getenv('MYSQLPASSWORD') ?: ($_SERVER['MYSQLPASSWORD'] ?? ($_ENV['MYSQLPASSWORD'] ?? $this->default['password']));
            $this->default['database'] = getenv('MYSQLDATABASE') ?: ($_SERVER['MYSQLDATABASE'] ?? ($_ENV['MYSQLDATABASE'] ?? $this->default['database']));
            $this->default['port']     = (int) (getenv('MYSQLPORT') ?: ($_SERVER['MYSQLPORT'] ?? ($_ENV['MYSQLPORT'] ?? 3306)));
        }

        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }
    }
}
