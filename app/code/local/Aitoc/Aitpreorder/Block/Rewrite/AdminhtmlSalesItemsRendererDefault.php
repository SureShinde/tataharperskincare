<?php
/**
 * Product:     Pre-Orders for Enterprise Edition
 * Package:     Aitoc_Aitpreorder_10.0.29_558126
 * Purchase ID: 4VeYRNtXAYgEBUi2AVhbBxqctMqGCT8h6O0060qvS6
 * Generated:   2013-04-23 21:46:41
 * File path:   app/code/local/Aitoc/Aitpreorder/Block/Rewrite/AdminhtmlSalesItemsRendererDefault.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ NQIOagYehympNwgq('17255e029f0142cf5eee54afe46c90f5'); ?><?php
/**
* @copyright  Copyright (c) 2009 AITOC, Inc. 
*/

class Aitoc_Aitpreorder_Block_Rewrite_AdminhtmlSalesItemsRendererDefault extends Mage_Adminhtml_Block_Sales_Items_Renderer_Default
{




  public function getColumnHtml(Varien_Object $item, $column, $field = null)
    {
            $str="";$sku="";
            if($column=='name') 
            {
                $orderItemDataS=$item->getOrderItem()->getData('product_options');
                if($item->getOrderItem()->getData('product_type')=='grouped')
                {
                    $product=Mage::getModel('catalog/product')->load($item->getOrderItem()->getData('product_id'));
                    $sku=$product->getSku();  
                }
                else
                {                
                    $orderItemData=unserialize($orderItemDataS);
                    $itemdata=$item->getData();
                    if(isset($orderItemData['simple_sku']))
                    {
                        $sku=$orderItemData['simple_sku'];
                    }
                    elseif(isset($itemdata['sku']))
                    {
                        $sku=$itemdata['sku'];
                    }
                }
                if($sku!="")
                    {                
                        $str='<input type="hidden" id="preordersku" value="'.$sku.'">';  
                    }
                                    
            }
            return parent::getColumnHtml($item, $column, $field).$str;
    }
    




} } 