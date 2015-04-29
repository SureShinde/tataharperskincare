<?php
/**
 * Product:     Pre-Orders for Enterprise Edition
 * Package:     Aitoc_Aitpreorder_10.0.29_558126
 * Purchase ID: 4VeYRNtXAYgEBUi2AVhbBxqctMqGCT8h6O0060qvS6
 * Generated:   2013-04-23 21:46:41
 * File path:   app/code/local/Aitoc/Aitpreorder/Block/Rewrite/AdminhtmlSalesOrderInvoiceCreateForm.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ RTCPDmYgprkiRqmo('d3b09aebe1b03903cfae8df91080d781'); ?><?php
/**
* @copyright  Copyright (c) 2009 AITOC, Inc. 
*/

class Aitoc_Aitpreorder_Block_Rewrite_AdminhtmlSalesOrderInvoiceCreateForm extends Mage_Adminhtml_Block_Sales_Order_Invoice_Create_Form
{
   public function hasInvoiceShipmentTypeMismatch() {
        $result = parent::hasInvoiceShipmentTypeMismatch();
        if(!$result)
        {
            $order=$this->getOrder(); 
            $havepreorder=Mage::helper('aitpreorder')->IsHavePreorder($order);
            
            if($havepreorder)
            {
                $result=true;
            }
                   
        }
        return $result;
    }
       
} } 