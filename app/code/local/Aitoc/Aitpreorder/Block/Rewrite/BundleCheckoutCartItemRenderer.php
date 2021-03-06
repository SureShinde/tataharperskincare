<?php
/**
 * Product:     Pre-Orders for Enterprise Edition
 * Package:     Aitoc_Aitpreorder_10.0.29_558126
 * Purchase ID: 4VeYRNtXAYgEBUi2AVhbBxqctMqGCT8h6O0060qvS6
 * Generated:   2013-04-23 21:46:41
 * File path:   app/code/local/Aitoc/Aitpreorder/Block/Rewrite/BundleCheckoutCartItemRenderer.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ TUhEjySMoarwTpyi('aeb7a0f133c13a20eb7cf63ed2eeca16'); ?><?php
/**
* @copyright  Copyright (c) 2009 AITOC, Inc. 
*/

class Aitoc_Aitpreorder_Block_Rewrite_BundleCheckoutCartItemRenderer extends Mage_Bundle_Block_Checkout_Cart_Item_Renderer
{
 
    public function getOptionList($useCache = true)
    {
        return $this->_getBundleOptions($useCache);
    }

    protected function _getBundleOptions($useCache = true)
    {
        $options = array();

        /**
         * @var Mage_Bundle_Model_Product_Type
         */
        $typeInstance = $this->getProduct()->getTypeInstance(true);

        // get bundle options
        $optionsQuoteItemOption =  $this->getItem()->getOptionByCode('bundle_option_ids');
        $bundleOptionsIds = unserialize($optionsQuoteItemOption->getValue());
        if ($bundleOptionsIds) {
            /**
            * @var Mage_Bundle_Model_Mysql4_Option_Collection
            */
            $optionsCollection = $typeInstance->getOptionsByIds($bundleOptionsIds, $this->getProduct());

            // get and add bundle selections collection
            $selectionsQuoteItemOption = $this->getItem()->getOptionByCode('bundle_selection_ids');

            $selectionsCollection = $typeInstance->getSelectionsByIds(
                unserialize($selectionsQuoteItemOption->getValue()),
                $this->getProduct()
            );

            $bundleOptions = $optionsCollection->appendSelections($selectionsCollection, true);
            foreach ($bundleOptions as $bundleOption) {
                if ($bundleOption->getSelections()) {
                    $option = array('label' => $bundleOption->getTitle(), "value" => array());
                    $bundleSelections = $bundleOption->getSelections();

                    foreach ($bundleSelections as $bundleSelection) {
                        $addinf='';
                        $selectionQty = $this->getProduct()->getCustomOption('selection_qty_' . $bundleSelection->getSelectionId());
                        $_product = Mage::getModel('catalog/product')->load($selectionQty->getProduct()->getId());
                        if($_product->getPreorder()=='1')
                        {
                            $preorderdescript='';
                            if($_product->getPreorderdescript()!="")
                            {
                                $preorderdescript=', '.$_product->getPreorderdescript();
                            }
                            $addinf='<p class="item-msg notice">* '.__('Pre-Order').$preorderdescript.'</p>';
                        }
                 
                        $option['value'][] = $this->_getSelectionQty($bundleSelection->getSelectionId()).' x '. $this->htmlEscape($bundleSelection->getName()). ' ' .Mage::helper('core')->currency($this->_getSelectionFinalPrice($bundleSelection)).$addinf;
                    }

                    $options[] = $option;
                }
            }
        }
        return $options;
    }

} } 