<?php
/**
 * Subedit item model
 *
 * @author Anthony Xiques
 * @copyright July 6, 2013
 * @link www.reignitegroup.com
 */

class Reignite_Subedit_Model_Subedit extends Mage_Core_Model_Abstract
{
	/**
	 * Define resource model
	 */
	protected function _construct()
	{
		$this->_init('reignite_subedit/subedit');
	}

	/**
	 * If object is new adds creation date
	 *
	 * @return Reignite_Subedit_Model_Subedit
	 */
	protected function _beforeSave()
	{
		parent::_beforeSave();
		if ($this->isObjectNew()) {
			$this->setData('created_at', Varien_Date::now());
		}
		return $this;
	}
}