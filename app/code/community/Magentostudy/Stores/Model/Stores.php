<?php
/**
 * Stores item model
 *
 * @author Magento
 */
class Magentostudy_Stores_Model_Stores extends Mage_Core_Model_Abstract
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('magentostudy_stores/stores');
    }

    /**
     * If object is new adds creation date
     *
     * @return Magentostudy_Stores_Model_Stores
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