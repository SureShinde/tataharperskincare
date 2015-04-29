<?php
    //External script - Load magento framework
    require_once("../includes/mailchimp/MCAPI.class.php");
    require_once("../includes/mailchimp/config.inc.php"); //contains apikey

    $api = new MCAPI($apikey);

    $email = $_POST['email'];

    // echo "Email: " . $email;

    $retval = $api->listSubscribe($listId, $email);

    if ($api->errorCode){
        echo "You're already subscribed to this list!";
        // echo "Unable to load listSubscribe()!\n";
        // echo "\tCode=".$api->errorCode."\n";
        // echo "\tMsg=".$api->errorMessage."\n";
    } 
     else {
        echo "Successfully subscribed - look for the confirmation email!\n";
     }        
?>