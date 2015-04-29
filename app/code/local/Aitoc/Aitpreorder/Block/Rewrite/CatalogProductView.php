<?php
/**
 * Product:     Pre-Orders for Enterprise Edition
 * Package:     Aitoc_Aitpreorder_10.0.29_558126
 * Purchase ID: 4VeYRNtXAYgEBUi2AVhbBxqctMqGCT8h6O0060qvS6
 * Generated:   2013-04-23 21:46:41
 * File path:   app/code/local/Aitoc/Aitpreorder/Block/Rewrite/CatalogProductView.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ AfTdkeYDcMghuoeC('834630676e6a28094714d33b719ea212'); ?><?php
/**
* @copyright  Copyright (c) 2009 AITOC, Inc. 
*/

class Aitoc_Aitpreorder_Block_Rewrite_CatalogProductView extends Mage_Catalog_Block_Product_View
{
    protected function _toHtml()
    {          
        $case19v = version_compare(Mage::getVersion(), '1.9.0.0', '>=') && version_compare(Mage::getVersion(), '1.10.0.0', '<') && ($this->getNameInLayout()=='product.info');
        if(($this->getNameInLayout()=='product.info.addtocart' && $this->getProduct()->getPreorder()) || $case19v)
        {
            $result=str_replace($this->__('Add to Cart'), $this->__('Pre-Order'), parent::_toHtml());   
            return $result;
        }
        else
        { 
            return parent::_toHtml();
        }
    }
} } 