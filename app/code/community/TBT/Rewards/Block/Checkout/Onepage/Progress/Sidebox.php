<?php

/**
 * WDCA - Sweet Tooth
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the WDCA SWEET TOOTH POINTS AND REWARDS 
 * License, which extends the Open Software License (OSL 3.0).

 * The Open Software License is available at this URL: 
 * http://opensource.org/licenses/osl-3.0.php
 * 
 * DISCLAIMER
 * 
 * By adding to, editing, or in any way modifying this code, WDCA is 
 * not held liable for any inconsistencies or abnormalities in the 
 * behaviour of this code. 
 * By adding to, editing, or in any way modifying this code, the Licensee
 * terminates any agreement of support offered by WDCA, outlined in the 
 * provided Sweet Tooth License. 
 * Upon discovery of modified code in the process of support, the Licensee 
 * is still held accountable for any and all billable time WDCA spent 
 * during the support process.
 * WDCA does not guarantee compatibility with any other framework extension. 
 * WDCA is not responsbile for any inconsistencies or abnormalities in the
 * behaviour of this code if caused by other framework extension.
 * If you did not receive a copy of the license, please send an email to 
 * support@sweettoothrewards.com or call 1.855.699.9322, so we can send you a copy 
 * immediately.
 * 
 * @category   [TBT]
 * @package    [TBT_Rewards]
 * @copyright  Copyright (c) 2014 Sweet Tooth Inc. (http://www.sweettoothrewards.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * ONE page checkout progress sidebox that tells the customer how many points they
 * are spending/earning
 *
 * @category   TBT
 * @package    TBT_Rewards
 * * @author     Sweet Tooth Inc. <support@sweettoothrewards.com>
 */
class TBT_Rewards_Block_Checkout_Onepage_Progress_Sidebox extends Mage_Checkout_Block_Onepage_Abstract {
	
	protected function _construct() {
		parent::_construct ();
		$this->setTemplate ( 'rewards/checkout/onepage/progress/sidebox.phtml' );
	}
	
	public function getBilling() {
		return $this->getQuote ()->getBillingAddress ();
	}
	
	public function getShipping() {
		return $this->getQuote ()->getShippingAddress ();
	}
	
	public function getShippingMethod() {
		return $this->getQuote ()->getShippingAddress ()->getShippingMethod ();
	}
	
	public function getShippingDescription() {
		return $this->getQuote ()->getShippingAddress ()->getShippingDescription ();
	}
	
	public function getShippingAmount() {
		/* $amount = $this->getQuote()->getShippingAddress()->getShippingAmount();
          $filter = Mage::app()->getStore()->getPriceFilter();
          return $filter->filter($amount); */
		//return $this->helper('checkout')->formatPrice(
		//    $this->getQuote()->getShippingAddress()->getShippingAmount()
		//);
		return $this->getQuote ()->getShippingAddress ()->getShippingAmount ();
	}
	
	public function getShippingPriceInclTax() {
		$exclTax = $this->getQuote ()->getShippingAddress ()->getShippingAmount ();
		$taxAmount = $this->getQuote ()->getShippingAddress ()->getShippingTaxAmount ();
		return $this->formatPrice ( $exclTax + $taxAmount );
	}
	
	public function getShippingPriceExclTax() {
		return $this->formatPrice ( $this->getQuote ()->getShippingAddress ()->getShippingAmount () );
	}
	
	public function formatPrice($price) {
		return $this->getQuote ()->getStore ()->formatPrice ( $price );
	}
	
	public function getTotalPointsSpending() {
		//@nelkaake Added on Sunday August 29, 2010: 
		$this->assureTotals ();
		$spending = $this->_getRewardsSess ()->getTotalPointsSpendingAsString ();
		return $spending;
	}
	
	public function getTotalPointsEarning() {
		//@nelkaake Added on Sunday August 29, 2010: 
		$this->assureTotals ();
		$spending = $this->_getRewardsSess ()->getTotalPointsEarningAsString ();
		return $spending;
	}
	
	//@nelkaake Added on Sunday August 29, 2010: 
	public function assureTotals() {
		if ($this->getHasAssuredTotals ())
			return $this;
		$this->getQuote ()->collectTotals ();
		$this->setHasAssuredTotals ( true );
		return $this;
	}
	
	/**
	 * Fetches the customer session singleton
	 *
	 * @return TBT_Rewards_Model_Session
	 */
	protected function _getRewardsSess() {
		return Mage::getSingleton ( 'rewards/session' );
	}
	
	// any type of redemptions, cart and catalog
	public function showChangeLink() {
		return $this->_getRewardsSess ()->hasRedemptions ();
	}

}