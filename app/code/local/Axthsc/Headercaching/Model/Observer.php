<?php
  class Axthsc_Headercaching_Model_Observer {

    public function disableCache(Varien_Event_Observer $observer)
    {
      $action = $observer->getEvent()->getControllerAction();

      if ($action instanceof Mage_Page_Block_Html_Header) { // eg. Mage_Catalog_ProductController
        $request = $action->getRequest();
        $cache = Mage::app()->getCacheInstance();

        $cache->banUse('full_page'); // Tell Magento to 'ban' the use of FPC for this request
      }
    }
  }