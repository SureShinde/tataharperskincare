<?php
/**
 * Product:     Pre-Orders for Enterprise Edition
 * Package:     Aitoc_Aitpreorder_10.0.29_558126
 * Purchase ID: 4VeYRNtXAYgEBUi2AVhbBxqctMqGCT8h6O0060qvS6
 * Generated:   2013-04-23 21:46:41
 * File path:   app/code/local/Aitoc/Aitpreorder/Model/Rewrite/SalesOrder.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ ChiZMZSrqejoChZp('622d6c9578bef840022c56caac591f28'); ?><?php
/**
 * @copyright  Copyright (c) 2009 AITOC, Inc. 
 */
class Aitoc_Aitpreorder_Model_Rewrite_SalesOrder extends Mage_Sales_Model_Order
{
    // overwrite parent
    public function addStatusHistoryComment($comment, $status = false)
    {
        if (false === $status) {
            $status = $this->getStatus();
        } elseif (true === $status) {
            $status = $this->getConfig()->getStateDefaultStatus($this->getState());
        } else {
            $this->setStatus($status);
        }
        
        $tmpstatus=$status;
        
        $order=$this;
	    $orderStatus=$status;
	    $haveregular=0;       
            
        if(($orderStatus=='processingpreorder')||($orderStatus=='processing')||($orderStatus=='complete'))
	    {
	        $_items=$order->getItemsCollection();
	        $haveregular=Mage::helper('aitpreorder')->isHaveReg($_items,0);
                if(($haveregular==1)&&($orderStatus=='processingpreorder' || $orderStatus =='processing'))
	        {
	            $tmpstatus='processing';
	            $this->setStatusPreorder('processing');  
	        }
                elseif(($haveregular==0)&&(($orderStatus=='processing')))
	        {
	            $tmpstatus='processingpreorder';
	            $this->setStatusPreorder('processingpreorder');
	        }
                elseif($haveregular==-2 && $orderStatus=='processing')
                {
                    $tmpstatus='processing';
                    $this->setStatusPreorder('processing');
                }
                elseif($haveregular==-2 && $orderStatus!='processing')
                {
                    $tmpstatus='complete';
                    $this->setStatusPreorder('complete');
                }
                elseif($haveregular==-1)
                {
                    $tmpstatus='processingpreorder';
                    $this->setStatusPreorder('processingpreorder');
                }
	    }
	    elseif(($orderStatus=='pending')||($orderStatus=='pendingpreorder'))
	    {
	        $_items=$order->getItemsCollection();
                $haveregular=Mage::helper('aitpreorder')->isHaveReg($_items,1);
	        
	        if(($haveregular==0)&&($orderStatus=='pending'))
                    {
	            $tmpstatus='pendingpreorder';
	            $this->setStatusPreorder('pendingpreorder');
		    }
                elseif(($haveregular!=0)&&($orderStatus=='pendingpreorder'))
                {
                    $tmpstatus='pending';
                    $this->setStatusPreorder('pending');
                }
	    }
        
        $history = Mage::getModel('sales/order_status_history')
            ->setStatus($tmpstatus)
            ->setComment($comment);
        $this->addStatusHistory($history);
        
        if($this->getStatus()=='pendingpreorder')
        {
        	$this->setStatus('pending');
        }
        elseif($this->getStatus()=='processingpreorder')
        {
        	$this->setStatus('processing');
        }
        
        return $history;
    }
} } 