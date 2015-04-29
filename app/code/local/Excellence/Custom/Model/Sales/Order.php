<?php
class Excellence_Custom_Model_Sales_Order extends Mage_Sales_Model_Order{
	public function hasCustomFields(){
		$var = $this->getComments() || $this->getReferral() || $this->getSubscribe();
		if($var && !empty($var)){
			return true;
		}else{
			return false;
		}
	}
	public function getFieldHtml(){
		$html = '';
		if ($this->getComments()) {$var = $this->getComments();}
		if ($var) {$html .= '<b>Comments:</b>'.$var.'<br/>';}
		if ($this->getReferral()) {$var2 = $this->getReferral();}
		if ($var2) {$html .= '<b>Referral:</b>'.$var2.'<br/>';}
		if ($this->getSubscribe()) {$var3 = $this->getSubscribe();}
		if ($var3) {$html .= '<b>Subscribe:</b>'.$var3.'<br/>';}
		
		return $html;
	}
}