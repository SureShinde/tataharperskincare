<?php
    //External script - Load magento framework
    require_once("../app/Mage.php");
    require_once("../includes/mailchimp/MCAPI.class.php");
    require_once("../includes/mailchimp/config.inc.php"); //contains apikey

    Mage::app();

    $time = time();
    $to = date('Y-m-d H:i:s', $time);
    $lastTime = $time - 3600;
    $from = date('Y-m-d H:i:s', $lastTime);

    $myOrder=Mage::getModel('sales/order'); 
    $orders=Mage::getModel('sales/mysql4_order_collection')
        ->addAttributeToSelect('created_at')
        ->addAttributeToFilter('created_at', array('from' => $from, 'to' => $to))
        ->load();
    $allIds=$orders->getAllIds();

    $api = new MCAPI($apikey);

    foreach($allIds as $thisId) {
        $myOrder->load($thisId);

        $fullname = $myOrder->getCustomerName();
        $name = explode(" ", $fullname);

        $shipping = $myOrder->getShippingAddress();
        $region = $shipping->getRegion();

        $first = $name[0];
        $last = $name[1];

        //echo "first: " . $first . "; last: " . $last . "<br />";

        $email = $myOrder->getCustomerEmail();
        $subscribe = $myOrder->getSubscribe();

        // add mailchimp connection here
        $merge_vars = array('NAME'=>$fullname, 'STATE'=>$region, 'FNAME'=>$first, 'LNAME'=>$last);

        if ($subscribe)
        {
            $retval = $api->listSubscribe($listId, $email, $merge_vars);

            if ($api->errorCode){
                echo "Unable to load listSubscribe()!\n";
                echo "\tCode=".$api->errorCode."\n";
                echo "\tMsg=".$api->errorMessage."\n";
            } else {
                echo "Subscribed - look for the confirmation email!\n";
            }
        } 
    }
?>