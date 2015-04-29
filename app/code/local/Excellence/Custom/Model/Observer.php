<?php
class Excellence_Custom_Model_Observer{
	public function saveQuoteBefore($evt){
		$quote = $evt->getQuote();
		$post = Mage::app()->getFrontController()->getRequest()->getPost();
		if(isset($post['custom']['comments'])){
			$var = $post['custom']['comments'];
			$quote->setComments($var);
		}
		if(isset($post['custom']['referral'])){
			$var = $post['custom']['referral'];
			$quote->setReferral($var);
		}
		if(isset($post['custom']['subscribe'])){
			$var = $post['custom']['subscribe'];
			$quote->setSubscribe($var);
		}

	}
	public function saveQuoteAfter($evt){
		$quote = $evt->getQuote();
		if($quote->getComments()){
			$var = $quote->getComments();
			if(!empty($var)){
				$model = Mage::getModel('custom/custom_quote');
				$model->deteleByQuote($quote->getId(),'comments');
				$model->setQuoteId($quote->getId());
				$model->setKey('comments');
				$model->setValue($var);
				$model->save();
			}
		}
		if($quote->getReferral()){
			$var2 = $quote->getReferral();
			if(!empty($var2)){
				$model = Mage::getModel('custom/custom_quote');
				$model->deteleByQuote($quote->getId(),'referral');
				$model->setQuoteId($quote->getId());
				$model->setKey('referral');
				$model->setValue($var2);
				$model->save();
			}
		}
		if($quote->getSubscribe()){
			$var3 = $quote->getSubscribe();
			if(!empty($var3)){
				$model = Mage::getModel('custom/custom_quote');
				$model->deteleByQuote($quote->getId(),'subscribe');
				$model->setQuoteId($quote->getId());
				$model->setKey('subscribe');
				$model->setValue($var3);
				$model->save();
			}
		}
	}
	public function loadQuoteAfter($evt){
		$quote = $evt->getQuote();
		$model = Mage::getModel('custom/custom_quote');
		$data = $model->getByQuote($quote->getId());
		foreach($data as $key => $value){
			$quote->setData($key,$value);
		}
	}
	public function saveOrderAfter($evt){
		$order = $evt->getOrder();
		$quote = $evt->getQuote();
		if($quote->getComments()){
			$var = $quote->getComments();
			if(!empty($var)){
				$model = Mage::getModel('custom/custom_order');
				$model->deleteByOrder($order->getId(),'comments');
				$model->setOrderId($order->getId());
				$model->setKey('comments');
				$model->setValue($var);
				$order->setComments($var);
				$model->save();
			}
		}
		if($quote->getReferral()){
			$var = $quote->getReferral();
			if(!empty($var)){
				$model = Mage::getModel('custom/custom_order');
				$model->deleteByOrder($order->getId(),'referral');
				$model->setOrderId($order->getId());
				$model->setKey('referral');
				$model->setValue($var);
				$order->setReferral($var);
				$model->save();
			}
		}
		if($quote->getSubscribe()){
			$var = $quote->getSubscribe();
			if(!empty($var)){
				$model = Mage::getModel('custom/custom_order');
				$model->deleteByOrder($order->getId(),'subscribe');
				$model->setOrderId($order->getId());
				$model->setKey('subscribe');
				$model->setValue($var);
				$order->setSubscribe($var);
				$model->save();
			}
		}
	}
	public function loadOrderAfter($evt){
		$order = $evt->getOrder();
		$model = Mage::getModel('custom/custom_order');
		$data = $model->getByOrder($order->getId());
		foreach($data as $key => $value){
			$order->setData($key,$value);
		}
	}

}