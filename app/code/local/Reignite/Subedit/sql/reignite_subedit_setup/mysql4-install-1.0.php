<?php
/**
 * Subedit installation script
 *
 * @author Anthony Xiques
 * @copyright July 6, 2013
 * @link www.reignitegroup.com
 */

/**
 * @var $installer Mage_Core_Model_Resource_SEtup
 */
$installer = $this;

/**
 * Creating table reignite_subedit
 */
$table = $installer->getConnection()
	->newTable($installer->getTable('reignite_subedit/subedit'))
	->addColumn('subedit_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'unsigned' => true,
		'identity' => true,
		'nullable' => false,
		'primary' => true,
		), 'Entity id')
	->addColumn('subscription_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'nullable' => false,
		), 'Subscription ID')
	->addColumn('historical_delivery_date', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
		'nullable' => false,
		'default' => false,
		), 'Historical Delivery Date')
	->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
		'nullable' => true,
		'default' => false,
		), 'Creation Time');

$installer->getConnection()->createTable($table);