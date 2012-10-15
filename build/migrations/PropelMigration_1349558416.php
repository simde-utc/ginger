<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1349558416.
 * Generated on 2012-10-06 22:20:16 by arthur
 */
class PropelMigration_1349558416
{

    public function preUp($manager)
    {
        // add the pre-migration code here
    }

    public function postUp($manager)
    {
        // add the post-migration code here
    }

    public function preDown($manager)
    {
        // add the pre-migration code here
    }

    public function postDown($manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'ginger' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `authkey` CHANGE `droit_ecriture` `droit_ecriture` TINYINT(1) DEFAULT 0 NOT NULL;

ALTER TABLE `authkey` CHANGE `droit_badges` `droit_badges` TINYINT(1) DEFAULT 0 NOT NULL;

ALTER TABLE `personne` CHANGE `is_adulte` `is_adulte` TINYINT(1) NOT NULL;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'ginger' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `authkey` CHANGE `droit_ecriture` `droit_ecriture` INTEGER DEFAULT 0 NOT NULL;

ALTER TABLE `authkey` CHANGE `droit_badges` `droit_badges` INTEGER DEFAULT 0 NOT NULL;

ALTER TABLE `personne` CHANGE `is_adulte` `is_adulte` INTEGER NOT NULL;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}