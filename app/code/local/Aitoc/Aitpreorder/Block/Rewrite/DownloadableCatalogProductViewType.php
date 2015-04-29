<?php
/**
 * Product:     Pre-Orders for Enterprise Edition
 * Package:     Aitoc_Aitpreorder_10.0.29_558126
 * Purchase ID: 4VeYRNtXAYgEBUi2AVhbBxqctMqGCT8h6O0060qvS6
 * Generated:   2013-04-23 21:46:41
 * File path:   app/code/local/Aitoc/Aitpreorder/Block/Rewrite/DownloadableCatalogProductViewType.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ QRcWZMSBqkyoQhMp('e15febb1ab937c542fa8fe68e476e387'); ?><?php
/**
* @copyright  Copyright (c) 2009 AITOC, Inc. 
*/

class Aitoc_Aitpreorder_Block_Rewrite_DownloadableCatalogProductViewType extends Mage_Downloadable_Block_Catalog_Product_View_Type
{
    protected function _toHtml()
    {               
        if($this->getProduct()->getPreorder())
        {
            $result=parent::_toHtml();
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
        else
        {   
            return parent::_toHtml();
        }
    }
} } 