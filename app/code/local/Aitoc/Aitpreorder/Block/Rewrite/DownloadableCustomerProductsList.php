<?php
/**
 * Product:     Pre-Orders for Enterprise Edition
 * Package:     Aitoc_Aitpreorder_10.0.29_558126
 * Purchase ID: 4VeYRNtXAYgEBUi2AVhbBxqctMqGCT8h6O0060qvS6
 * Generated:   2013-04-23 21:46:41
 * File path:   app/code/local/Aitoc/Aitpreorder/Block/Rewrite/DownloadableCustomerProductsList.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ IcprBrSywDZqIirh('0c0823628341fdcce8610b4007317eac'); ?><?php
/**
* @copyright  Copyright (c) 2009 AITOC, Inc. 
*/

class Aitoc_Aitpreorder_Block_Rewrite_DownloadableCustomerProductsList extends Mage_Downloadable_Block_Customer_Products_List
{

    public function getDownloadUrl($item)
    {
        $sku = $item->getPurchased()->getData('product_sku');
        
        $product = Mage::getModel('catalog/product');
        $product_id = $product->getIdBySku($sku);
        $product->load($product_id);

        if (($product->getPreorder() == 1) && 
            ($product->getData('type_id') == 'downloadable') &&
            ($item->getStatus() == 'available'))
        {
            return 'zxc' . $product_id . 'zxc';
        }
        else
        {
            return parent::getDownloadUrl($item);
        }
    }
    
    protected function _toHtml()
    {
        $html = parent::_toHtml();
 
        $count = preg_match('/zxc[0-9]{1,10}zxc/', $html, $matches, PREG_OFFSET_CAPTURE);
       
        while ($count > 0)
        {
            preg_match('/\<a.{1,100}' . $matches[0][0] . '.{1,100}a\>/U', $html, $matchesahref, PREG_OFFSET_CAPTURE);

            $linkTitle = '';
            preg_match('/\>.{1,60}\</', $matchesahref[0][0], $linkTitle);
            $html = substr_replace($html, substr($linkTitle[0], 1, -1), $matchesahref[0][1], strlen($matchesahref[0][0]));

			$statusText = Mage::helper('downloadable')->__('Available');
			
            $statusTextPosition = strpos($html, $statusText, $matches[0][1]);
            if ($statusTextPosition > 0)
            {
                $id = substr($matches[0][0], 3, -3);
                $preorderDescription = Mage::getModel('catalog/product')->load($id)->getPreorderdescript();
                $html = substr_replace($html, $preorderDescription, $statusTextPosition, strlen($statusText));
            }
            
            $count = preg_match('/zxc[0-9]{1,10}zxc/', $html, $matches, PREG_OFFSET_CAPTURE, $matches[0][1] + strlen($matches[0][0]));
        }
       
        return $html;
    }
} } 