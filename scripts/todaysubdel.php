<?php 
	require_once('../app/Mage.php');
	Mage::app();

    echo "Hai";

	$collection = Mage::getModel('sarp/subscription')
        ->getCollection()
        ->addActiveFilter()
        ->addTodayFilter();

    foreach ($collection as $Subscription)
    {
    	echo "Subscription ID: " . $Subscription->getId() . "<br />";
    }

	// echo '<pre>';
	// var_dump($collection);
	// echo '</pre>';

