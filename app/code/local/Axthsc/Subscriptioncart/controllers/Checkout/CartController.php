<?php
# Controllers are not autoloaded so we will have to do it manually:
require_once 'Mage/Checkout/controllers/CartController.php';
class Axthsc_Subscriptioncart_Checkout_CartController extends Mage_Checkout_CartController
{
    /**
     * Update shopping cart data action
     */
    public function updatePostAction()
    {
        $updateAction = (string)$this->getRequest()->getParam('update_cart_action');

        switch ($updateAction) {
            case 'empty_cart':
                $this->_emptyShoppingCart();
                break;
            case 'update_qty':
            	$this->_updateShoppingCart();
                break;
            case 'update_subscriptions':
            	$this->_updateSubscriptionsShoppingCart();
            default:
                $this->_updateShoppingCart();
        }

        $this->_goBack();
    }

    /**
	 * Update customer's shopping cart
	 */
	protected function _updateSubscriptionsShoppingCart()
	{
		// Get the quote items  from the quote
		$cart   = $this->_getCart();
		$quote = $cart->getQuote();
		$items = $quote->getItemsCollection();

        foreach($items as $item)
        {
            $product = Mage::getModel('catalog/product')->load($item->getProductId());
            Mage::log($product, Zend_Log::DEBUG, 'ax.log', TRUE);

            $item->setCustomPrice(0);
            $item->setOriginalCustomPrice(0);

            $item->setQty(0);
            $item->setOriginalQty(0);

            $item->setAwSarpPeriod(4);
            $item->setOriginalAwSarpPeriod(4);

            $item->getProduct()->setIsSuperMode(true);
            $item->save();
        }

		// Loop through the quote items and load all options, including custom options
		foreach ($items as $item)
		{
            //$options = $item->getProduct()->getTypeInstance(true)->getOrderOptions($item->getProduct());
		    $options = Mage::getModel('sales/quote_item_option')->setItemId($item->getId())->getCollection()->getOptionsByItem($item);

            foreach ($options as $option)
            {
                //Mage::log($option, Zend_Log::DEBUG, 'ax.log', TRUE);
                // if(strtolower($option->getCode()) == 'info_buyrequest')
                // {
                //     //Read old value
                //     $unserialized = unserialize($option->getValue());
                //     $label = unserialize($option->getTitle());

                //     //Set new value
                //     $unserialized['aw_sarp_subscription_type']= 4;
                //     $unserialized['aw_sarp_subscription_start'] = "2013-11-21";
                //     $unserialized['qty'] = 33;
                //     $option->setValue(serialize($unserialized));
                //     $option->setPrintValue("Dafuq?");

                //     //Read new values
                //     $unserialized = unserialize($option->getValue());
                //     Mage::log($unserialized, Zend_Log::DEBUG, 'ax.log', TRUE);
                //     //Mage::log($label, Zend_Log::DEBUG, 'ax.log', TRUE);
                // }
            }
            $item->setOptions($options)->save(); 
            $cart->save();
            //Mage::getSingleton('checkout/cart')->save();
            $this->_getSession()->setCartWasUpdated(true);

            Mage::dispatchEvent('checkout_cart_update_item_complete',
                array('item' => $item, 'request' => $this->getRequest(), 'response' => $this->getResponse())
            );
		}
	}
}