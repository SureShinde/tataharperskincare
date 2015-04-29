<?php
/**
 * Product:     Pre-Orders for Enterprise Edition
 * Package:     Aitoc_Aitpreorder_10.0.29_558126
 * Purchase ID: 4VeYRNtXAYgEBUi2AVhbBxqctMqGCT8h6O0060qvS6
 * Generated:   2013-04-23 21:46:41
 * File path:   app/code/local/Aitoc/Aitpreorder/Block/Rewrite/CatalogProductViewTypeSimple.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ ChiZMZSrqejoChZp('2b1ca8e08cd929a48f1b6200ca18d53f'); ?><?php
class Aitoc_Aitpreorder_Block_Rewrite_CatalogProductViewTypeSimple extends Mage_Catalog_Block_Product_View_Type_Simple
{
    protected function _toHtml()
    {
        $product = $this->getProduct();        
        if ($product->getPreorder())
        {
            $catalogHelper = Mage::helper('catalog');
            $result = parent::_toHtml();
            $descript=$this->getProduct()->getPreorderdescript();
            if($descript=="")
            {
                $descript=$this->__('Pre-Order');
            }
            if (stripos($result, $this->__('Out of stock')))
            {
                $descript=$this->__('not Available');
                $result = str_ireplace($this->__('Out of stock')," ".$descript,$result);
            }
            if (!stripos($descript, $this->__('Out of stock')))
            {
                $result=str_ireplace($this->__('In stock')," ".$descript,$result);
            }
            return $result;
        }
        
        return parent::_toHtml();
    }
} } 