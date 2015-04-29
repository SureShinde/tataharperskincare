<?php
    //External script - Load magento framework
    require_once("../includes/mailchimp/MCAPI.class.php");
    require_once("../includes/mailchimp/config.inc.php"); //contains apikey

    $api = new MCAPI($apikey);

    $email = $_POST['email'];

    // $first = "N/A";
    // $last = "N/A";
    // $age = "N/A";
    // $state = "N/A";

    if (isset($_POST['first']))
        $first = $_POST['first'];
    if (isset($_POST['last']))
        $last = $_POST['last'];
    if (isset($_POST['age']))
        $age = $_POST['age'];
    if (isset($_POST['state']))
        $state = $_POST['state'];

     $merge_vars = array(
        'FNAME' => $first,
        'LNAME' => $last,
        'AGE' => $age,
        'STATE' => $state
    );


    /* 
     * MailChimp List Groupings Integration
    */

    // $merge_vars = array(
    //     'GROUPINGS'=>array(
    //             array('name' => 'Blog Contests', 'groups' => 'roost-aug-13'),
    //     )
    // );

    $listId = 'd21c6fbaf1'; // "PROGRAM COUNTDOWN"

    $retval = $api->listSubscribe($listId, $email, $merge_vars);

    if ($api->errorCode){
        echo "You're already subscribed to this list!";
    } 
    else {
        echo "Successfully subscribed - look for the confirmation email!\n";
    }        
?>