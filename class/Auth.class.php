<?php

class Auth {
  private $db;
  private $droits;
  private $asso;
  private $id;
  private static $instance;
  
  public function __construct() {
    $this->db = DB::getInstance();
    $this->id = 0;
  }
  
  public function login($key) {
    if(strlen($key) != 50){
      throw new ErrorException("La clé est invalide.");
    }
    
    $key = $this->db->quote($key, PDO::PARAM_STR);
    $res = $this->db->query("SELECT ID, Association, Droits FROM auth WHERE Cle LIKE $key");
    
    if($res->rowCount() != 1){
      throw new ErrorException("La clé est incorrecte.");
    }
    
    $data = $res->fetch(PDO::FETCH_OBJ);
    $this->droits = $data->Droits;
    $this->asso = $data->Association;
    $this->id = $data->ID;
  }
  
  public function getInstance(){
    if (!isset(self::$instance)){
        self::$instance = new Auth();
    }
    return self::$instance;
  }
  
  public function getDroits(){
    return $this->droits;
  }
  
  public function getAssoName(){
    return $this->asso;
  }
  
  public function getId(){
    return $this->id;
  }
  
  public function isAuthenticated(){
    return ($this->id > 0);
  }
}

?>
