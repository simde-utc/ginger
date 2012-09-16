<?php
require_once("class/Auth.class.php");
require_once("class/DB.class.php");

class Personne {
  public $login;
  public $nom;
  public $prenom;
  public $mail;
  public $type;
  public $dateAjout;
  public $dateMaj;
  public $dateExpiration;
  public $dateNaissance;
  public $badge;
  public $tel;
  public $tel2;
  public $adresse;
  public $adresse2;
  public $branche;
  public $semestre;
  public $cotisant = false;
  
  protected $db;
  protected $auth;
  protected $existant = false;
  
  /* Créer un nouvel objet ou bien récupérer un login */
  function __construct($login = ''){
    $this->db = DB::getInstance();
    $this->auth = Auth::getInstance();
    
    if(!$this->auth->isAuthenticated()){
      throw new ErrorException("Vous n'êtes pas authentifié.");
    }


    if(!empty($login)){
      $login = $this->db->quote($login, PDO::PARAM_STR);
      $res = $this->db->query("SELECT * FROM personne WHERE Login LIKE $login");
      
      if($res->rowCount() == 1){
        $this->existant = true;
        
        $data = $res->fetch(PDO::FETCH_OBJ);
        $this->login = $data->Login;
        $this->nom = $data->Nom;
        $this->prenom = $data->Prenom;
        $this->mail = $data->Mail;
        $this->type = $data->Type;
        $this->dateAjout = $data->DateAjout;
        $this->dateMaj = $data->DateMaj;
        $this->dateExpiration = $data->DateExpiration;
        $this->dateNaissance = $data->DateNaissance;
        $this->badge = $data->Badge;
        $this->tel = $data->Tel;
        $this->tel2 = $data->Tel2;
        $this->adresse = $data->Adresse;
        $this->adresse2 = $data->Adresse2;
        $this->branche = $data->Branche;
        $this->semestre = $data->Semestre;
      }
      else {
        throw new ErrorException("Login inconnu.");
      }
    }
  }
  
  /* Récupérer un array de login à partir de texte libre */
  static function find($freetext){
    $db = DB::getInstance();
    $freetext = $db->quote("%$freetext%");
    $res = $db->query("SELECT Login FROM personne WHERE Login LIKE $freetext OR Nom LIKE $freetext OR Prenom LIKE $freetext");
    $return = array();
    while($data = $res->fetch(PDO::FETCH_OBJ)){
      $return[] = $data->Login;
    }
    return $return;
  }
  
  /* Sauver l'objet actif */
  function save(){
    if($this->existant)
      $db->pdo->query("UPDATE");
    else
      $db->pdo->query("INSERT");
  }
  
  function getDetailsSimple(){
      return array(
        "login" => $this->login,
        "nom" => $this->nom,
        "prenom" => $this->prenom,
        "mail" => $this->mail,
        "type" => $this->type,
        "cotisant" => $this->cotisant
      );
  }
   
  function getDetailsEtendu(){
      return array(
        "login" => $this->login,
        "nom" => $this->nom,
        "prenom" => $this->prenom,
        "mail" => $this->mail,
        "type" => $this->type,
        "dateAjout" => $this->dateAjout,
        "dateMaj" => $this->dateMaj,
        "dateExpiration" => $this->dateExpiration,
        "dateNaissance" => $this->dateNaissance,
        "badge" => $this->badge,
        "tel" => $this->tel,
        "tel2" => $this->tel2,
        "adresse" => $this->adresse,
        "adresse2" => $this->adresse2,
        "branche" => $this->branche,
        "semestre" => $this->semestre
      );
  }
  
  function delete(){
    
  }
}
?>
