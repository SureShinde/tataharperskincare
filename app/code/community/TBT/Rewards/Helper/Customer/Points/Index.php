<?php ?>
<?php

/**
 * WDCA - Sweet Tooth
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the WDCA SWEET TOOTH POINTS AND REWARDS 
 * License, which extends the Open Software License (OSL 3.0).

 * The Open Software License is available at this URL: 
 * http://opensource.org/licenses/osl-3.0.php
 * 
 * DISCLAIMER
 * 
 * By adding to, editing, or in any way modifying this code, WDCA is 
 * not held liable for any inconsistencies or abnormalities in the 
 * behaviour of this code. 
 * By adding to, editing, or in any way modifying this code, the Licensee
 * terminates any agreement of support offered by WDCA, outlined in the 
 * provided Sweet Tooth License. 
 * Upon discovery of modified code in the process of support, the Licensee 
 * is still held accountable for any and all billable time WDCA spent 
 * during the support process.
 * WDCA does not guarantee compatibility with any other framework extension. 
 * WDCA is not responsbile for any inconsistencies or abnormalities in the
 * behaviour of this code if caused by other framework extension.
 * If you did not receive a copy of the license, please send an email to 
 * support@sweettoothrewards.com or call 1.855.699.9322, so we can send you a copy 
 * immediately.
 * 
 * @category   [TBT]
 * @package    [TBT_Rewards]
 * @copyright  Copyright (c) 2014 Sweet Tooth Inc. (http://www.sweettoothrewards.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Helper for the customer points index
 *
 * @category   TBT
 * @package    TBT_Rewards
 * * @author     Sweet Tooth Inc. <support@sweettoothrewards.com>
 */
class TBT_Rewards_Helper_Customer_Points_Index extends Mage_Core_Helper_Abstract {
	
    /**
     * @return true if the customer points balance index is up-to-date
     */
    public function isUpToDate() {
        $collection = Mage::getModel('index/process')->getCollection();
        $collection->addFieldToFilter('indexer_code', 'rewards_transfer');
        $points_index = $collection->getFirstItem();
        $index_status = $points_index->getStatus();
         
        $is_pending_status = ($index_status == Mage_Index_Model_Process::STATUS_PENDING);
        
        return $is_pending_status;
    }

    /**
     * @return true if you should use the customer points index to get the customer points balance
     */
    public function useIndex() {
        if(!$this->canIndex()) return false;
        
        $is_up_to_date = $this->isUpToDate();
        return $is_up_to_date;
    }
    
    /**
     * @return true if this store supports the index system (IE magento 1.4 +)
     */
    public function canIndex() {
        $is_mage_14_and_up = Mage::helper('rewards/version')->isBaseMageVersionAtLeast('1.4.0.0');
        return $is_mage_14_and_up;
    }
    
    /**
     * Finds the indexer that is associated with the customer points balance and invalidates it (requires reindex status)
     * @return $this
     */
    public function invalidate() {
        if(!$this->canIndex()) {
            return $this;
        }
        
        $all_indexes = Mage::getModel('index/process')->getCollection()->addFieldToFilter('indexer_code', 'rewards_transfer');
        $index = $all_indexes->getFirstItem();
        
        if($index) {
            $index->changeStatus ( Mage_Index_Model_Process::STATUS_REQUIRE_REINDEX );
        }
        return $this;
    }
    
    /**
     * disable indexer because of an error
     * @return $this
     */
    public function error() {
        if(!$this->canIndex()) {
            return $this;
        }
        
        $all_indexes = Mage::getModel('index/process')->getCollection()->addFieldToFilter('indexer_code', 'rewards_transfer');
        $index = $all_indexes->getFirstItem();
        
        if($index) {
            $index->changeStatus ( Mage_Index_Model_Process::EVENT_STATUS_ERROR );
            $index->setMode( Mage_Index_Model_Process::MODE_MANUAL );
            $index->save();
        }
        return $this;
    }
    
    
}
