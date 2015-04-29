<?php

require_once("../app/Mage.php");

Mage::app();

if ($_POST['prodid'])
	$prod = $_POST['prodid'];
else
	$prod = 127;

$formKey = Mage::getSingleton('core/session')->getFormKey();


$params = array(
    'product' => $prod,
    'super_attribute' => array(
        216 =>30 ,
    ),
    'qty' => 1,
    'form_key' => $formKey,
);


$cart = Mage::getSingleton('checkout/cart'); 
$product = new Mage_Catalog_Model_Product();
$product->load($prod); 
$cart->addProduct($product, $params);
$cart->save(); 
Mage::getSingleton('checkout/session')->setCartWasUpdated(true);