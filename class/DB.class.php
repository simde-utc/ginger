<?php
class DB extends PDO {
  private static $instance;
  public $pdo;
  
  function __construct() {
    parent::__construct("mysql:host=localhost;port=3306;dbname=ginger", "root", "root");
  }
  
  function getInstance(){
    if (!isset(self::$instance)){
        self::$instance = new DB();
    }
    return self::$instance;
  }
}
?>
