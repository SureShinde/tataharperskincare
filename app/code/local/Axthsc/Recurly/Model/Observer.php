<?php

require_once(Mage::getBaseDir('lib') . '/Recurly/recurly.php');

class Axthsc_Recurly_Model_Observer
{

    /*
     * Disable PayPal method for subscription orders
     */
    public function paymentMethodIsActive($observer) {

        $event           = $observer->getEvent();
        $method          = $event->getMethodInstance();
        $result          = $event->getResult();

        // if (is_null($quote)) {
        //    return;
        // }

        // if (!$quote instanceof Mage_Sales_Model_Quote) {
        //     $observer->getResult()->isAvailable = false;
        //     return;
        // }

        $subscriptionItems = false;
        // foreach ($quote->getAllItems() as $item)
        foreach (Mage::getSingleton('checkout/cart')->getQuote()->getAllVisibleItems() as $item)
        {
            $sku = $item->getProduct()->getSku();

            if ((strpos($sku,'-S30') !== false) || (strpos($sku,'-S45') !== false) || (strpos($sku,'-S60') !== false) || (strpos($sku,'-S90') !== false)) {
                $subscriptionItems = true;
                break;
            }
        }
         
        if ($subscriptionItems && ($method->getCode() == 'paypal_standard')) {

            $result->isAvailable = false;

        }

          if ($subscriptionItems && ($method->getCode() == 'paypal_express')) {

            $result->isAvailable = false;

        }
    }

	/**
	 * Save credit card number and cid in customer session
	 * Event: sales_quote_save_before
	 * @param object $observer
     * @return
	*/

	public function savePaymentInfoInSession($observer) {

//		$loggr = new Loggr_Loggr("ths_replenishment", "8dd3d3d6488d45808d78a34eba08996c");
//
//        $post = Mage::app()->getFrontController()->getRequest()->getPost();
//
//        if(isset($post['recurly-token'])){
//            $recurlytoken = $post['recurly-token'];
//            $loggr->Events->CreateFromVariable($recurlytoken)
//                ->Text("Recurly Token")
//                ->Post();
//        } else {
//            $loggr->Events->CreateFromVariable(NULL)
//                ->Text("Recurly Token NOT FOUND")
//                ->Post();
//        }

		try
		{
			$quote = $observer->getEvent()->getQuote();

            if (!$quote->getPaymentsCollection()->count())
                return;

            $Payment = $quote->getPayment();

            if ($Payment && $Payment->getMethod()) {

                if ($Payment->getMethodInstance() instanceof Mage_Payment_Model_Method_Cc) {

                    // Credit Card number
                    if ($Payment->getMethodInstance()->getInfoInstance() && ($ccNumber = $Payment->getMethodInstance()->getInfoInstance()->getCcNumber())) {

                        $ccCid = $Payment->getMethodInstance()->getInfoInstance()->getCcCid();
                        $ccType = $Payment->getMethodInstance()->getInfoInstance()->getCcType();
                        
                        Mage::getSingleton('customer/session')->setSubCcNumber($ccNumber);
                        Mage::getSingleton('customer/session')->setSubCcCid($ccCid);

                    }
                }
            }

		}
		catch(Exception $e)
		{
			throw($e);
		}

	}

