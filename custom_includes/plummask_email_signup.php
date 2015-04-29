<?php
    //External script - Load magento framework
    require_once("../includes/mailchimp/MCAPI.class.php");
    require_once("../includes/mailchimp/config.inc.php"); //contains apikey

    $api = new MCAPI($apikey);

    $email = $_POST['email'];

    // $merge_vars = array(
    //     'GROUPINGS'=>array(
    //             array('name' => 'Blog Contests', 'groups' => 'roost-aug-13'),
    //     )
    // );

    $listId = '59e40ef268';

    // $retval = $api->listSubscribe($listId, $email, $merge_vars);
     $retval = $api->listSubscribe($listId, $email);

    if ($api->errorCode){
        echo "You're already subscribed to this list!";
    } 
    else {
        echo "Successfully subscribed - look for the confirmation email!\n";
    }        
?>