<?php

require_once(Mage::getBaseDir('lib') . '/Recurly/recurly.php');

class Axthsc_Recurly_DeleteController extends Mage_Core_Controller_Front_Action
{

	public function indexAction()
	{
        return $this->_redirect('/');
	}

	public function subAction()
	{
		Recurly_Client::$subdomain = 'tata-harper-skincare';
    	Recurly_Client::$apiKey = '81b3d8d9efc449e189af7f5053b880b2';

		$sub = $this->getRequest()->getParam('id');

		if ($sub && $this->userOwnsSub($sub)) {

			try {
				$subscription = Recurly_Subscription::get($sub);
				$subscription->terminateWithoutRefund();
				echo "Subscription canceled.";
			} catch (Exception $e) {
				echo "Error canceling subscription";
			}

		}
	}

	public function preDispatch()
    {
        parent::preDispatch();
        $action = $this->getRequest()->getActionName();
        $loginUrl = Mage::helper('customer')->getLoginUrl();
 
        if (!Mage::getSingleton('customer/session')->authenticate($this, $loginUrl)) {
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
        }
    }

    private function userOwnsSub($sub) {

    	Recurly_Client::$subdomain = 'tata-harper-skincare';
    	Recurly_Client::$apiKey = '81b3d8d9efc449e189af7f5053b880b2';

    	$customerEmail = Mage::getSingleton('customer/session')->getCustomer()->getEmail();

    	$accounts = Recurly_AccountList::getActive();
    	$custAccounts = array();

    	$ownsSub = false;

		foreach ($accounts as $account) {

		  if ($account->email == $customerEmail) {
		  	$custAccounts[] = $account->account_code;
		  }

		}

		foreach ($custAccounts as $acct) {
			$subscriptions = Recurly_SubscriptionList::getForAccount($acct);
			foreach ($subscriptions as $subscription) {
				if (($subscription->state == "active") || ($subscription->state == "future")) {
					if ($subscription->uuid == $sub) {
						$ownsSub = true;
					}
				}
			}
		}

		return $ownsSub;
    }

}