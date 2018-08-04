<?php

namespace database;
use Illuminate\Database\Capsule\Manager as Capsule;


class Database {

    function __construct() {
        $capsule = new Capsule;
        $database = parse_ini_file(__DIR__.'/../config/database.ini', true);
        $capsule->addConnection([
            'driver' => $database['mysql']['driver'],
            'host' => $database['mysql']['host'],
            'database' => $database['mysql']['database'],
            'username' => $database['mysql']['username'],
            'password' => $database['mysql']['password'],
            'charset' => $database['mysql']['charset'],
            'collation' => $database['mysql']['collation'],
            'prefix' => '',
        ]);
        // Make this Capsule instance available globally via static methods... (optional)
        $capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $capsule->bootEloquent();
    }

}