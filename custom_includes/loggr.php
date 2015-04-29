<?php
    //External script - Load magento framework
    require_once("../app/Mage.php");

    Mage::app();

    $loggr = new Loggr_Loggr("ths_replenishment", "8dd3d3d6488d45808d78a34eba08996c");

    $success = $loggr->Events->Create()
    ->Text("Simple fluent event")
    ->Post();

    echo "hw2" . $success;