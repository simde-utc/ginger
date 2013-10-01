<?php

class AccountsApi {
	private $useragent = "ginger/0.1";
    private $accounts_url;
	
    public function __construct($url){
        $this->accounts_url = $url;
    }

	private function apiCall($endpoint, $params = array()){
		// Construction de l'url avec l'endpoint et les paramètres
		$url = $this->accounts_url.$endpoint;
		if(!empty($params)){
			$url .= "?";
			foreach($params as $key => $param){
				$url .= $key."=".$param."&";
			}
			// On supprimer le dernier &
			$url = substr($url, 0, -1);
		}
		
		// Initialisation de cURL
		$ch = curl_init($url);
		curl_setopt_array($ch, array(
				CURLOPT_USERAGENT => $this->useragent,
				CURLOPT_RETURNTRANSFER => true
		));
		
		// Éxécution de la requête
		$result = curl_exec($ch);
		
		// Si erreur d'appel de cron fatal
		if(curl_errno($ch) != 0){
			return false;
		}
		// Si erreur non trouvé, c'est pas fatal (on renverra 404 plus tard)
		else if(curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200){
			return false;
		}
		// Sinon, on renvoie les infos
		else {
			return json_decode($result);
		}
	}
	
	public function getUserInfo($username){
		$params = array(
				"username" => $username
		);
		$result = $this->apiCall("getUserInfo", $params);
		
		if(!empty($result->cardSerialNumber)){
			$result->cardSerialNumber = strtoupper($this->swapUid($result->cardSerialNumber));
		}
			
		return $result;
	}
	
	public function cardLookup($uid){
		$params = array(
				"serialNumber" => strtolower($this->swapUid($uid))
		);
		
		$result = $this->apiCall("cardLookup", $params);
		
		if(!empty($result->cardSerialNumber)){
			$result->cardSerialNumber = strtoupper($this->swapUid($result->cardSerialNumber));
		}
		
		return $result;
	}
	
	private function swapUid($in){
		return $in[6].$in[7].$in[4].$in[5].$in[2].$in[3].$in[0].$in[1];
	}
}

?>