	/**
     * Assigns subscription of product to current user
     * Event: checkout_type_onepage_save_order_after
     * @param object $observer
     * @return
     */
    public function assignSubscriptionToCustomer($observer)
    {
        $loggr = new Loggr_Loggr("ths_replenishment", "8dd3d3d6488d45808d78a34eba08996c");

        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();

        $paymentData = $order->getPayment()->debug();
        $cards = $paymentData["additional_information"]["authorize_cards"];

        foreach ($cards as $card) {
            $expMonth = $card['cc_exp_month'];
            $expYear = $card['cc_exp_year'];
        }

        $orderId = $order->getId();

        $billingAddress = $order->getBillingAddress()->getData();
        $shippingAddress = $order->getShippingAddress()->getData();

        $loggr->Events->CreateFromVariable($shippingAddress)
            ->Text("shippingAddress - assignSubscriptionToCustomer()")
            ->Post();

        $items = $order->getItemsCollection();

        $paymentMethod = $observer->getEvent()->getOrder()->getPayment()->getMethod();

        $ccnum = Mage::getSingleton('customer/session')->getSubCcNumber();
        $cid = Mage::getSingleton('customer/session')->getSubCcCid();

        $customerId = $order->getCustomerId();

        $itemsCount = count($items);

        $subs = array(); // array of items to create new subscriptions for

        // general to order
        $subs['paymentMethod'] = $paymentMethod; // working
        $subs['ccnum'] = $ccnum; // working
        $subs['cid'] = $cid; //  working
        $subs['customerId'] = $customerId; // working
        $subs['expMonth'] = $expMonth;
        $subs['expYear'] = $expYear;
        $subs['orderId'] = $orderId;
        $subs['items'] = array(); // container for new subscriptions
        $subs['billingAddress'] = $billingAddress;
        $subs['shippingAddress'] = $shippingAddress;

        foreach ($items as $item) {

            $Product = Mage::getModel('catalog/product')->load($item->getProductId());

            $sku = $item->getSku();

            // if subscription item, add to $subs array

            if ((strpos($sku,'-S30') !== false) || (strpos($sku,'-S45') !== false) || (strpos($sku,'-S60') !== false) || (strpos($sku,'-S90') !== false)) {

                $period = substr($sku, strpos($sku, "-S") + 2);

                $primaryQuoteId = $quote->getId();

                // item specific
                $sd = array(); // item to add to $subs
                $sd['sku'] = $sku; // working
                $sd['period'] = $period;

                if (!array_key_exists($sd['sku'], $subs['items'])) {
                    $subs['items'][$sd['sku']] = $sd;
                }  

            } // end if (contains -S30, ...)

        } // end foreach

        if (count($subs['items']) > 0) {

            $loggr->Events->CreateFromVariable($subs)
            ->Text("Subscription data - assignSubscriptionToCustomer()")
            ->Post();

            $this->createRecurlySubscriptions($subs);

        }

        // remove cc info from session data
        Mage::getSingleton('customer/session')->setSubCcNumber(null);
        Mage::getSingleton('customer/session')->setSubCcCid(null);

    } // end function

    /**
     * Creates Recurly subscriptions from subscription items in order
     * @param array $subs
     * @return
     */
    public function createRecurlySubscriptions($subs) {

        $loggr = new Loggr_Loggr("ths_replenishment", "8dd3d3d6488d45808d78a34eba08996c");

        // Get customer email address
        $customerId = $subs['customerId'];
        $customer = Mage::getModel('customer/customer')->load($customerId);
        $email = $customer->getEmail();

        // $loggr->Events->CreateFromVariable($email)
        //     ->Text("Customer email - createRecurlySubscriptions()")
        //     ->Post();

        // Billing info
        $lastFour = substr($subs['ccnum'], -4);
        $ccNum = $subs['ccnum'];
        $cid = $subs['cid'];
        $expMonth = $subs['expMonth'];
        $expYear = $subs['expYear'];
        $billingAddress = $subs['billingAddress'];
        $shippingAddress = $subs['shippingAddress'];

        // If Recurly account doesn't exist, create account
        $accountId = $this->checkAccountExists($email, $lastFour);

        // $loggr->Events->CreateFromVariable($accountId)
        //         ->Text("accountID 1 - createRecurlySubscriptions()")
        //         ->Post();

        if ($accountId == false) {

            $orderId = $subs['orderId'];

            $accountId = $this->createAccount($customerId, $orderId, $ccNum, $cid, $expMonth, $expYear, $billingAddress, $shippingAddress);

            // $loggr->Events->CreateFromVariable($accountId)
            //     ->Text("New account ID - createRecurlySubscriptions()")
            //     ->Post();
        }

        // Add subscriptions to Recurly account
        if ($accountId > 0) {

             foreach ($subs['items'] as $sub) {

                $this->addSubscriptionToAccount($accountId, $sub);

            }

        }

    }

    /**
     * Check if Recurly account exists
     * @param string $email, string $lastFour
     * @return string $accountId (false if account doesn't exist)
     */
    public function checkAccountExists($email, $lastFour) {

        $loggr = new Loggr_Loggr("ths_replenishment", "8dd3d3d6488d45808d78a34eba08996c");

        Recurly_Client::$subdomain = 'tata-harper-skincare';
        Recurly_Client::$apiKey = '81b3d8d9efc449e189af7f5053b880b2';

        $accounts = Recurly_AccountList::getActive();

        $accountId = false;

        $loggr->Events->CreateFromVariable($accounts)
                ->Text("Recurly accounts - checkAccountExists()")
                ->Post();

        foreach ($accounts as $account) {

            // Check if email exists
            if ($account->email == $email) {

                $tempId = $account->account_code;

                try {

                  if($billing_info = Recurly_BillingInfo::get($tempId)) {

                      // Check if last four of card matches
                      if ($billing_info->last_four == $lastFour) {
                            $accountId = $tempId;
                            break;
                      }

                  }

                } catch (Recurly_NotFoundError $e) {
                     $loggr->Events->CreateFromException($e)
                          ->Text("Exception - checkAccountExists()")
                          ->Post();
                }                
            }
        }

        return $accountId;
    }

