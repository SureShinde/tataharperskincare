<?php
/**
 * Product:     Pre-Orders for Enterprise Edition
 * Package:     Aitoc_Aitpreorder_10.0.29_558126
 * Purchase ID: 4VeYRNtXAYgEBUi2AVhbBxqctMqGCT8h6O0060qvS6
 * Generated:   2013-04-23 21:46:41
 * File path:   app/code/local/Aitoc/Aitpreorder/Block/Rewrite/CatalogProductPrice.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ TUhEjySMoarwTpyi('295ba79798e3accf1023e1ded91062eb'); ?><?php
/**
* @copyright  Copyright (c) 2009 AITOC, Inc. 
*/

class Aitoc_Aitpreorder_Block_Rewrite_CatalogProductPrice extends Mage_Catalog_Block_Product_Price
{

    protected function _toHtml()
    {   
        $_product = $this->getProduct();
        $preOrderFlag = false;
        $inStock = false;
        if($_product->getTypeId() == 'configurable')
        {
           // $opt = new Aitoc_Aitpreorder_Block_Rewrite_CatalogProductViewTypeConfigurable();
           // echo var_dump($opt->getJsonConfigWithPreorder());

            $associatedProducts = Mage::getSingleton('catalog/product_type')->factory($_product)->getUsedProducts($_product);
            foreach($associatedProducts as $associatedProduct) 
            {   
                if($associatedProduct->getPreorder() == '1')
                {
                    $preOrderFlag = true;
                } else {
					if ($associatedProduct->getData('is_in_stock')) {
						$inStock = true;
					}
				}
            } 
        }
        
		if ($inStock) {
			$preOrderFlag = false;
		}

        $_id = $_product->getId(); 
        $add_preorder_before_price="";
        
        if(Mage::getModel('catalog/product')->load($_id)->getPreorder()==1 or $preOrderFlag)
        {
            return(str_replace('price-box"','price-box"><span class="regular-price price pre-order">'.$this->__('Pre-Order').'</span', parent::_toHtml()));
        }
                else
        {        
            return ($add_preorder_before_price.parent::_toHtml());
        }
    }

} } 