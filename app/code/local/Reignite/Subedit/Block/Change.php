<?php
/**
 * Index block
 *
 * @author Anthony Xiques
 * @copyright July 6, 2013
 * @link www.reignitegroup.com
 */

class Reignite_Subedit_Block_Change extends Mage_Core_Block_Template
{
	protected $_subscription = null;

	public function getSubscriptionId() {
		return ($this->getData('subscription_id') ? $this->getData('subscription_id') : 0);
	}

	protected function _setSubscription() {
		if($subData = Mage::getModel('sarp/subscription')->load($this->getData('subscription_id'))) {
			$this->_subscription = $subData;
		}
	}

	protected function _getSubscriptionData() {
		if (is_null($_subscription)) {
			$this->_setSubscription();
		}

		if (!is_null($this->_subscription))
		{
			return $this->_subscription->getData();
		}
		else
		{
			return null;
		}
	}

	protected function _getPeriodDays($code) {
		switch ($code)
		{
			case 1:
				return 30;
			case 2:
				return 45;
			case 3:
				return 60;
			case 4:
				return 90;
			default:
				return false;
		}
	}

	public function getOptions($code) {
		switch ($code) {
			case 1:
				return "<option value='2'>Every 45 Days</option><option value='3'>Every 60 Days</option><option value='4'>Every 90 Days</option>";
			case 2:
				return "<option value='1'>Every 30 Days</option><option value='3'>Every 60 Days</option><option value='4'>Every 90 Days</option>";
			case 3:
				return "<option value='1'>Every 30 Days</option><option value='2'>Every 45 Days</option><option value='4'>Every 90 Days</option>";
			case 4:
				return "<option value='1'>Every 30 Days</option><option value='2'>Every 45 Days</option><option value='3'>Every 60 Days</option>";
			default:
				return false;
		}
	} 

	public function getSubscriptionData() {
		$sub = $this->_getSubscriptionData();

		$nextPayment = date('n/j/y', strtotime($sub['flat_next_payment_date']));

		$nextDelivery = $sub['flat_next_delivery_date'];
		$nextDelivery = $nextDelivery . " + 3 Weekday";
		$nextDelivery = date('n/j/y', strtotime($nextDelivery));

		$data = array();

		$today = date('n/j/y');

		// Retrieve latest associated record in original_subscription_delivery
		$resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $query = 'SELECT * FROM original_subscription_delivery WHERE subscription_id = \'' . $subid . '\' ORDER BY id DESC LIMIT 1';
        $results = $readConnection->fetchAll($query);

        $originalCase = false;

        // Is the original_subscription_delivery date the valid delivery date?
        if ($results)
        {
        	$dateString = $results[0]['delivery_date'] . " +3 Weekday";
        	$originalDate = date('n/j/y', strtotime($dateString));

        	if (($originalDate) && (strtotime($originalDate) > strtotime($today)) && (strtotime($originalDate) < strtotime($nextDelivery)))
	        {
	        	$originalCase = true;

	        	$nextDelivery = $originalDate;
	        }
        }

        // No relevant results found from original_subscription_delivery
		if ((strtotime($today) > strtotime($nextDelivery)) && (!$originalCase))
		{
			$nextDelivery = $nextPayment . " + 3 Weekday";
			$nextDelivery = date('n/j/y', strtotime($nextDelivery));
		}
		
		$sub['flat_next_payment_date'] = $nextPayment;
		$sub['flat_next_delivery_date'] = $nextDelivery;
		$sub['period_days'] = $this->_getPeriodDays($sub['period_type']);

		if ((strtotime($nextPayment) > strtotime($nextDelivery)) && (strtotime($today) < strtotime($nextPayment)) && (strtotime($today) < strtotime($nextDelivery)))
		//if (($nextPayment > $nextDelivery) && ($today < $nextPayment) && ($today < $nextDelivery))
		//if (1==5)
		{
			$sub['redzone'] = true;
		}

		return $sub;
	}

	public function getPostData() {
		return $this->getRequest()->getPost();
	}

}