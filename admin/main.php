<?php

/**
 * Subscription_Change
 *
 * Change customers' AW_Sarp subscription periods
 *
 * @author Reignite Group
 * @version 0.5 - 06/02/2013
*/

class Subscription_Change {

	private $db;
	private $subscriptionID, $subscriptionStatus, $periodType, $flatNextPaymentDate, $flatNextDeliveryDate, $flatDateExpire;
	private $newPeriodType, $newPaymentDate, $newDeliveryDate;

	/** 
	 * _construct
	 *
	 * includes lightweight PDO wrapper class -https://code.google.com/p/edb-php-class/
	 *
	 */
	public function __construct() {
		require('includes/edb.class.php');

		$db_data = array('0ef549e90e0f270df4fa0fb70d424e21f53e78af.rackspaceclouddb.com','94hebi48h48three','QrwFbKSFyA7E','8ehdh84_magentothree');
		$this->db = new edb($db_data);

		echo "<!doctype html>";
		echo "<html lang='en'>";
		echo "<head>";
			echo "<meta charset='UTF-8'>";
			echo "<title>THS | Change Subscription Period Type</title>";
			echo '<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />';
			echo '<link rel="stylesheet" href="includes/styles.css" />';
			echo '<script src="http://code.jquery.com/jquery-1.9.1.js"></script>';
  			echo '<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>';
  			echo '<script src="includes/custom.js"></script>';
		echo "</head>";
		echo "<body>";
		echo "<header></header>";
		echo "<div class='main'>";
				
		// echo "</body>";
		// echo "</html>";
	}

	/**
	 * displayUI
	 *
	 * First check to see if any changes were just submitted to the DB, display results
	 *
	 * Two cases:
	 *  - display all subscriptions
	 *  - display options/form for a specific subscription
	 *
	*/
	public function displayUI() {
		if (isset($_GET["action"]))
		{
			switch($_GET["action"])
			{
				case "apply":
					// apply changes to db
					$this->applyChanges();
					break;
				case "options":
					// display options/form for a specific subscription
					$this->displayOptions();
					break;	
				default:
					// display all subscriptions
					$this->displaySubscriptions();
					break;			
			}
		}
		else
		{
			// display all subscriptions
			$this->displaySubscriptions();
		}

	}

	/**
	 * displaySubscriptions
	 *
	 * Queries aw_sarp_flat_subscriptions, displays drop-down selector containing 
	 * "FIRST LAST - Subscription #:0123456789" for each subscription
	 *
	*/
	private function displaySubscriptions() {

		echo "<h1>Step 1: Choose a Subscription</h1>";

		$result = $this->db->q("select * from un38dj4_aw_sarp_flat_subscriptions");

		if (count($result))
		{
			echo "<form name='step1' method='post' action='main.php?action=options'>";
			echo "<select name='subid' class='display_subscriptions'>";

			foreach($result as $a){

				$sub_id = $a['subscription_id'];
				$name = $a['customer_name'];
				$email = $a['customer_email'];

				echo "<option value='" . $sub_id . "' >" . $sub_id . " | " . $name . " | " . $email . "</option>";
			}

			echo "</select>";

			echo "<input type='submit' value='Select this subscription'>";

			echo "</form>";
		}
		else
		{
			echo "<p>No subscriptions found.</p>";
		}
	}

