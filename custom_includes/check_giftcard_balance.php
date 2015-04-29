<?php

require_once("../app/Mage.php");

Mage::app();

$code = (String)$_POST['gift-card-code'];

// echo $code;	

/**
 * Get the resource model
 */
$resource = Mage::getSingleton('core/resource');
$link = mysqli_connect("0ef549e90e0f270df4fa0fb70d424e21f53e78af.rackspaceclouddb.com", "94hebi48h48three", "QrwFbKSFyA7E", "8ehdh84_magentothree");

$queryCode = mysqli_real_escape_string($link, $code);


 
/**
 * Retrieve the read connection
 */
$readConnection = $resource->getConnection('core_read');
 
$query = 'SELECT balance FROM un38dj4_giftvoucher WHERE gift_code = "' . (String)$queryCode . '" LIMIT 1';
 
/**
 * Execute the query and store the results in $results
 */
$balance = $readConnection->fetchOne($query);
 
/**
 * Print out the results
 */

$loggr = new Loggr_Loggr("ths_replenishment", "8dd3d3d6488d45808d78a34eba08996c");

// $loggr->Events->CreateFromVariable($code)
//     ->Text("Gift card - original code")
//     ->Post();

if ($balance)
	echo 'Balance: $' . number_format($balance, 2);
else
	echo 'Please enter a valid gift card code.';