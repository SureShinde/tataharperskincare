<?php
/**
 * Product:     Pre-Orders for Enterprise Edition
 * Package:     Aitoc_Aitpreorder_10.0.29_558126
 * Purchase ID: 4VeYRNtXAYgEBUi2AVhbBxqctMqGCT8h6O0060qvS6
 * Generated:   2013-04-23 21:46:41
 * File path:   app/code/local/Aitoc/Aitpreorder/Block/Rewrite/CatalogProductViewTypeConfigurable.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ UIqkekYmiZahUokw('2a767f6ffd0df911cbdb8fa2add8c3fa'); ?><?php
/**
* @copyright  Copyright (c) 2009 AITOC, Inc. 
*/

class Aitoc_Aitpreorder_Block_Rewrite_CatalogProductViewTypeConfigurable extends Mage_Catalog_Block_Product_View_Type_Configurable
{
    protected function _toHtml()
    {    
      
        if($this->getNameInLayout()=='product.info.options.configurable')
        {
            return parent::_toHtml().'<input type="hidden" value="'.__('Pre-Order').'" id="saypreorder"><input type="hidden" value="'.__('Add to Cart').'" id="sayaddtocart"><script type="text/javascript">
            var spConfig = new Product.ConfigPreorder('.$this->getJsonConfig().',{"preorder":'.$this->getJsonConfigWithPreorder().'});
            </script><div id="canBePreorder"></div>';
        }
        else
        {
            return parent::_toHtml();
        }        
    }
    public function getJsonConfigWithPreorder()
    {
        foreach ($this->getAllowProducts() as $product) {
            if($product->getPreorder()=='1')
            {
                $options[$product->getId()] = $product->getPreorder();
                if($product->getData('is_in_stock'))
                {
                    $options['descript'][$product->getId()]=$product->getPreorderdescript();
                    if($options['descript'][$product->getId()]=='')
                    {
                        $options['descript'][$product->getId()]=__('Pre-Order');
                    }
                }
                else 
                {
                    $options['descript'][$product->getId()]=__('not Available');
                }
                
            }
            else            
            {
                $options[$product->getId()] = 0;
                if($product->getData('is_in_stock'))
                {
                   // $options['descript'][$product->getId()]=$product->getPreorderdescript();
                   // if($options['descript'][$product->getId()]=='')
                    {
                        $options['descript'][$product->getId()]=__('In stock');
                    }
                }
                else 
                {
                    $options['descript'][$product->getId()]=__('Out stock');
                }
            }  
        }
        return Mage::helper('core')->jsonEncode($options);
    }
} } 