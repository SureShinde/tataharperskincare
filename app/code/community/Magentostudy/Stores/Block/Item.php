<?php
/**
 * Stores Item block
 *
 * @author Magento
 */
class Magentostudy_Stores_Block_Item extends Mage_Core_Block_Template
{
    /**
     * Current stores item instance
     *
     * @var Magentostudy_Stores_Model_Stores
     */
    protected $_item;

    /**
     * Return parameters for back url
     *
     * @param array $additionalParams
     * @return array
     */
    protected function _getBackUrlQueryParams($additionalParams = array())
    {
        return array_merge(array('p' => $this->getPage()), $additionalParams);
    }

    /**
     * Return URL to the stores list page
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/', array('_query' => $this->_getBackUrlQueryParams()));
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
