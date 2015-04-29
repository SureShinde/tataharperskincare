<?php
/**
 * Reignite_Subedit index controller
 *
 * @author Anthony Xiques
 * @copyright July 6, 2013
 * @link www.reignitegroup.com
 */
class Reignite_Subedit_ChangeController extends Mage_Core_Controller_Front_Action
{
	// _check() copied from AW/Sarp/controllers/CustomerController.php
	protected function _check()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            $model = Mage::getModel('sarp/subscription')->load($id);
            if (Mage::getModel('customer/session')->getId() != $model->getCustomerId()) {
                Mage::getSingleton('core/session')->addError(Mage::helper('sarp')->__('Invalid subscription ID!'));
                return false;
            }
            else
                return true;
        }
    }

    private function _updateSubscriptionType($id, $type, $billdate)
    {
        $newBillDate = new DateTime((String)$billdate);
        $resource = Mage::getSingleton('core/resource');
        $writeConnection = $resource->getConnection('core_write');
        
        $query = "update un38dj4_aw_sarp_subscriptions set period_type = '{$type}' where id = '{$id}'";
        $results = $writeConnection->query($query);
        if (!$results)
            return false;

        $insertDate = $newBillDate->format('Y-m-d');
        $query = "update un38dj4_aw_sarp_flat_subscriptions set flat_next_payment_date = '{$insertDate}' where subscription_id = '{$id}'";
        mail("anthony@reignitegroup.com", "debugging", $query);
        $results = $writeConnection->query($query);
        if (!$results)
            return false;

        $insertDate = $newBillDate->format('Y-m-d');
        $query = "update un38dj4_aw_sarp_flat_subscriptions set flat_next_delivery_date = '{$insertDate}' where subscription_id = '{$id}'";
        $results = $writeConnection->query($query);
        if (!$results)
            return false;

        $query = "delete from un38dj4_aw_sarp_sequence where subscription_id='{$id}'";
        $results = $writeConnection->query($query);
        if (!$results)
            return false;

        $pnum = 0;

        if ($type == 1)
            $pnum = 30;
        elseif ($type == 2)
            $pnum = 45;
        elseif ($type == 3)
            $pnum = 60;
        else if ($type == 4)
            $pnum = 90;

        if ($pnum == 0)
            return false;

        $query = "select * from un38dj4_aw_sarp_flat_subscriptions where subscription_id = '{$id}'";
        $results = $writeConnection->fetchAll($query);
        if (!$results)
            return false;

        $expireDate = new DateTime($results[0]['flat_date_expire']);

        $runningDate = $newBillDate;
        $dateString = "+" . $pnum . " days";

        while ($runningDate < $expireDate)
        {
            $insertDate = $runningDate->format('Y-m-d');

            $query = "insert into un38dj4_aw_sarp_sequence (id, subscription_id, date, status, order_id, attempts_qty) values (NULL, '{$id}', '{$insertDate}', 'pending', '0', '0')";

            $results = $writeConnection->query($query);
            if (!$results)
                return false;

            $runningDate->modify($dateString);
        }

        return true;
    }

	public function indexAction()
	{
		//echo "Inside change controller";

        return $this->_redirect('/');

	}

	public function typeAction()
	{
		if (!Mage::getSingleton('customer/session')->getCustomerId()) {
            Mage::getSingleton('customer/session')->authenticate($this);
            return;
        }

        $subId = $this->getRequest()->getParam('id');
        if (!$subId) {
        	return $this->_forward('noRoute');
        }

        if (!$this->_check())
            return $this->_redirect('/');

		$this->loadLayout();

		$this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');

		if($changeBlock = $this->getLayout()->getBlock('subedit.change')){
			$changeBlock->setSubscriptionId($subId);
		}

		$this->renderLayout();
	}

    public function submitAction()
    {
        if (!Mage::getSingleton('customer/session')->getCustomerId()) {
            Mage::getSingleton('customer/session')->authenticate($this);
            return;
        }

        $subId = $this->getRequest()->getParam('id');
        if (!$subId) {
            return $this->_forward('noRoute');
        }

        if (!$this->_check())
            return $this->_redirect('/');

        // redirect to Model for updating
        // if update successful, redirect to resultsAction()
        $periodid = $this->getRequest()->getParam('periodid');
        $billdate = $this->getRequest()->getParam('newbilldate');
        $results = $this->_updateSubscriptionType($subId, $periodid, $billdate);
        $this->_sendTransactionalEmail($subId, $periodid);
        return $this->_redirect('subedit/change/results/id/' . $subId);
    }

    protected function _sendTransactionalEmail($subid, $periodid)
    {
        // set the Transactional Email Template's ID that you've created...
        $templateId = 34;
    
        // Set sender information
        $senderName = Mage::getStoreConfig('trans_email/ident_support/name');
        $senderEmail = Mage::getStoreConfig('trans_email/ident_support/email');
        $sender = array('name' => $senderName,
                    'email' => $senderEmail);
    
        // Set recepient information
        $customerId = Mage::getSingleton('customer/session')->getCustomerId();
        $customerData = Mage::getModel('customer/customer')->load($customerId)->getData();
        $recipientName = $customerData->getFirstname();
        $recipientEmail = $customerData->getEmail(); 
    
        // Get Store ID
        $store = Mage::app()->getStore()->getId();
    
        // Set variables that can be used in email template. To get this variable write like {{var customerEmail}} in transactional Email.
        $flat = Mage::getModel('sarp/subscription_flat')->load($subid, 'subscription_id');
        $productsText = $flat->getProductsText();

        switch ($subid) {
            case 1:
                $subtext = "Every 30 Days";
                break;
            case 2:
                $subtext = "Every 45 Days";
                break;
            case 3:
                $subtext = "Every 60 Days";
                break;
            case 4:
                $subtext = "Every 90 Days";
                break;
            default:
                $subtext = "N/A - Please contact customer service";
                break;
        }

        $vars = array('subscription' => $subid,            
                  'product' => $productsText,
                  'period' => $subtext);
    
        $translate  = Mage::getSingleton('core/translate');
    
        // Send Transactional Email
        Mage::getModel('core/email_template')
            ->addBcc($senderEmail)      // You can remove it if you don't need to send bcc 
            ->sendTransactional($templateId, $sender, $recepientEmail, $recepientName, $vars, $store);
    
        $translate->setTranslateInline(true);
    }

    public function resultsAction()
    {
        if (!Mage::getSingleton('customer/session')->getCustomerId()) {
            Mage::getSingleton('customer/session')->authenticate($this);
            return;
        }

        $subId = $this->getRequest()->getParam('id');
        if (!$subId) {
            return $this->_forward('noRoute');
        }

        if (!$this->_check())
            return $this->_redirect('/');

        $this->loadLayout();

        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');

        if($changeBlock = $this->getLayout()->getBlock('subedit.change')){
            $changeBlock->setSubscriptionId($subId);
        }

        $this->renderLayout();
    }
}