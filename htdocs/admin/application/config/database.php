<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
    (
        'production' => array
        (
        'type'       => 'MySQLi',
        'connection' => array(
        /**
             * The following options are available for MySQL:
             *
             * string   hostname     server hostname, or socket
             * string   database     database name
             * string   username     database username
             * string   password     database password
             * boolean  persistent   use persistent connections?
             * array    variables    system variables as "key => value" pairs
             *
             * Ports and sockets may be appended to the hostname.
             */
        'hostname'   => 'localhost',
        'database'   => 'enigmata_webadmin',
        'username'   => 'enigmata_webadmin',
        'password'   => 'webadmin_123',
        'persistent' => FALSE,
    ),
        'table_prefix' => '',
        'charset'      => 'utf8',
        'caching'      => FALSE,
    ),

        'default' => array
        (
        'type'       => 'MySQLi',
        'connection' => array(
        /**
             * The following options are available for MySQL:
             *
             * string   hostname     server hostname, or socket
             * string   database     database name
             * string   username     database username
             * string   password     database password
             * boolean  persistent   use persistent connections?
             * array    variables    system variables as "key => value" pairs
             *
             * Ports and sockets may be appended to the hostname.
             */
        'hostname'   => 'localhost',
        'database'   => 'enigmaster',
        'username'   => 'root',
        'password'   => FALSE,
        'persistent' => FALSE,
    ),
        'table_prefix' => '',
        'charset'      => 'utf8',
        'caching'      => FALSE,
    )

    );
