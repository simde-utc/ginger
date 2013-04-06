<?php

require_once '../lib/Koala/Koala.class.php';
use \Koala\ApiException;

require_once 'AccountsApi.class.php';

class GingerMaintenance {
    protected $accounts;
    
    public function __construct($accounts_url) {
        // Initialisation de Accounts
        $this->accounts = new AccountsApi(Config::$ACCOUNTS_URL);
    }
    
    public function cleanupLoginsWithoutActiveCards() {
        $log = "Nettoyage des badges\n";

        // Récupérer la liste des badges à désactiver
        $logins = $this->accounts->getLoginsWithoutActiveCard();
    
        // On fait une transaction pour améliorer les performances
        $con = Propel::getConnection(PersonnePeer::DATABASE_NAME);
        $con->beginTransaction();
    
        foreach($logins as $login){
            if(!empty($login)) {
                $personne = PersonneQuery::create('p')
                    ->where("p.login = ?", $login)
                    ->findOne();
                
                if(!empty($personne)){
                    $personne->setBadgeUid(null);
                    $personne->save();                    
                    $log .= "$login:ok null\n";
                } else {
                    $log .= "$login:absent\n";
                }
            }
        }
    
        // Fin de la transaction
        $con->commit();
        
        return $log;
    }
    
    public function updateModifiedCards($date = null) {
        if($date == null) {
            $date = date("Y-m-d");
        }
        
        $log = "Mise à jour des badges modifiés après le $date\n";
        
        // Récupérer la liste des badges à désactiver
        $cards = $this->accounts->getModifiedCards($date);
        
        foreach($cards as $accountsData){
            if(!empty($accountsData)) {
                
                // Il existe, on recherche son login dans ginger (ou on lui fait une nouvelle ligne)
                $personne = PersonneQuery::create('p')
                    ->where("p.login = ?", $accountsData->username)
                    ->findOne();
			
                if(!empty($personne)) {
                    // On met à jour toutes les données (notamment le badge) avec ce qu'on a déjà récupéré
                    $personne->updateFromAccounts($accountsData);
                    
                    $log .= $accountsData->username.":updated\n";
                } else {
                    $log .= $accountsData->username.":absent\n";
                }
            }
        }
        
        return $log;
    }

}
