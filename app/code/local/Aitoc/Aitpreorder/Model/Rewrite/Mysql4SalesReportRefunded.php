<?php
/**
 * Product:     Pre-Orders for Enterprise Edition
 * Package:     Aitoc_Aitpreorder_10.0.29_558126
 * Purchase ID: 4VeYRNtXAYgEBUi2AVhbBxqctMqGCT8h6O0060qvS6
 * Generated:   2013-04-23 21:46:41
 * File path:   app/code/local/Aitoc/Aitpreorder/Model/Rewrite/Mysql4SalesReportRefunded.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ RTCPDmYgprkiRqmo('4622ea08c061ec0f5ba6c9b5a7f1411f'); ?><?php
/**
 * @copyright  Copyright (c) 2009 AITOC, Inc. 
 */
class Aitoc_Aitpreorder_Model_Rewrite_Mysql4SalesReportRefunded extends Mage_Sales_Model_Mysql4_Report_Refunded
{
    protected function _aggregateByRefundCreatedAt($from, $to)
    {
        $model = Mage::helper('aitpreorder')->retrieveAppropriateVersionClass('sales_mysql4_report_refunded');
        return $model->_aggregateByRefundCreatedAt($from, $to);
    }

    protected function _aggregateByOrderCreatedAt($from, $to)
    {
        $model = Mage::helper('aitpreorder')->retrieveAppropriateVersionClass('sales_mysql4_report_refunded');
        return $model->_aggregateByOrderCreatedAt($from, $to);
    }
} } 