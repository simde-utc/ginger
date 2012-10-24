<?php

require_once 'vendor/autoload.php';

// Include model
Propel::init("build/conf/ginger-conf.php");
set_include_path("build/classes" . PATH_SEPARATOR . get_include_path());

require_once 'config.php';
require_once 'class/ginger.class.php';
require_once 'class/Koala.class.php';


class TruncateOperation extends \PHPUnit_Extensions_Database_Operation_Truncate
{
	public function execute(\PHPUnit_Extensions_Database_DB_IDatabaseConnection $connection, \PHPUnit_Extensions_Database_DataSet_IDataSet $dataSet)
	{
		$connection->getConnection()->query("SET foreign_key_checks = 0");
		parent::execute($connection, $dataSet);
		$connection->getConnection()->query("SET foreign_key_checks = 1");
	}
}

class GingerTest extends PHPUnit_Extensions_Database_TestCase
{
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

	public function testInit() {
		new Ginger('', 'abc');
	}

	/**
	 * @depends testInit
	 * @expectedException		 \Koala\ApiException
	 * @expectedExceptionCode	 403
	 */
	public function testApiKeyInvalid() {
		new Ginger('', 'existepas');
	}

	/**
	 * @depends testInit
	 * @expectedException		 \Koala\ApiException
	 * @expectedExceptionCode	 401
	 */
	public function testApiKeyNull() {
		new Ginger('', NULL);
	}

	/**
	 * @depends testInit
	 * @expectedException		 \Koala\ApiException
	 * @expectedExceptionCode	 401
	 */
	public function testApiKeyEmptyString() {
		new Ginger('', '');
	}

	/**
	 * @depends testInit
	 */
	public function testGetPersonneDetails()
	{
		$ginger = new Ginger('http://localhost/accounts/', 'abc');
		$details = $ginger->getPersonneDetails('trecouvr');
		$expected_details = array(
				"login" => 'trecouvr',
				"nom" => 'Recouvreux',
				"prenom" => 'Thomas',
				"mail" => 'thomas.recouvreux@etu.utc.fr',
				"type" => 'etu',
				"is_adulte" => true,
				"is_cotisant" => false,
				"badge_uid" => 'ABCDEF1234',
				"expiration_badge" => null
		);
		$this->assertEquals($expected_details, $details);
	}

}

?>

