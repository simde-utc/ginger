<?php

require_once 'vendor/autoload.php';
require_once 'class/ginger.class.php';

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
		$pdo = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']);
		return $this->createDefaultDBConnection($pdo, $GLOBALS['DB_DBNAME']);
	}

	public function getDataSet()
	{
		return new PHPUnit_Extensions_Database_DataSet_YamlDataSet(dirname(__FILE__).'/ginger-seed.yml');
	}

	public function testInit() {
		new Ginger('http://localhost/accounts/', 'abc');
	}

	/*
	 * @depends testInit
	 * @expectedException		 ApiException
	 * @expectedExceptionCode	 403
	 */
	public function testApiKeyInvalid() {
		new Ginger('http://localhost/accounts/', 'existepas');
	}

	/*
	 * @depends testInit
	 * @expectedException		 ApiException
	 * @expectedExceptionCode	 401
	 */
	public function testApiKeyNull() {
		new Ginger(NULL, 'existepas');
	}

	/*
	 * @depends testInit
	 * @expectedException		 ApiException
	 * @expectedExceptionCode	 401
	 */
	public function testApiKeyEmptyString() {
		new Ginger('', 'existepas');
	}

	/*
	 * @depends testInit
	 */
	public function testGetPersonneDetails()
	{
		$ginger = new Ginger('http://localhost/accounts/', 'abc');
		$details = $this->ginger->getPersonneDetails('trecouvr');
		$expected_details = array(
				"login" => 'trecouvr',
				"nom" => 'Recouvreux',
				"prenom" => 'Thomas',
				"mail" => 'thomas.recouvreux@etu.utc.fr',
				"type" => 'etu',
				"is_adulte" => 1,
				"is_cotisant" => 1,
				"badge_uid" => 'ABCDEF1234',
				"expiration_badge" => '2013-07-01'
		);
		$this->assertEqual($expected_details, $details);
	}

}

?>

