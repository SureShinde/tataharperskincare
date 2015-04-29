<?php
/**
 * Stores collection
 *
 * @author Magento
 */
class Magentostudy_Stores_Model_Resource_Stores_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Define collection model
     */
    protected function _construct()
    {
        $this->_init('magentostudy_stores/stores');
    }

    /**
     * Prepare for displaying in list
     *
     * @param integer $page
     * @return Magentostudy_Stores_Model_Resource_Stores_Collection
     */
    public function prepareForList($page)
    {
        $this->setPageSize(Mage::helper('magentostudy_stores')->getStoresPerPage());
        $this->setCurPage($page)->setOrder('published_at', Varien_Data_Collection::SORT_ORDER_DESC);
        return $this;
    }
}