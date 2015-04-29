<?php
/**
 * Authorize.Net CIM - Recurring profile view / update payment info.
 *
 * Paradox Labs, Inc.
 * http://www.paradoxlabs.com
 * 717-431-3330
 *
 * Having a problem with the plugin?
 * Not sure what something means?
 * Need custom development?
 * Give us a call!
 *
 * @category	ParadoxLabs
 * @package		ParadoxLabs_AuthorizeNetCim
 * @author		Ryan Hoerr <ryan@paradoxlabs.com>
 */

class ParadoxLabs_AuthorizeNetCim_Block_Profile extends Mage_Core_Block_Template
{
	public function _construct() {
		parent::_construct();
		
		$this->setPayment( Mage::getModel('authnetcim/payment') );
		$this->setProfile( Mage::registry('current_recurring_profile') );
		$this->setCustomer( Mage::getModel('customer/customer')->load( $this->getProfile()->getCustomerId() ) );
		
		$this->getProfile()->setStore(Mage::app()->getStore())->setLocale(Mage::app()->getLocale());
		
		$post = Mage::app()->getRequest()->getPost();
		if( isset($post['set_cc']) && intval($post['payment_id']) > 0 && $post['form_key'] == Mage::getSingleton('core/session')->getFormKey() ) {
			$info = $this->getProfile()->getAdditionalInfo();
			$info['payment_id'] = intval($post['payment_id']);
			$this->getProfile()->setAdditionalInfo( $info )->save();
			
			Mage::log( 'Changed payment ID for RP #'.$this->getProfile()->getReferenceId().' to '.$info['payment_id'], null, 'authnetcim.log' );
		}
	}
	
	public function isAuthnetcim() {
		return ($this->getProfile()->getMethodCode() == 'authnetcim');
	}
	
	public function getLastBilled() {
		$date = $this->getProfile()->getAdditionalInfo('last_bill');
		return $date > 0 ? date( 'j F, Y', $date ) : 'Never';
	}
	
	public function getNextBilled() {
		$okayStates = array( 'active', 'pending' );
		
		if( in_array( $this->getProfile()->getState(), $okayStates ) ) {
			$date = $this->getProfile()->getAdditionalInfo('next_cycle');
			return $date > 0 ? date( 'j F, Y', $date ) : 'N/A';
		}
		else {
			return 'N/A';
		}
	}
	
	public function getPaymentInfo() {
		return $this->getPayment()->getPaymentInfoById( $this->getProfile()->getAdditionalInfo('payment_id'), false, $this->getCustomer()->getAuthnetcimProfileId() );
	}
	
	public function getAllCards() {
		return $this->getPayment()->getPaymentInfo( $this->getCustomer()->getAuthnetcimProfileId() );
	}
}
