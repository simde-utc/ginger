<?php
require_once("class/DB.class.php");
require_once("class/Personne.class.php");
require_once("class/Auth.class.php");

$auth = Auth::getInstance();
if(isset($_GET['key'])){
  try {
    $auth->login($_GET['key']); 
  } catch (ErrorException $e) {
    echo json_encode(array("erreur" => $e->getMessage()));
  }
}

if(isset($_GET['login'])){
  try {
    $arthur = new Personne($_GET['login']);
    echo json_encode($arthur->getDetails());
  } catch (ErrorException $e) {
    echo json_encode(array("erreur" => $e->getMessage()));
  }
}

if(isset($_GET['find'])){
  try {
    $data = Personne::find($_GET['find']);
    echo json_encode($data);
  } catch (ErrorException $e) {
    echo json_encode(array("erreur" => $e->getMessage()));
  }
}

?>