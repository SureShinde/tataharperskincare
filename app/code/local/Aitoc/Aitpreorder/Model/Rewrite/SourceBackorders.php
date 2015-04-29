<?php
/**
 * Product:     Pre-Orders for Enterprise Edition
 * Package:     Aitoc_Aitpreorder_10.0.29_558126
 * Purchase ID: 4VeYRNtXAYgEBUi2AVhbBxqctMqGCT8h6O0060qvS6
 * Generated:   2013-04-23 21:46:41
 * File path:   app/code/local/Aitoc/Aitpreorder/Model/Rewrite/SourceBackorders.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ ChiZMZSrqejoChZp('e1881b6ce888fe7c0be884bc9f832391'); ?><?php
/**
 * @copyright  Copyright (c) 2011 AITOC, Inc.
 */
class Aitoc_Aitpreorder_Model_Rewrite_SourceBackorders extends Mage_CatalogInventory_Model_Source_Backorders
{
	const BACKORDERS_YES_PREORDERS = 30;
	public function toOptionArray()
    {
        $options = parent::toOptionArray();

		$options[] = array(
			'value' => self::BACKORDERS_YES_PREORDERS,
			'label'=>Mage::helper('cataloginventory')->__('Pre-Orders')
		);

		return $options;
    }
}
 } ?>