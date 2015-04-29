<?php
/**
 * Stores List block
 *
 * @author Magento
 */
class Magentostudy_Stores_Block_List extends Mage_Core_Block_Template
{
    /**
     * Stores collection
     *
     * @var Magentostudy_Stores_Model_Resource_Stores_Collection
     */
    protected $_storesCollection = null;

    /**
     * Retrieve stores collection
     *
     * @return Magentostudy_Stores_Model_Resource_Stores_Collection
     */
    protected function _getCollection()
    {
        return  Mage::getResourceModel('magentostudy_stores/stores_collection');
    }

    /**
     * Retrieve prepared stores collection
     *
     * @return Magentostudy_Stores_Model_Resource_Stores_Collection
     */
    public function getCollection()
    {
        if (is_null($this->_storesCollection)) {
            $this->_storesCollection = $this->_getCollection();
            $this->_storesCollection->prepareForList($this->getCurrentPage());
        }

        return $this->_storesCollection;
    }

    /**
     * Return URL to item's view page
     *
     * @param Magentostudy_Stores_Model_Stores $storesItem
     * @return string
     */
    public function getItemUrl($storesItem)
    {
        return $this->getUrl('*/*/view', array('id' => $storesItem->getId()));
    }

    /**
     * Fetch the current page for the stores list
     *
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->getData('current_page') ? $this->getData('current_page') : 1;
    }

    /**
     * Get a pager
     *
     * @return string|null
     */
    public function getPager()
    {
        $pager = $this->getChild('stores_list_pager');
        if ($pager) {
            $storesPerPage = Mage::helper('magentostudy_stores')->getStoresPerPage();

            $pager->setAvailableLimit(array($storesPerPage => $storesPerPage));
            $pager->setTotalNum($this->getCollection()->getSize());
            $pager->setCollection($this->getCollection());
            $pager->setShowPerPage(true);

            return $pager->toHtml();
        }

        return null;
    }

    /**
     * Return URL for resized Stores Item image
     *
     * @param Magentostudy_Stores_Model_Stores $item
     * @param integer $width
     * @return string|false
     */
    public function getImageUrl($item, $width)
    {
        return Mage::helper('magentostudy_stores/image')->resize($item, $width);
    }
}
