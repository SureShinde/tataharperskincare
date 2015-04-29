<?php
/**
 * Stores module observer
 *
 * @author Magento
 */
class Magentostudy_Stores_Model_Observer
{
    /**
     * Event before show stores item on frontend
     * If specified new post was added recently (term is defined in config) we'll see message about this on front-end.
     *
     * @param Varien_Event_Observer $observer
     */
    public function beforeStoresDisplayed(Varien_Event_Observer $observer)
    {
        $storesItem = $observer->getEvent()->getStoresItem();
        $currentDate = Mage::app()->getLocale()->date();
        $storesCreatedAt = Mage::app()->getLocale()->date(strtotime($storesItem->getCreatedAt()));
        $daysDifference = $currentDate->sub($storesCreatedAt)->getTimestamp() / (60 * 60 * 24);
        if ($daysDifference < Mage::helper('magentostudy_stores')->getDaysDifference()) {
            Mage::getSingleton('core/session')->addSuccess(Mage::helper('magentostudy_stores')->__('Recently added'));
        }
    }
}