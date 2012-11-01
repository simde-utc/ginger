<?php

require_once '../vendor/autoload.php';

// Include model
Propel::init("../build/conf/ginger-conf.php");
set_include_path("../build/classes" . PATH_SEPARATOR . get_include_path());

require_once '../config.php';
require_once '../class/ginger.class.php';
require_once '../class/Koala.class.php';
use \Koala\ApiException;

class TruncateOperation extends \PHPUnit_Extensions_Database_Operation_Truncate
{
	public function execute(\PHPUnit_Extensions_Database_DB_IDatabaseConnection $connection, \PHPUnit_Extensions_Database_DataSet_IDataSet $dataSet) {
		$connection->getConnection()->query("SET foreign_key_checks = 0");
		parent::execute($connection, $dataSet);
		$connection->getConnection()->query("SET foreign_key_checks = 1");
	}
}

class GingerTest extends PHPUnit_Extensions_Database_TestCase
{
	protected $pdo;

	protected $TRECOUVR_EXPECTED_DETAILS = array(
			"login" => 'trecouvr',
			"nom" => 'Recouvreux',
			"prenom" => 'Thomas',
			"mail" => 'thomas.recouvreux@etu.utc.fr',
			"type" => 'etu',
			"is_adulte" => true,
			"is_cotisant" => false,
			"badge_uid" => 'ABCDEF1234',
			"expiration_badge" => '2013-07-01',
	);
	protected $client=NULL;

    public function __construct() {
		$this->pdo = new PDO('mysql:dbname='.$GLOBALS['SQL_DB'].';host='.$GLOBALS['SQL_HOST'],
			$GLOBALS['SQL_USER'],
			$GLOBALS['SQL_PASSWORD']
		);
    }
    
	/**
	 * setupd db
	 * called in setUp()
	 */
	public function getSetUpOperation() {
		$cascadeTruncates = false; // True if you want cascading truncates, false otherwise. If unsure choose false.
		return new \PHPUnit_Extensions_Database_Operation_Composite(array(
			new TruncateOperation($cascadeTruncates),
			\PHPUnit_Extensions_Database_Operation_Factory::INSERT()
		));
	}

	/**
	 * clear db
	 * called in tearDown()
	 */
	protected function getTearDownOperation() {
        return $this->getOperations()->DELETE_ALL();
    }

	/**
	 * get db connection
	 */
	public function getConnection() {
		return $this->createDefaultDBConnection($this->pdo);
	}

	/**
	 * get db dataset
	 */
	public function getDataSet() {
		return new PHPUnit_Extensions_Database_DataSet_YamlDataSet(dirname(__FILE__).'/ginger-seed.yml');
	}

	/**
	 * setup before each tests
	 */
	public function setUp() {
		parent::setUp();
	}
	
	/**
	 * tearDown after each tests
	 */
	public function tearDown() {
		parent::tearDown();
	}
	
	public function testApiKeyValid() {
		new Ginger('', 'abc');
	}

	/**
	 * @expectedException		 \Koala\ApiException
	 * @expectedExceptionCode	 403
	 */
	public function testApiKeyInvalid() {
		new Ginger('', 'existepas');
	}

	/**
	 * @expectedException		 \Koala\ApiException
	 * @expectedExceptionCode	 401
	 */
	public function testApiKeyNull() {
		new Ginger('', NULL);
	}

	/**
	 * @expectedException		 \Koala\ApiException
	 * @expectedExceptionCode	 401
	 */
	public function testApiKeyEmptyString() {
		new Ginger('', '');
	}

	/**
	 * @depends testApiKeyValid
	 */
	public function testGetPersonneDetails() {
		$ginger = new Ginger('', 'abc');
		$details = $ginger->getPersonneDetails('trecouvr');
		$this->assertEquals($this->TRECOUVR_EXPECTED_DETAILS, $details);
	}

	/**
	 * @depends testApiKeyValid
	 */
	public function testlFindPersonne() {
		$ginger = new Ginger('', 'abc');
		$details = $ginger->findPersonne('trec');
		$this->assertEquals(array(
			array(
				'login'=>$this->TRECOUVR_EXPECTED_DETAILS['login'],
				'nom'=>$this->TRECOUVR_EXPECTED_DETAILS['nom'],
				'prenom'=>$this->TRECOUVR_EXPECTED_DETAILS['prenom'],
			),),
			$details
		);
	}
}

?>