	/**
	 * displayPeriods
	 *
	 * Queries aw_sarp_subscriptions, displays currently selected period and available period options,
	 * and displays date selector for choosing next payment date
	*/
	private function displayOptions() {
		echo "<h1>Step 2: Change Subscription Settings</h1>";

		//private $subscriptionID, $periodType, $flatNextPaymentDate, $flatNextDeliveryDate, $flatDateExpire;

		if (isset($_POST["subid"]))
		{
			$this->subscriptionID = $_POST["subid"];

			$result = $this->db->q("select * from un38dj4_aw_sarp_subscriptions where id = '{$this->subscriptionID}'");

			$result_customer_info = $this->db->q("select * from un38dj4_aw_sarp_flat_subscriptions where subscription_id = '{$this->subscriptionID}'");

			if (count($result) && count($result_customer_info))
			{
				$this->subscriptionStatus = $result[0]['status'];
				$this->periodType = $result[0]['period_type'];

				$customerName = $result_customer_info[0]['customer_name'];
				$customerEmail = $result_customer_info[0]['customer_email'];
				$productsText = $result_customer_info[0]['products_text'];
				$dateStart = $result[0]['date_start'];
				$nextPaymentDate = $result_customer_info[0]['flat_next_payment_date'];
				$nextDeliveryDate = $result_customer_info[0]['flat_next_delivery_date'];
				$today = date('Y-m-d');

				// echo "Next Payment Date: " . $nextPaymentDate . "<br />";
				// echo "Next estimated ship date: " . $nextDeliveryDate . "<br />";

				$testNPD = date('n/j/y', strtotime($nextPaymentDate));
				$testNDD = date('n/j/y', strtotime($nextDeliveryDate));

				$dateString = $testNDD . " +3 Weekday";
        		$testNDD = date('Y-m-d', strtotime($dateString));

				if ((strtotime($testNPD) > strtotime($testNDD)) && (strtotime($today) < strtotime($testNPD)) && (strtotime($today) < strtotime($testNDD)))
				{
					echo "<p class='specialcasetext'>Special case - customer waiting for subscription shipment they have already been charged for.</p>" . "<p />";
				}

				$dateString = $nextDeliveryDate . " +3 Weekday";
        		$nextDeliveryDate = date('Y-m-d', strtotime($dateString));

				
				$this->displaySubscriptionSummary($this->subscriptionID);


				echo "<form name='step2' method='post' action='main.php?action=apply'>";

				$this->displayPeriodDropdown();

				echo '<p>Bill Date: <input name="newbilldate" type="text" class="datepicker" /></p>';

				//echo '<p>Ship Date: <input name="newshipdate" type="text" class="datepicker" /></p>';


				echo "<input type='submit' value='Update subscription'>";

				echo "<input name='subid' type='hidden' value='{$this->subscriptionID}' />";
				echo "<input name='npd' type='hidden' value='{$testNPD}' />";
				echo "<input name='ndd' type='hidden' value='{$testNDD}' />";

				echo "</form>";
			}
			else
			{
				echo "<p><a href='main.php'>No data was available for this subscription. Please go back and choose another subscription to edit.</a></p>";
			}
		}
		else
		{
			echo "<p><a href='main.php'>No subscription was selected. Please go back and choose a subscription to edit.</a></p>";
		}
	}