    /**
     * Create Recurly account
     * @param string $customerId, string $orderId, string $ccNum, string $expMonth, string $expYear
     * @return string $accountNum or false
     */
    public function createAccount($customerId, $orderId, $ccNum, $cid, $expMonth, $expYear, $billingAddress, $shippingAddress) {
        
        $loggr = new Loggr_Loggr("ths_replenishment", "8dd3d3d6488d45808d78a34eba08996c");

        Recurly_Client::$subdomain = 'tata-harper-skincare';
        Recurly_Client::$apiKey = '81b3d8d9efc449e189af7f5053b880b2';

        // Get customer information
        $customer = Mage::getModel('customer/customer')->load($customerId);
        $email = $customer->getEmail();
        $first = $customer->getFirstname();
        $last = $customer->getLastname();

        $loggr->Events->CreateFromVariable($last)
                ->Text("Last name - createAccount()")
                ->Post();

        // $order = Mage::getModel('sales/order')->loadByIncrementId($orderId);
        // $order = Mage::getModel('sales/order')->load($orderId);
        
        $loggr->Events->CreateFromVariable($billingAddress)
                ->Text("billing address - createAccount()")
                ->Post();

        // Billing info

        $first = $billingAddress['firstname'];
        $last = $billingAddress['lastname'];
        $street = $billingAddress['street'];
        $city = $billingAddress['city'];
        $state = $billingAddress['region'];
        $zipcode = $billingAddress['postcode'];
        $country = $billingAddress['country_id'];
        $phone = $billingAddress['telephone'];

        // Shipping Address
        $shipStreet = $shippingAddress['street'];
        $shipCity = $shippingAddress['city'];
        $shipState = $shippingAddress['region'];
        $shipZipcode = $shippingAddress['postcode'];
        $shipCountry = $shippingAddress['country_id'];

        $loggr->Events->CreateFromVariable($country)
                ->Text("country - createAccount()")
                ->Post();

        $addy = new Recurly_Address();
        $addy->address1 = $shipStreet;
        $addy->city = $shipCity;
        $addy->state = $shipState;
        $addy->zip = $shipZipcode;
        $addy->country = $shipCountry;
        $addy->phone = $phone;

        // Create Recurly account
        $account = new Recurly_Account($orderId);
        $account->email = $email;
        $account->first_name = $first;
        $account->last_name = $last;
        $account->tax_exempt = false;
        $account->address = $addy;
        $account->create();

        // $loggr->Events->CreateFromVariable($account)
        //         ->Text("account - createAccount()")
        //         ->Post();

        // Create billing info instance
        $billing_info = new Recurly_BillingInfo();
        $billing_info->account_code = $orderId;
        $billing_info->first_name = $first;
        $billing_info->last_name = $last;
        $billing_info->phone = $phone;
        $billing_info->address1 = $street;
        $billing_info->city = $city;
        $billing_info->state = $state;
        $billing_info->zip = $zipcode;
        $billing_info->country = $country;
        $billing_info->number = $ccNum;
        $billing_info->verification_value = $cid;
        $billing_info->month = $expMonth;
        $billing_info->year = $expYear;
        $billing_info->update();

        // $loggr->Events->CreateFromVariable($billing_info)
        //         ->Text("billing_info - createAccount()")
        //         ->Post();

        // Check if account creation was successful
        try {

          $account = Recurly_Account::get($orderId);

          // $loggr->Events->CreateFromVariable($account)
          //       ->Text("Recurly account - createAccount()")
          //       ->Post();

          return $orderId;

        } catch (Recurly_NotFoundError $e) {

            $loggr->Events->CreateFromException($e)
                          ->Text("Exception - createAccount()")
                          ->Post();

            return false;

        }

    }

    /**
     * Add subscription to account
     * @param string $accountId, array $sub
     * @return string $subId
     */
    public function addSubscriptionToAccount($accountId, $sub) {

        $loggr = new Loggr_Loggr("ths_replenishment", "8dd3d3d6488d45808d78a34eba08996c");

        Recurly_Client::$subdomain = 'tata-harper-skincare';
        Recurly_Client::$apiKey = '81b3d8d9efc449e189af7f5053b880b2';

        // Get plan code
        $sku = substr($sub['sku'], 0, -4);
        $period = $sub['period'];
        $plan = $sku . '_' . $period;

        $subscription = new Recurly_Subscription();
        $subscription->plan_code = $plan;
        $subscription->currency = 'USD';

        $account = new Recurly_Account();
        $account->account_code = $accountId;

        $subscription->account = $account;

        $subscription->create();
    }

} // end class