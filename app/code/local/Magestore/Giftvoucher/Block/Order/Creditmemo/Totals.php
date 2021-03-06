<?php
class Magestore_Giftvoucher_Block_Order_Creditmemo_Totals extends Mage_Core_Block_Template
{
	public function initTotals(){
		$orderTotalsBlock = $this->getParentBlock();
		$order = $orderTotalsBlock->getCreditmemo();
		if ($order->getGiftVoucherDiscount()){
			$orderTotalsBlock->addTotal(new Varien_Object(array(
				'code'	=> 'giftvoucher',
				'label'	=> $this->__('Gift card (%s)',$order->getOrder()->getGiftCodes()),
				'value'	=> -$order->getGiftVoucherDiscount(),
			)),'subtotal');
		}
        if ($refund = $order->getGiftcardRefundAmount()) {
            if ($order->getOrder()->getCustomerIsGuest() || !Mage::helper('giftvoucher')->getGeneralConfig('enablecredit', $order->getStoreId())) {
                $label = $this->__('Refund to your Gift card code');
            } else {
                $label = $this->__('Refund to your credit balance');
            }
            $orderTotalsBlock->addTotal(new Varien_Object(array(
				'code'	=> 'giftcard_refund',
				'label'	=> $label,
				'value'	=> $refund,
                'area'  => 'footer',
			)),'subtotal');
        }
	}
}