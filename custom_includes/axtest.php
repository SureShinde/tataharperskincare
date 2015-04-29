<?php

    require_once("../app/Mage.php");

    Mage::app();

    $order = Mage::getModel('sales/order')->load(2933);
	$message = Mage::getModel('giftmessage/message');

    $gift_message_id = $order->getGiftMessageId();

    if(!is_null($gift_message_id)) {

        $message->load((int)$gift_message_id);
        echo $gift_sender = $message->getData('sender');
        echo $gift_recipient = $message->getData('recipient');
        echo $gift_message = $message->getData('message');
    }

