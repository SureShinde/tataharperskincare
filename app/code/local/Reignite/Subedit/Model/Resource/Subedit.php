<?php
/**
 * Subedit item resource model
 *
 * @author Anthony Xiques
 * @copyright July 6, 2013
 * @link www.reignitegroup.com
 */

class Reignite_Subedit_Model_Resource_Subedit extends Mage_Core_Model_Resource_Db_Abstract
{
	/**
	 * Initialize connection and define main table and primary key
	 */
	protected function _construct()
	{
		$this->_init('reignite_subedit/subedit', 'subedit_id');
	}
}
