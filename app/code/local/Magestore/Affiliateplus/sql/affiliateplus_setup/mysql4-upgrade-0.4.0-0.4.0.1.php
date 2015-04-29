<?php

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("

ALTER TABLE {$this->getTable('affiliateplus/account')}
  ADD COLUMN `telephone` varchar(60),
  ADD COLUMN `mailing_address` varchar(255),
  ADD COLUMN `country` varchar(255),
  ADD COLUMN `date_of_birth` varchar(60),
  ADD COLUMN `website_name` varchar(255),
  ADD COLUMN `website_url` varchar(255),
  ADD COLUMN `website_description` longtext,
  ADD COLUMN `website_marketing_overview` longtext,
  ADD COLUMN `website_topics` longtext,
  ADD COLUMN `notes` varchar(255),
  ADD COLUMN `traffic_sources` longtext,
  ADD COLUMN `monetization_strategy` varchar(255),
  ADD COLUMN `unique_visitors` varchar(255);
 ");

$installer->endSetup();
