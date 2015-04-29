<?php

require_once('../app/Mage.php');
Mage::app();

// attribute code
$attribute_code = 'recurly_type';

$productModel = Mage::getModel('catalog/product'); 

// load attribute by attribute code
$attribute = $productModel->getResource()->getAttribute($attribute_code);

echo "<pre>";
var_dump($attribute);
echo "</pre>";

if ($attribute->usesSource()) {
echo $color_id = $attribute->getSource()->getOptionId("One-Time Purchas");
}

// // load product by sku 
// $product = $productModel->loadByAttribute('sku', 'mysku');

// // Validate attribute
// if ($attribute->usesSource()) { 
//     // load option Id by value text
//     $attribute_value_id = $attribute->getSource()->getOptionId('myatttext'); 

//     // update product attribute
//     $product->addAttributeUpdate($attribute_code, $attribute_value_id);

//     echo $product->getAttributeText($attribute_code);
// }