	/**
	 * applyChanges
	 *
	 * Updates:
	 *  - aw_sarp_subscriptions: period_type
	 *  - aw_sarp_flat_subscriptions: flat_next_payment_date
	 *  - aw_sarp_flat_subscriptions: flat_next_delivery_date
	 *  
	 * Removes all existing records for subscription in aw_sarp_sequence
	 * Generates new records in aw_sarp_sequence for every billing period through the subscription expiration 
	*/
	private function applyChanges() {
		echo "<h1>Step 3: Apply Changes</h1>";

		$newperiodid = $_REQUEST['periodid'];
		$newbilldate = new DateTime((String)$_REQUEST['newbilldate']);
		$newshipdate = new DateTime((String)$_REQUEST['newbilldate']);
		$subid = $_REQUEST['subid'];

		// Has customer has paid for a subscription shipment and is still waiting for shipment?
		// If so, save scheduled delivery date to original_subscription_delivery
		$testNPD = date('n/j/y', strtotime((String)$_REQUEST['npd']));
		$testNDD = date('n/j/y', strtotime((String)$_REQUEST['ndd']));

		//need to subtract three days from this
		//$insertNDD = date('Y-m-d', strtotime((String)$_REQUEST['ndd']));

		$insertNDD = date('n/j/y', strtotime((String)$_REQUEST['ndd']));
		$dateString = $insertNDD . " -3 Weekday";
        $insertNDD = date('Y-m-d', strtotime($dateString));

        // echo "InsertNDD: " . $insertNDD . "<br />";

		// echo "testNPD: " . $testNPD . "<br />";
		// echo "testNDD: " . $testNDD . "<br />";
		$today = date('Y-m-d');

		if ((strtotime($testNPD) > strtotime($testNDD)) && (strtotime($today) < strtotime($testNPD)) && (strtotime($today) < strtotime($testNDD)))
		{
			$result = $this->db->s("insert into original_subscription_delivery (id, subscription_id, delivery_date) values (NULL, '{$subid}', '{$insertNDD}')");
			if ($result)
			{
				echo "<p class='specialcasetext'>Special case - customer waiting for subscription shipment they have already been charged for." . "<br />";
				echo "Delivery date of current order: " . $testNDD . "</p><p />";
			}
		}

		$result = 0;

		// echo "New ship date (to be inserted): " . $newshipdate->format('Y-m-d') . "<br />";

		// update aw_sarp_subscriptions: period_type
		$result = $this->db->s("update un38dj4_aw_sarp_subscriptions set period_type = '{$newperiodid}' where id = '{$subid}'");
		// echo "Result 1: " . $result;

		// update aw_sarp_flat_subscriptions: flat_next_payment_date
		$result = $this->db->s("update un38dj4_aw_sarp_flat_subscriptions set flat_next_payment_date = '{$newbilldate->format('Y-m-d')}' where `subscription_id` = '{$subid}'");
		// echo "Result 2: " . $result;

		// update aw_sarp_flat_subscriptions: flat_next_delivery_date
		// $troublequery = "update un38dj4_aw_sarp_flat_subscriptions set flat_next_delivery_date = '{$newshipdate->format('Y-m-d')}' where `item_id` = '{$subid}'";
		// echo "Query: " . $troublequery . "<br />";
		$result = $this->db->s("update un38dj4_aw_sarp_flat_subscriptions set flat_next_delivery_date = '{$newshipdate->format('Y-m-d')}' where `subscription_id` = '{$subid}'");
		// echo "Result 3: " . $result;

		// Removes all existing records for subscription in aw_sarp_sequence
		$result = $this->db->s("delete from un38dj4_aw_sarp_sequence where subscription_id='{$subid}'");
		// echo "Result 4: " . $result;

		/**
		 * Add new aw_sarp_sequence records for subscription
		*/ 

		// get number of days of periodicity
		$this->periodType = $newperiodid;
		$pnum = $this->getPeriodNumber();

		// get expiration date
		$result = $this->db->q("select * from un38dj4_aw_sarp_flat_subscriptions where subscription_id = '{$subid}'");

		if (count($result))
		{
			$expireDate = new DateTime($result[0]['flat_date_expire']);
		}

		// while date is less than expiration date, increase by pnum and insert record into aw_sarp_sequence
		$runningDate = $newbilldate;
		$dateString = "+" . $pnum . " days";

		while ($runningDate < $expireDate)
		{
			$result = $this->db->s("insert into un38dj4_aw_sarp_sequence (id, subscription_id, date, status, order_id, attempts_qty) values (NULL, '{$subid}', '{$runningDate->format('Y-m-d')}', 'pending', '0', '0')");
			$runningDate->modify($dateString);
		}

		echo "Subscription successfully changed.";

		$this->subscriptionID = $_POST["subid"];	

		$this->displaySubscriptionSummary($this->subscriptionID);	

		echo "<a href='main.php'>Choose another subscription</a>";

	}

