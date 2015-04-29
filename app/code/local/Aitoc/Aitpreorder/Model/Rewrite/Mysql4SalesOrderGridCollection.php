<?php
/**
 * Product:     Pre-Orders for Enterprise Edition
 * Package:     Aitoc_Aitpreorder_10.0.29_558126
 * Purchase ID: 4VeYRNtXAYgEBUi2AVhbBxqctMqGCT8h6O0060qvS6
 * Generated:   2013-04-23 21:46:41
 * File path:   app/code/local/Aitoc/Aitpreorder/Model/Rewrite/Mysql4SalesOrderGridCollection.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ AfTdkeYDcMghuoeC('57a021aecd6ddd64bdc48770853ef867'); ?><?php
/**
 * @copyright  Copyright (c) 2009 AITOC, Inc. 
 */
class Aitoc_Aitpreorder_Model_Rewrite_Mysql4SalesOrderGridCollection extends Mage_Sales_Model_Mysql4_Order_Grid_Collection
{
	protected function _afterLoad()
    {
    	parent::_afterLoad();
    	foreach ($this->getItems() as $item)
    	{
			if(!Mage::helper('aitpreorder')->checkSynchronization($item->getStatus(),$item->getStatusPreorder()))
			{
				$item->setStatusPreorder($item->getStatus());
				$item->save();
			}
			$item->setStatus($item->getStatusPreorder());
    	}
    	return $this;
    }
} } 