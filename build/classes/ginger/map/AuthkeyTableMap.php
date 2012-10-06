<?php



/**
 * This class defines the structure of the 'authkey' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.ginger.map
 */
class AuthkeyTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'ginger.map.AuthkeyTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('authkey');
        $this->setPhpName('Authkey');
        $this->setClassname('Authkey');
        $this->setPackage('ginger');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('ASSO', 'Asso', 'VARCHAR', true, 200, null);
        $this->addColumn('DETAILS', 'Details', 'VARCHAR', true, 1000, null);
        $this->addColumn('CLE', 'Cle', 'VARCHAR', true, 50, null);
        $this->addColumn('DROIT_ECRITURE', 'DroitEcriture', 'INTEGER', true, null, 0);
        $this->addColumn('DROIT_BADGES', 'DroitBadges', 'INTEGER', true, null, 0);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_updated_at' => 'false', ),
        );
    } // getBehaviors()

} // AuthkeyTableMap