	private function displaySubscriptionSummary($subid) {

		echo "Subscription ID: "  . $subid . "<br />";

		$result = $this->db->q("select * from un38dj4_aw_sarp_subscriptions where id = '{$this->subscriptionID}'");

		$result_customer_info = $this->db->q("select * from un38dj4_aw_sarp_flat_subscriptions where subscription_id = '{$this->subscriptionID}'");

		$result_original_delivery = $this->db->q("select * from original_subscription_delivery where subscription_id = '{$this->subscriptionID}' ORDER BY id DESC LIMIT 1");

		if (count($result) && count($result_customer_info))
		{
			$this->subscriptionStatus = $result[0]['status'];
			$this->periodType = $result[0]['period_type'];

			$customerName = $result_customer_info[0]['customer_name'];
			$customerEmail = $result_customer_info[0]['customer_email'];
			$productsText = $result_customer_info[0]['products_text'];
			$dateStart = $result[0]['date_start'];
			$nextPaymentDate = $result_customer_info[0]['flat_next_payment_date'];
			$nextDeliveryDate = $result_customer_info[0]['flat_next_delivery_date'];
			$dateString = $nextDeliveryDate . " +3 Weekday";
        	$nextDeliveryDate = date('Y-m-d', strtotime($dateString));
			$today = date('Y-m-d');
		}

		$replaceNDD = false;
		if ($result_original_delivery)
		{
			$nddReplacement = $result_original_delivery[0]['delivery_date'];
			$dateString = $nddReplacement . " +3 Weekday";
        	$nddReplacement = date('Y-m-d', strtotime($dateString));

        	if (strtotime($today) < strtotime($nddReplacement))
        	{
        		$replaceNDD = true;
        	}
		}

		echo "<div class='subscription_info'>";
		echo "<p><span class='subscription_info_description'>Customer name:</span><span class='subscription_info_data'>" . $customerName . "</span></p>";
		echo "<p><span class='subscription_info_description'>Customer email:</span><span class='subscription_info_data'>" . $customerEmail . "</span></p>";
		echo "<p><span class='subscription_info_description'>Products in subscription:</span><span class='subscription_info_data'>" . $productsText . "</span></p>";
		echo "<p><span class='subscription_info_description'>Subscription start date:</span><span class='subscription_info_data'>" . $dateStart . "</span></p>";
		
		if (!$replaceNDD)
		{
			echo "<p><span class='subscription_info_description'>Current estimated ship date:</span><span class='subscription_info_data'>" . $nextDeliveryDate . "</span></p>";
			echo "<p><span class='subscription_info_description'>Next payment date:</span><span class='subscription_info_data'>" . $nextPaymentDate . "</span></p>";

		}		
		else
		{
			echo "<p><span class='subscription_info_description'>Current estimated ship date:</span><span class='subscription_info_data'>" . $nddReplacement . "</span></p>";
			echo "<p><span class='subscription_info_description'>Next payment date:</span><span class='subscription_info_data'>" . $nextPaymentDate . "</span></p>";
			echo "<p><span class='subscription_info_description'>Next estimated ship date:</span><span class='subscription_info_data'>" . $nextDeliveryDate . "</span></p>";
		}



		echo "<p><span class='subscription_info_description'>Subscription status:</span><span class='subscription_info_data'>" . $this->subscriptionStatus . " (" . $this->getStatusPlaintext() . ")" . "</span></p>";
		echo "<p><span class='subscription_info_description'>Current period type:</span><span class='subscription_info_data'>" . $this->periodType . " (" . $this->getPeriodPlaintext() . ")" . "</span></p>";
		echo "</div>";
	}

	/**
	 * getStatusPlaintext
	 *
	 * Returns plaintext summary of subscription status
	 *
	 * @return (string) summary of subscription status
	*/
	private function getStatusPlaintext() {
		if ($this->subscriptionStatus)
		{
			switch ($this->subscriptionStatus)
			{
				case "-1":
					return "cancelled";
					break;
				case "1":
					return "active";
					break;
				case "2":
					return "suspended";
					break;
			}
		}
		else
		{
			return "invalid subscription status";
		}
	}

	/**
	 * getPeriodNumber
	 *
	 * Returns number of days of periodicity
	 *
	 * @return (int) number of days
	*/
	private function getPeriodNumber() {
		if ($this->periodType)
		{
			switch ($this->periodType)
			{
				case 1:
					return 30;
					break;
				case 2:
					return 45;
					break;
				case 3:
					return 60;
					break;
				case 4:
					return 90;
					break;
			}
		}
		else
		{
			return 0;
		}

	}

	/**
	 * getPeriodPlaintext
	 *
	 * Returns plaintext summary of period type
	 *
	 * @return (string) summary of period type
	*/
	private function getPeriodPlaintext() {
		if ($this->periodType)
		{
			switch ($this->periodType)
			{
				case 1:
					return "every 30 days";
					break;
				case 2:
					return "every 45 days";
					break;
				case 3:
					return "every 60 days";
					break;
				case 4:
					return "every 90 days";
					break;
			}
		}
		else
		{
			return "invalid period type";
		}

	}

	/**
	 * displayPeriodDropdown
	 *
	 * Displays select box for period types 
	*/
	private function displayPeriodDropdown() {
		$currentPeriod = $this->periodType;

		echo "<label for='periodid'>Change period type: </label>";

		echo "<select name='periodid' class='display_periods'>";

		echo "<option value='1'"; if ($currentPeriod == 1) echo " selected"; echo ">Every 30 Days</option>";
		echo "<option value='2'"; if ($currentPeriod == 2) echo " selected"; echo ">Every 45 Days</option>";
		echo "<option value='3'"; if ($currentPeriod == 3) echo " selected"; echo ">Every 60 Days</option>";
		echo "<option value='4'"; if ($currentPeriod == 4) echo " selected"; echo ">Every 90 Days</option>";

		echo "</select>";
	}

}

/**
 * Execution
*/
// error_reporting(-1);
$scObj = new Subscription_Change();

$scObj->displayUI();

?>
<footer></footer>
</div></body></html>