<?php

require_once '../vendor/autoload.php';

// Include model
Propel::init("../build/conf/ginger-conf.php");
set_include_path("../build/classes" . PATH_SEPARATOR . get_include_path());

require_once '../config.php';
require_once '../class/ginger.class.php';
require_once '../class/Koala.class.php';
require_once 'ginger-client/KoalaClient.class.php';

class TruncateOperation extends \PHPUnit_Extensions_Database_Operation_Truncate
{
	public function execute(\PHPUnit_Extensions_Database_DB_IDatabaseConnection $connection, \PHPUnit_Extensions_Database_DataSet_IDataSet $dataSet)
	{
		$connection->getConnection()->query("SET foreign_key_checks = 0");
		parent::execute($connection, $dataSet);
		$connection->getConnection()->query("SET foreign_key_checks = 1");
	}
}

class BasicClient extends KoalaClient {
	public function apiCall($endpoint, $params, $method) {
		return parent::apiCall($GLOBALS['GINGER_URL'].$endpoint, $params, $method);
	}
}

class GingerTest extends PHPUnit_Extensions_Database_TestCase
{
	protected $TRECOUVR_EXPECTED_DETAILS = array(
				"login" => 'trecouvr',
				"nom" => 'Recouvreux',
				"prenom" => 'Thomas',
				"mail" => 'thomas.recouvreux@etu.utc.fr',
				"type" => 'etu',
				"is_adulte" => true,
				"is_cotisant" => false,
				"badge_uid" => 'ABCDEF1234',
				"expiration_badge" => NULL // todo, les fixtures phpunits marchent pas
		);
	protected $client=NULL;
	
	public function getSetUpOperation()
	{
		$cascadeTruncates = false; // True if you want cascading truncates, false otherwise. If unsure choose false.

		return new \PHPUnit_Extensions_Database_Operation_Composite(array(
			new TruncateOperation($cascadeTruncates),
			\PHPUnit_Extensions_Database_Operation_Factory::INSERT()
		));
	}
	
	public function getConnection()
	{
		$pdo = new PDO('mysql:dbname='.Config::$SQL_DB.';host='.Config::$SQL_HOST, Config::$SQL_USER, Config::$SQL_PASSWORD);
		return $this->createDefaultDBConnection($pdo);
	}

	public function getDataSet()
	{
		return new PHPUnit_Extensions_Database_DataSet_YamlDataSet(dirname(__FILE__).'/ginger-seed.yml');
	}

	public function setUp() {
		if (!$this->client)
			$this->client = new BasicClient();
	}

	protected function _testCurl($endPoint, $params, $method, $expected) {
		$expected = json_decode(json_encode($expected));
		$r = $this->client->apiCall($endPoint, $params, $method);
		$this->assertEquals($expected, $r);
	}

	/**
	 * @expectedException		 ApiException
	 * @expectedExceptionCode	 403
	 */
	public function testApiKeyInvalid() {
		$this->client->apiCall('/v1/trecouvr', array('key'=>'existepas'), 'GET');
	}

	/**
	 * @expectedException		 ApiException
	 * @expectedExceptionCode	 401
	 */
	public function testApiKeyNull() {
		$this->client->apiCall('/v1/trecouvr', array(), 'GET');
	}

	/**
	 * @expectedException		 ApiException
	 * @expectedExceptionCode	 401
	 */
	public function testApiKeyEmptyString() {
		$this->client->apiCall('/v1/trecouvr', array('key'=>''), 'GET');
	}

	/**
	 * @requires function curl_init
	 */
	public function testGetPersonneDetails()
	{
		$this->_testCurl('/v1/trecouvr', array('key'=>'abc'), 'GET', $this->TRECOUVR_EXPECTED_DETAILS);
	}

	/**
	 * @requires function curl_init
	 */
	public function testlFindPersonne()
	{
		$this->_testCurl('/v1/find/trec', array('key'=>'abc'), 'GET', array(
			array(
				'login'=>$this->TRECOUVR_EXPECTED_DETAILS['login'],
				'nom'=>$this->TRECOUVR_EXPECTED_DETAILS['nom'],
				'prenom'=>$this->TRECOUVR_EXPECTED_DETAILS['prenom'],
			)
		));
	}
}

?>

