<?php
/**
 * Stores Data helper
 *
 * @author Magento
 */
class Magentostudy_Stores_Helper_Data extends Mage_Core_Helper_Data
{
    /**
     * Path to store config if front-end output is enabled
     *
     * @var string
     */
    const XML_PATH_ENABLED            = 'stores/view/enabled';

    /**
     * Path to store config where count of stores posts per page is stored
     *
     * @var string
     */
    const XML_PATH_ITEMS_PER_PAGE     = 'stores/view/items_per_page';

    /**
     * Path to store config where count of days while stores is still recently added is stored
     *
     * @var string
     */
    const XML_PATH_DAYS_DIFFERENCE    = 'stores/view/days_difference';

    /**
     * Stores Item instance for lazy loading
     *
     * @var Magentostudy_Stores_Model_Stores
     */
    protected $_storesItemInstance;

    /**
     * Checks whether stores can be displayed in the frontend
     *
     * @param integer|string|Mage_Core_Model_Store $store
     * @return boolean
     */
    public function isEnabled($store = null)
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_ENABLED, $store);
    }

    /**
     * Return the number of items per page
     *
     * @param integer|string|Mage_Core_Model_Store $store
     * @return int
     */
    public function getStoresPerPage($store = null)
    {
        return abs((int)Mage::getStoreConfig(self::XML_PATH_ITEMS_PER_PAGE, $store));
    }

    /**
     * Return difference in days while stores is recently added
     *
     * @param integer|string|Mage_Core_Model_Store $store
     * @return int
     */
    public function getDaysDifference($store = null)
    {
        return abs((int)Mage::getStoreConfig(self::XML_PATH_DAYS_DIFFERENCE, $store));
    }

    /**
     * Return current stores item instance from the Registry
     *
     * @return Magentostudy_Stores_Model_Stores
     */
    public function getStoresItemInstance()
    {
        if (!$this->_storesItemInstance) {
            $this->_storesItemInstance = Mage::registry('stores_item');

            if (!$this->_storesItemInstance) {
                Mage::throwException($this->__('Stores item instance does not exist in Registry'));
            }
        }

        return $this->_storesItemInstance;
    }
}