<?php
/**
 * Product:     Pre-Orders for Enterprise Edition
 * Package:     Aitoc_Aitpreorder_10.0.29_558126
 * Purchase ID: 4VeYRNtXAYgEBUi2AVhbBxqctMqGCT8h6O0060qvS6
 * Generated:   2013-04-23 21:46:41
 * File path:   app/code/local/Aitoc/Aitpreorder/Model/Sales/Mysql4/Report/Refunded/1900.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ AfTdkeYDcMghuoeC('fc95ff36d4d64c293b0843cc4ca9bddf'); ?><?php
/**
 * @copyright  Copyright (c) 2009 AITOC, Inc. 
 */
class Aitoc_Aitpreorder_Model_Sales_Mysql4_Report_Refunded_1900 extends Mage_Sales_Model_Mysql4_Report_Refunded
{
    protected function _aggregateByOrderCreatedAt($from, $to)
    {
        $table = $this->getTable('sales/refunded_aggregated_order');
        $sourceTable = $this->getTable('sales/order');
        $this->_getWriteAdapter()->beginTransaction();

        try {
            if ($from !== null || $to !== null) {
                $subSelect = $this->_getTableDateRangeSelect($sourceTable, 'created_at', 'updated_at', $from, $to);
            } else {
                $subSelect = null;
            }

            $this->_clearTableByDateRange($table, $from, $to, $subSelect);

            $columns = array(
                // convert dates from UTC to current admin timezone
                'period'            => "DATE(CONVERT_TZ(created_at, '+00:00', '" . $this->_getStoreTimezoneUtcOffset() . "'))",
                'store_id'          => 'store_id',
                'order_status'      => 'status_preorder',
                'orders_count'      => 'COUNT(`total_refunded`)',
                'refunded'          => 'SUM(`base_total_refunded` * `base_to_global_rate`)',
                'online_refunded'   => 'SUM(`base_total_online_refunded` * `base_to_global_rate`)',
                'offline_refunded'  => 'SUM(`base_total_offline_refunded` * `base_to_global_rate`)'
            );

            $select = $this->_getWriteAdapter()->select();
            $select->from($sourceTable, $columns)
                ->where('state <> ?', Mage_Sales_Model_Order::STATE_CANCELED)
                ->where('base_total_refunded > 0');

            if ($subSelect !== null) {
                $select->where($this->_makeConditionFromDateRangeSelect($subSelect, 'created_at'));
            }

            $select->group(array(
                'period',
                'store_id',
                'order_status'
            ));

            $select->having('orders_count > 0');

            $this->_getWriteAdapter()->query($select->insertFromSelect($table, array_keys($columns)));

            $select->reset();

            $columns = array(
                'period'            => 'period',
                'store_id'          => new Zend_Db_Expr('0'),
                'order_status'      => 'order_status',
                'orders_count'      => 'SUM(orders_count)',
                'refunded'          => 'SUM(refunded)',
                'online_refunded'   => 'SUM(online_refunded)',
                'offline_refunded'  => 'SUM(offline_refunded)'
            );

            $select
                ->from($table, $columns)
                ->where('store_id <> 0');

            if ($subSelect !== null) {
                $select->where($this->_makeConditionFromDateRangeSelect($subSelect, 'period'));
            }

            $select->group(array(
                'period',
                'order_status'
            ));

            $this->_getWriteAdapter()->query($select->insertFromSelect($table, array_keys($columns)));
        } catch (Exception $e) {
            $this->_getWriteAdapter()->rollBack();
            throw $e;
        }

        $this->_getWriteAdapter()->commit();
        return $this;
    }

    /**
     * Aggregate refunded data by creaditmemo created at as period
     *
     * @param mixed $from
     * @param mixed $to
     * @return Mage_Sales_Model_Mysql4_Report_Refunded
     */
    protected function _aggregateByRefundCreatedAt($from, $to)
    {
        $table = $this->getTable('sales/refunded_aggregated');
        $sourceTable = $this->getTable('sales/creditmemo');
        $orderTable = $this->getTable('sales/order');
        $this->_getWriteAdapter()->beginTransaction();

        try {
            if ($from !== null || $to !== null) {
                $subSelect = $this->_getTableDateRangeRelatedSelect(
                    $sourceTable, $orderTable, array('order_id'=>'entity_id'),
                    'created_at', 'updated_at', $from, $to
                );
            } else {
                $subSelect = null;
            }

            $this->_clearTableByDateRange($table, $from, $to, $subSelect);

            $columns = array(
                // convert dates from UTC to current admin timezone
                'period'            => "DATE(CONVERT_TZ(source_table.created_at, '+00:00', '" . $this->_getStoreTimezoneUtcOffset() . "'))",
                'store_id'          => 'order_table.store_id',
                'order_status'      => 'order_table.status_preorder',
                'orders_count'      => 'COUNT(order_table.`entity_id`)',
                'refunded'          => 'SUM(order_table.`base_total_refunded` * order_table.`base_to_global_rate`)',
                'online_refunded'   => 'SUM(order_table.`base_total_online_refunded` * order_table.`base_to_global_rate`)',
                'offline_refunded'  => 'SUM(order_table.`base_total_offline_refunded` * order_table.`base_to_global_rate`)'
            );

            $select = $this->_getWriteAdapter()->select();
            $select->from(array('source_table' => $sourceTable), $columns)
                ->joinInner(
                    array('order_table' => $orderTable),
                    $this->_getWriteAdapter()->quoteInto(
                        'source_table.order_id = order_table.entity_id AND order_table.state <> ? AND order_table.base_total_refunded > 0',
                        Mage_Sales_Model_Order::STATE_CANCELED),
                    array()
                );

            $filterSubSelect = $this->_getWriteAdapter()->select();
            $filterSubSelect->from(array('filter_source_table' => $sourceTable), 'MAX(filter_source_table.entity_id)')
                ->where('filter_source_table.order_id = source_table.order_id');

            if ($subSelect !== null) {
                $select->where($this->_makeConditionFromDateRangeSelect($subSelect, 'source_table.created_at'));
            }

            $select->where('source_table.entity_id = (?)', new Zend_Db_Expr($filterSubSelect));
            unset($filterSubSelect);

            $select->group(array(
                'period',
                'store_id',
                'order_status'
            ));

            $select->having('orders_count > 0');

            $this->_getWriteAdapter()->query($select->insertFromSelect($table, array_keys($columns)));

            $select->reset();

            $columns = array(
                'period'            => 'period',
                'store_id'          => new Zend_Db_Expr('0'),
                'order_status'      => 'order_status',
                'orders_count'      => 'SUM(orders_count)',
                'refunded'          => 'SUM(refunded)',
                'online_refunded'   => 'SUM(online_refunded)',
                'offline_refunded'  => 'SUM(offline_refunded)'
            );

            $select
                ->from($table, $columns)
                ->where('store_id <> 0');

            if ($subSelect !== null) {
                $select->where($this->_makeConditionFromDateRangeSelect($subSelect, 'period'));
            }

            $select->group(array(
                'period',
                'order_status'
            ));

            $this->_getWriteAdapter()->query($select->insertFromSelect($table, array_keys($columns)));
        } catch (Exception $e) {
            $this->_getWriteAdapter()->rollBack();
            throw $e;
        }
        $this->_getWriteAdapter()->commit();
        return $this;
    } 
} } 