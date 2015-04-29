<?php
/**
 * Product:     Pre-Orders for Enterprise Edition
 * Package:     Aitoc_Aitpreorder_10.0.29_558126
 * Purchase ID: 4VeYRNtXAYgEBUi2AVhbBxqctMqGCT8h6O0060qvS6
 * Generated:   2013-04-23 21:46:41
 * File path:   app/code/local/Aitoc/Aitpreorder/Model/Rewrite/CatalogProduct.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ AfTdkeYDcMghuoeC('73b991dadaef8708afe79220a2b114c7'); ?><?php
/**
* @copyright  Copyright (c) 2011 AITOC, Inc.
*/

class Aitoc_Aitpreorder_Model_Rewrite_CatalogProduct extends Mage_Catalog_Model_Product
{
    /**
     * Added for compatibility with Multi-location Inventory.
     * Mage_Catalog_Model_Product::getPreorder() should respect setting
     * "Website Inventory: Use Default Values".
     *
     * @return integer
     */
    public function getPreorder()
    {
        $preorder = parent::getPreorder();
        if(!isset($preorder))
        {
            $preorder = $this->_getPreorder();
        }

        if (Mage::helper('aitpreorder')->checkIfMultilocationInventoryIsEnabled())
        {
            $stockItem = Mage::getModel('aitquantitymanager/stock_item');
            $stockItem->loadByProduct($this);            

            if ($stockItem->getUseDefaultWebsiteStock())
            {
                $preorder = Aitoc_Aitpreorder_Model_Rewrite_SourceBackorders::BACKORDERS_YES_PREORDERS == $stockItem->getBackorders();
            }
        }        

            /* */
            if (!Mage::app()->getStore()->isAdmin())
            {
                $performer = Aitoc_Aitsys_Abstract_Service::get()->platform()->getModule('Aitoc_Aitpreorder')->getLicense()->getPerformer();
                $ruler = $performer->getRuler();
                if (!($ruler->checkRule('store',Mage::app()->getStore()->getId(),'store') || $ruler->checkRule('store',Mage::app()->getStore()->getWebsiteId(),'website')))
                {
                if($preorder==1)
                    {
                        return '0';
                    }
                }
            }
            /* */
        
        return $preorder;
    }
    
    protected function _beforeSave()
    {
        $item = $this->getStockData();
        if(isset($item['use_config_backorders']) && $item['use_config_backorders']=='1')
        {
           $item['backorders']= Mage::getStoreConfig('cataloginventory/item_options/backorders');
           $this->setStockData($item); 
           $this->setPreorder('');
        }
     
        return parent::_beforeSave();
    }
    
    private function _getPreorder()
    {
        $item = $this->getStockItem();
        //new product
        if(!isset($item))
        {
            $confValue = Mage::getStoreConfig('cataloginventory/item_options/backorders');
        }
        //created product
        elseif($item->getUseConfigBackorders()=='1')
        {
            $confValue = Mage::getStoreConfig('cataloginventory/item_options/backorders');
        }
        else
        {
            $confValue = $item->getBackorders();
        }
        $preorder = ($confValue=='30')?'1':'0';
        return $preorder;
    }
} } 