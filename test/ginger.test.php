<?php

require_once '../vendor/autoload.php';

// Include model
Propel::init("../build/conf/ginger-conf.php");
set_include_path("../build/classes" . PATH_SEPARATOR . get_include_path());

require_once '../config.php';
require_once '../class/Ginger.class.php';
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

	protected function getPersonneDetails() {
		return array(
			"login" => 'trecouvr',
			"nom" => 'Recouvreux',
			"prenom" => 'Thomas',
			"mail" => 'thomas.recouvreux@etu.utc.fr',
			"type" => 'etu',
			"is_adulte" => true,
			"is_cotisant" => true,
			"badge_uid" => 'ABCDEF1234',
			"expiration_badge" => '2013-07-01',
		);
	}

	protected function getCotisation() {
		return array(
				"id" => 1,
				"debut" => '2012-09-01',
				"fin" => '2013-09-01',
				"montant" => 20,
		);
	}
	
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
		$expected_details = $this->getPersonneDetails();
		$details = $ginger->getPersonneDetails($expected_details['login']);
		$this->assertEquals($expected_details, $details);
		$details = $ginger->getPersonneDetails($expected_details['badge_uid']);
		$this->assertEquals($expected_details, $details);
	}

	/**
	 * @depends testApiKeyValid
	 */
	public function testFindPersonne() {
		$ginger = new Ginger('', 'abc');
		$expected_details = $this->getPersonneDetails();
		$details = $ginger->findPersonne('trec');
		$this->assertEquals(array(
			array(
				'login'=>$expected_details['login'],
				'nom'=>$expected_details['nom'],
				'prenom'=>$expected_details['prenom'],
			),),
			$details
		);
	}

	public function testGetCotisations() {
		$ginger = new Ginger('', 'abc');
		$expected_cotisation = $this->getCotisation();
		$cotisations = $ginger->getPersonneCotisations('trecouvr');
		$this->assertEquals(array($expected_cotisation,), $cotisations);
	}

	/**
	 * @depends testGetPersonneDetails
	 * @depends testGetCotisations
	 */
	public function testDeleteCotisation() {
		$ginger = new Ginger('', 'abc');
		$ginger->deleteCotisation(1);
		
		$expected_cotisation = $this->getCotisation();
		$cotisations = $ginger->getPersonneCotisations('trecouvr');
		$cotisation = $cotisations[0];
		$this->assertArrayHasKey("deleted_at", $cotisation);
		$this->assertNotNull($cotisation["deleted_at"]);
		unset($cotisation["deleted_at"]);
		$this->assertEquals($expected_cotisation, $cotisation);
	}

	public function coucou() {
		$this->assertEquals(1, 0);
	}
	
	/**
	 * @depends testGetPersonneDetails
	 * @depends testDeleteCotisation
	 */
	public function testIsCotisant() {
		$ginger = new Ginger('', 'abc');
		$expected_details = $this->getPersonneDetails();
		
		$details = $ginger->getPersonneDetails($expected_details['login']);
		$this->assertTrue($details["is_cotisant"]);
		
		$ginger->deleteCotisation(1);
		$details = $ginger->getPersonneDetails($expected_details['login']);
		$this->assertFalse($details["is_cotisant"]);
	}
}

?>

