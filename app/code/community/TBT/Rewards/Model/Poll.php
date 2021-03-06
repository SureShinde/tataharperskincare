<?php

/**
 * WDCA - Sweet Tooth
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the WDCA SWEET TOOTH POINTS AND REWARDS
 * License, which extends the Open Software License (OSL 3.0).
 * The Sweet Tooth License is available at this URL:
 * https://www.sweettoothrewards.com/terms-of-service
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
 * Poll
 *
 * @category   TBT
 * @package    TBT_Rewards
 * * @author     Sweet Tooth Inc. <support@sweettoothrewards.com>
 * @deprecated from version 1.7.6.3+
 */
class TBT_Rewards_Model_Poll extends Mage_Poll_Model_Poll {

	public function addVote(Mage_Poll_Model_Poll_Vote $vote) {
		if (Mage::getModel ( 'customer/session' )->getCustomerId ()) {
			$ruleCollection = Mage::getSingleton ( 'rewards/special_validator' )->getApplicableRulesOnPoll ();

			$hasRecievedPoints = false;

			//Grab all the newsletter point transfers dealing with this customer
			$transferCollection = Mage::getModel ( 'rewards/transfer' )->getTransfersAssociatedWithPoll ( $this->getId () );
			foreach ( $transferCollection as $transfer ) {
				if ($transfer->getCustomerId () == Mage::getModel ( 'customer/session' )->getCustomerId ()) {
					$revokedTransfers = Mage::getModel ( 'rewards/transfer' )->getTransfersAssociatedWithTransfer ( $transfer->getId () );
					//If there are no revoked transfers, then the customer has already recieved points for this newsletter
					//And therefore should not get anymore
					if ($revokedTransfers->getSize () == 0) {
						$hasRecievedPoints = true;
					}
				}
			}

			if (! $hasRecievedPoints) {
				Mage::dispatchEvent ( 'rewards_poll_new_vote', array ('poll' => &$this ) );
				foreach ( $ruleCollection as $rule ) {
					if (! $rule->getId ()) {
						continue;
					}

					try {
						//Create the transfer
						$is_transfer_successful = Mage::helper ( 'rewards/transfer' )->transferPollPoints ( $rule->getPointsAmount (), $rule->getPointsCurrencyId (), $this->getId (), $rule->getId () );
					} catch ( Exception $ex ) {
						Mage::getSingleton ( 'core/session' )->addError ( $ex->getMessage () );
					}

					if ($is_transfer_successful) {
						//Alert the customer on the distributed points
						Mage::getSingleton ( 'core/session' )->addSuccess ( Mage::helper ( 'rewards' )->__ ( 'You received %s for voting', (string)Mage::getModel ( 'rewards/points' )->set ( $rule ) ) );
					}
				}
			}
		}

		return parent::addVote ( $vote );
	}

}

?>