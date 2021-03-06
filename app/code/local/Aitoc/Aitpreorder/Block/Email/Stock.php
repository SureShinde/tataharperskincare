<?php
/**
 * Product:     Pre-Orders for Enterprise Edition
 * Package:     Aitoc_Aitpreorder_10.0.29_558126
 * Purchase ID: 4VeYRNtXAYgEBUi2AVhbBxqctMqGCT8h6O0060qvS6
 * Generated:   2013-04-23 21:46:41
 * File path:   app/code/local/Aitoc/Aitpreorder/Block/Email/Stock.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ ChiZMZSrqejoChZp('3de39075e5452d34a231fbff6dbd6cc2'); ?><?php
/**
 * @copyright  Copyright (c) 2012 AITOC, Inc. 
 */
class Aitoc_Aitpreorder_Block_Email_Stock extends Mage_ProductAlert_Block_Email_Stock
{
    	
    /**
     * Retrive unsubscribe url for product
     *
     * @param int $productId
     * @return string
     */
    public function getProductUnsubscribeUrl($productId)
    {
        return '';
    }

    /**
     * Retrieve unsubscribe url for all products
     *
     * @return string
     */
    public function getUnsubscribeUrl()
    {
        return '';
    }
	
	protected function _toHtml()
    {          
		$result=parent::_toHtml();
		if ($_products = $this->getProducts())
		{
		    foreach ($_products as $_product){
		        $toDelete = '<p><small><a href="' . $this->getProductUnsubscribeUrl($_product->getId()) . '">' . $this->__('Click here not to receive alerts for this product') . '</a></small></p>';

				$order_view_url = Mage::registry('order_view_url');
				if($order_view_url)
				{
					$product_url = $_product->getProductUrl();
					$result=str_replace($product_url, $order_view_url, $result);
				}
	            $result=str_replace($toDelete, '', $result);
			}
			
		}
		$toDelete2 = '<p><a href="' . $this->getUnsubscribeUrl() . '">' . $this->__('Unsubscribe from all stock alerts') . '</a></p>';
		$result=str_replace($toDelete2, '', $result);
		
		
		
		
		return $result;
    }
} } 