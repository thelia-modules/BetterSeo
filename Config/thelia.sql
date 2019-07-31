
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- seo_noindex
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `seo_noindex`;

CREATE TABLE `seo_noindex`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `object_id` INTEGER NOT NULL,
    `object_type` VARCHAR(255) NOT NULL,
    `noindex` INTEGER DEFAULT 0 NOT NULL,
    `canonical_field` TEXT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
