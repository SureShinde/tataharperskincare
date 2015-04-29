<?php
/**
 * Product:     Pre-Orders for Enterprise Edition
 * Package:     Aitoc_Aitpreorder_10.0.29_558126
 * Purchase ID: 4VeYRNtXAYgEBUi2AVhbBxqctMqGCT8h6O0060qvS6
 * Generated:   2013-04-23 21:46:41
 * File path:   app/code/local/Aitoc/Aitpreorder/Model/Rewrite/Mysql4SalesReportOrder.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ cCoagaYkhjDpcwaq('646791d31258c881a49b19f56a809303'); ?><?php
/**
 * @copyright  Copyright (c) 2009 AITOC, Inc. 
 */
class Aitoc_Aitpreorder_Model_Rewrite_Mysql4SalesReportOrder extends Mage_Sales_Model_Mysql4_Report_Order
{
    public function aggregate($from = null, $to = null)
    {
        $model = Mage::helper('aitpreorder')->retrieveAppropriateVersionClass('sales_mysql4_report_order');
        if($model)
            return $model->aggregate($from, $to);        

        return parent::aggregate($from, $to);
    }
} } 