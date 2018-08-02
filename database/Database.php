<?php
//
//namespace database;
//
//use \PDO;
//
//class Database extends PDO{
//
//    public function __construct(){
//        $configs = require (__DIR__.DS."../config/database.php");
//        $configs = $configs['connections'][$configs['DB_CONNECTION']];
//
//        $conn   = null;
//        $host   = $configs['host'];         // Servidor
//        $dbname = $configs['database'];     // Banco de Dados
//        $user   = $configs['username'];     // Usuario
//        $pass   = $configs['password'];     // Senha
//        $driver = $configs['driver'];       // Driver banco de dados
//
//        $this->conn = new PDO($driver.":host=".$host.";dbname=".$dbname, $user, $pass,
//        array(
//            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
//        ));
//    }
//
//    private function setParams($statement, $parameters = array()){
//        foreach ($parameters as $key => $value) {
//            $this->setParam($statement, $key, $value);
//        }
//    }
//
//    private function setParam($statement, $key, $value){
//        $statement->bindParam($key, $value);
//    }
//
//    public function query($rawQuery, $params = array()){
//        $stmt = $this->conn->prepare($rawQuery);
//        $this->setParams($stmt, $params);
//        $stmt->execute();
//        return $stmt;
//    }
//
//    public function select($rawQuery, $params = array()){
//        $stmt = $this->query($rawQuery, $params);
//        return $stmt->fetchAll(PDO::FETCH_ASSOC);
//    }
//
//    function __destruct() {
//      $this->conn = null;
//    }
//}

namespace database;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Container\Container;

class Database {

    function __construct() {
        $capsule = new Capsule;
        $configs = require (__DIR__.DS."../config/database.php");
        $configs = $configs['connections'][$configs['DB_CONNECTION']];
        $capsule->addConnection([
            'driver' => $configs['driver'],
            'host' => $configs['host'],
            'database' => $configs['database'],
            'username' => $configs['username'],
            'password' => $configs['password'],
            'charset' => $configs['charset'],
            'collation' => $configs['collation'],
            'prefix' => '',
        ]);
        // Make this Capsule instance available globally via static methods... (optional)
        $capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $capsule->bootEloquent();
    }

}