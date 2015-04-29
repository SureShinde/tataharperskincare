<?php
    //External script - Load magento framework
    require_once("../includes/mailchimp/MCAPI.class.php");
    require_once("../includes/mailchimp/config.inc.php"); //contains apikey

    $api = new MCAPI($apikey);

    $email = $_POST['email'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $age = $_POST['age'];
    if (isset($_POST['signup']))
        $signup = true;
    else
        $signup = false;

    if (isset($_POST['agree']))
        $agree = true;
    else
        $agree = false;

    if (is_null($fname))
        $fname = "";
    if (is_null($lname))
        $lname = "";
    if (is_null($city))
        $city = "";
    if (is_null($state))
        $state = "";
    if (is_null($age))
        $age = "";

    /* 
     * MailChimp List Groupings Integration
    */

    // $merge_vars = array(
    //     'GROUPINGS'=>array(
    //             array('name' => 'Blog Contests', 'groups' => 'roost-aug-13'),
    //     )
    // );

    if ($agree) {

        if ($signup) {
            $listId = 'fd6235a77e'; // "Summer Radiance Sweeps - New Names"

            $merge_vars = array('FNAME'=>$fname, 'LNAME'=>$lname, 'CITY'=>$city, 'STATE'=>$state, 'AGE'=>$age, 'SIGNUP'=>'TRUE');

            $retval = $api->listSubscribe($listId, $email, $merge_vars, "html", false); // if using Groupings
             // $retval = $api->listSubscribe($listId, $email);

            if ($api->errorCode){
                echo "You've already joined the Sweepstakes!";
            } 
            else {
                echo "You have successfully entered the Summer Sweepstakes!\n";
            }  
        } else {
            $listId = 'fd6235a77e'; // "Summer Radiance Sweeps - New Names"

            $merge_vars = array('FNAME'=>$fname, 'LNAME'=>$lname, 'CITY'=>$city, 'STATE'=>$state, 'AGE'=>$age, 'SIGNUP'=>'FALSE');

            $retval = $api->listSubscribe($listId, $email, $merge_vars, "html", false); // if using Groupings
             // $retval = $api->listSubscribe($listId, $email);

            if ($api->errorCode){
                echo "You're already joined the Sweepstakes!";
            } 
            else {
                echo "You have successfully entered the Summer Sweepstakes!\n";
            }  
        }
           
    } else {
        echo "Please check the 'I agree to the sweepstakes terms and conditions' checkbox!";
    }
      
?>