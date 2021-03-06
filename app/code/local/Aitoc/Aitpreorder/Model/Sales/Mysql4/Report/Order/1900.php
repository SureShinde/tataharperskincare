<?php
/**
 * Product:     Pre-Orders for Enterprise Edition
 * Package:     Aitoc_Aitpreorder_10.0.29_558126
 * Purchase ID: 4VeYRNtXAYgEBUi2AVhbBxqctMqGCT8h6O0060qvS6
 * Generated:   2013-04-23 21:46:41
 * File path:   app/code/local/Aitoc/Aitpreorder/Model/Sales/Mysql4/Report/Order/1900.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ QRcWZMSBqkyoQhMp('8ea0b9a7887c2bb3b819a8b74d252ac4'); ?><?php
/**
 * @copyright  Copyright (c) 2009 AITOC, Inc. 
 */
class Aitoc_Aitpreorder_Model_Sales_Mysql4_Report_Order_1900 extends Mage_Sales_Model_Mysql4_Report_Order
{
    public function aggregate($from = null, $to = null)
    {
        // convert input dates to UTC to be comparable with DATETIME fields in DB
        $from = $this->_dateToUtc($from);
        $to = $this->_dateToUtc($to);

        $this->_checkDates($from, $to);
        $this->_getWriteAdapter()->beginTransaction();

        try {
            if ($from !== null || $to !== null) {
                $subSelect = $this->_getTableDateRangeSelect(
                    $this->getTable('sales/order'),
                    'created_at', 'updated_at', $from, $to
                );
            } else {
                $subSelect = null;
            }

            $this->_clearTableByDateRange($this->getMainTable(), $from, $to, $subSelect);

            $columns = array(
                // convert dates from UTC to current admin timezone
                'period'                         => "DATE(CONVERT_TZ(o.created_at, '+00:00', '" . $this->_getStoreTimezoneUtcOffset() . "'))",
                'store_id'                       => 'o.store_id',
                'order_status'                   => 'o.status_preorder',
                'orders_count'                   => 'COUNT(o.entity_id)',
                'total_qty_ordered'              => 'SUM(oi.total_qty_ordered)',
                'total_qty_invoiced'             => 'SUM(oi.total_qty_invoiced)',
                'total_income_amount'            => 'SUM((o.base_grand_total - IFNULL(o.base_total_canceled, 0)) * o.base_to_global_rate)',
                'total_revenue_amount'           => 'SUM((o.base_total_paid - IFNULL(o.base_total_refunded, 0)) * o.base_to_global_rate)',
                'total_profit_amount'            => 'SUM((o.base_total_paid - IFNULL(o.base_total_refunded, 0) - IFNULL(o.base_tax_invoiced, 0) - IFNULL(o.base_shipping_invoiced, 0) - IFNULL(o.base_total_invoiced_cost, 0)) * o.base_to_global_rate)',
                'total_invoiced_amount'          => 'SUM(o.base_total_invoiced * o.base_to_global_rate)',
                'total_canceled_amount'          => 'SUM(o.base_total_canceled * o.base_to_global_rate)',
                'total_paid_amount'              => 'SUM(o.base_total_paid * o.base_to_global_rate)',
                'total_refunded_amount'          => 'SUM(o.base_total_refunded * o.base_to_global_rate)',
                'total_tax_amount'               => 'SUM((o.base_tax_amount - IFNULL(o.base_tax_canceled, 0)) * o.base_to_global_rate)',
                'total_tax_amount_actual'        => 'SUM((o.base_tax_invoiced - IFNULL(o.base_tax_refunded, 0)) * o.base_to_global_rate)',
                'total_shipping_amount'          => 'SUM((o.base_shipping_amount - IFNULL(o.base_shipping_canceled, 0)) * o.base_to_global_rate)',
                'total_shipping_amount_actual'   => 'SUM((o.base_shipping_invoiced - IFNULL(o.base_shipping_refunded, 0)) * o.base_to_global_rate)',
                'total_discount_amount'          => 'SUM((ABS(o.base_discount_amount) - IFNULL(o.base_discount_canceled, 0)) * o.base_to_global_rate)',
                'total_discount_amount_actual'   => 'SUM((o.base_discount_invoiced - IFNULL(o.base_discount_refunded, 0)) * o.base_to_global_rate)',
            );

            $select = $this->_getWriteAdapter()->select();
            $selectOrderItem = $this->_getWriteAdapter()->select();

            $cols = array(
                'order_id'           => 'order_id',
                'total_qty_ordered'  => 'SUM(qty_ordered - IFNULL(qty_canceled, 0))',
                'total_qty_invoiced' => 'SUM(qty_invoiced)',
            );
            $selectOrderItem->from($this->getTable('sales/order_item'), $cols)
                ->group('order_id');
            if ($subSelect !== null) {
                //$selectOrderItem->where($this->_makeConditionFromDateRangeSelect($subSelect, 'created_at'));
            }

            $select->from(array('o' => $this->getTable('sales/order')), $columns)
                ->join(array('oi' => $selectOrderItem), 'oi.order_id = o.entity_id', array())
                ->where('o.state NOT IN (?)', array(
                    Mage_Sales_Model_Order::STATE_PENDING_PAYMENT,
                    Mage_Sales_Model_Order::STATE_NEW,
                    Mage_Sales_Model_Order::STATE_CANCELED,
                ));

            if ($subSelect !== null) {
                $select->where($this->_makeConditionFromDateRangeSelect($subSelect, 'o.created_at'));
            }

            $select->group(array(
                'period',
                'store_id',
                'order_status',
            ));

            $this->_getWriteAdapter()->query($select->insertFromSelect($this->getMainTable(), array_keys($columns)));

            // setup all columns to select SUM() except period, store_id and order_status
            foreach ($columns as $k => $v) {
                $columns[$k] = 'SUM(' . $k . ')';
            }
            $columns['period']         = 'period';
            $columns['store_id']       = new Zend_Db_Expr('0');
            $columns['order_status']   = 'order_status';

            $select->reset();
            $select->from($this->getMainTable(), $columns)
                ->where('store_id <> 0');

            if ($subSelect !== null) {
                $select->where($this->_makeConditionFromDateRangeSelect($subSelect, 'period'));
            }

            $select->group(array(
                'period',
                'order_status'
            ));

            $this->_getWriteAdapter()->query($select->insertFromSelect($this->getMainTable(), array_keys($columns)));

            $this->_setFlagData(Mage_Reports_Model_Flag::REPORT_ORDER_FLAG_CODE);
        } catch (Exception $e) {
            $this->_getWriteAdapter()->rollBack();
            throw $e;
        }

        $this->_getWriteAdapter()->commit();
        return $this;
    }
} } 