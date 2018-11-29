<?php

namespace database;
use Illuminate\Database\Capsule\Manager as Capsule;

class Database {

    function __construct() {
        $capsule = new Capsule;
        require BASEPATH.'config'.DS.'database.php';
        $capsule->addConnection([
            'driver'    => $mysql['driver'],
            'host'      => $mysql['host'],
            'database'  => $mysql['database'],
            'username'  => $mysql['username'],
            'password'  => $mysql['password'],
            'charset'   => $mysql['charset'],
            'collation' => $mysql['collation'],
            'prefix'    => '',
        ]);
        // Make this Capsule instance available globally via static methods... (optional)
        $capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $capsule->bootEloquent();
    }

}