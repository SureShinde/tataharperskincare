<?php
/**
 * Product:     Pre-Orders for Enterprise Edition
 * Package:     Aitoc_Aitpreorder_10.0.29_558126
 * Purchase ID: 4VeYRNtXAYgEBUi2AVhbBxqctMqGCT8h6O0060qvS6
 * Generated:   2013-04-23 21:46:41
 * File path:   app/code/local/Aitoc/Aitpreorder/Model/Rewrite/SalesOrderShipment.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ UIqkekYmiZahUokw('430a7bdbdd0a822d907d4002c033dfeb'); ?><?php
/**
 * @copyright  Copyright (c) 2010 AITOC, Inc. 
 */
class Aitoc_Aitpreorder_Model_Rewrite_SalesOrderShipment extends Mage_Sales_Model_Order_Shipment
{
    public function addItem(Mage_Sales_Model_Order_Shipment_Item $item)
    {
        $item->setShipment($this)
            ->setParentId($this->getId())
            ->setStoreId($this->getStoreId());
        if(!$item->getId()) {
            $orderItem=$item->getOrderItem();
            if($orderItem->getData('product_type')=='bundle')
            {
                $isRegular=0;
                $isRegular=Mage::helper('aitpreorder')->bundleHaveReg($orderItem);
                if($isRegular==0)
                {
                    if (version_compare(Mage::getVersion(),'1.4.1.0','>=')) 
                    {
                        $tmp_total_qty=$this->getTotalQty();
                        $this->setTotalQty($tmp_total_qty-$item->getQty());
                    }
                    $item->setQty(0);
                }
            }
            $this->getItemsCollection()->addItem($item);
        }
        return $this;
    }
} } 