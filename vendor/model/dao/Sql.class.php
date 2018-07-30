<?php

namespace vendor\model\dao;

use \PDO;

class Sql extends PDO{

    //Variaveis de conexão.
    private $conn   = null;
    private $host   = "localhost";    // Servidor
    private $dbname = "facilite_bd";// Banco de Dados 
    private $user   = "root";         // Usuario
    private $pass   = "";             // Senha
    private $driver = "mysql";      //driver banco de dados
    
    public function __construct(){
        $this->conn = new PDO($this->driver.":host=".$this->host.";dbname=".$this->dbname,$this->user,$this->pass,
        array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        ));
    }

    private function setParams($statement, $parameters = array()){
        foreach ($parameters as $key => $value) {
            $this->setParam($statement, $key, $value);
        }
    }

    private function setParam($statement, $key, $value){
        $statement->bindParam($key, $value);
    } 

    public function query($rawQuery, $params = array()){
        $stmt = $this->conn->prepare($rawQuery);
        $this->setParams($stmt, $params);
        $stmt->execute();
        return $stmt;
    }

    public function select($rawQuery, $params = array()){
        $stmt = $this->query($rawQuery, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function __destruct() {
      $this->conn = null;
    }
}