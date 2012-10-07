
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- cotisation
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `cotisation`;

CREATE TABLE `cotisation`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `personne_id` INTEGER NOT NULL,
    `debut` DATE NOT NULL,
    `fin` DATE NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `cotisation_FI_1` (`personne_id`),
    CONSTRAINT `cotisation_FK_1`
        FOREIGN KEY (`personne_id`)
        REFERENCES `personne` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- personne
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `personne`;

CREATE TABLE `personne`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `login` VARCHAR(8) NOT NULL,
    `prenom` VARCHAR(128) NOT NULL,
    `nom` VARCHAR(128) NOT NULL,
    `mail` VARCHAR(200) NOT NULL,
    `type` TINYINT NOT NULL,
    `date_naissance` DATE,
    `is_adulte` TINYINT(1) NOT NULL,
    `badge_uid` VARCHAR(10),
    `expiration_badge` DATE,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `personne_U_1` (`login`, `badge_uid`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- authkey
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `authkey`;

CREATE TABLE `authkey`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `asso` VARCHAR(200) NOT NULL,
    `details` VARCHAR(1000) NOT NULL,
    `cle` VARCHAR(50) NOT NULL,
    `droit_ecriture` TINYINT(1) DEFAULT 0 NOT NULL,
    `droit_badges` TINYINT(1) DEFAULT 0 NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `authkey_U_1` (`cle`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
