<?php
/**
 * Stores item resource model
 *
 * @author Magento
 */
class Magentostudy_Stores_Model_Resource_Stores extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize connection and define main table and primary key
     */
    protected function _construct()
    {
        $this->_init('magentostudy_stores/stores', 'stores_id');
    }
}