<?php



/**
 * This class defines the structure of the 'personne' table.
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
class PersonneTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'ginger.map.PersonneTableMap';

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
        $this->setName('personne');
        $this->setPhpName('Personne');
        $this->setClassname('Personne');
        $this->setPackage('ginger');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('LOGIN', 'Login', 'VARCHAR', true, 8, null);
        $this->addColumn('PRENOM', 'Prenom', 'VARCHAR', true, 128, null);
        $this->addColumn('NOM', 'Nom', 'VARCHAR', true, 128, null);
        $this->addColumn('MAIL', 'Mail', 'VARCHAR', true, 200, null);
        $this->addColumn('TYPE', 'Type', 'ENUM', true, null, null);
        $this->getColumn('TYPE', false)->setValueSet(array (
  0 => 'etu',
  1 => 'pers',
  2 => 'escom',
  3 => 'escompers',
  4 => 'ext',
));
        $this->addColumn('DATE_NAISSANCE', 'DateNaissance', 'DATE', false, null, null);
        $this->addColumn('IS_ADULTE', 'IsAdulte', 'INTEGER', true, null, null);
        $this->addColumn('BADGE_UID', 'BadgeUid', 'VARCHAR', false, 10, null);
        $this->addColumn('EXPIRATION_BADGE', 'ExpirationBadge', 'DATE', false, null, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Cotisation', 'Cotisation', RelationMap::ONE_TO_MANY, array('id' => 'personne_id', ), null, null, 'Cotisations');
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

} // PersonneTableMap
