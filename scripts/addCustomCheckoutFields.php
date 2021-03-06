<?php
require_once '../app/Mage.php';
umask(0);
Mage::app('default');
// Add the code you want to execute here:
$c = array (
  'entity_type_id'  => 5,         // 11 is the id of the entity model "sales/order". This could be different on your system! Look at database-table "eav_entity_type" for the correct ID!
  'attribute_code'  => 'myorder_customercomment',
  'backend_type'    => 'text',     // MySQL-DataType
  'frontend_input'  => 'textarea', // Type of the HTML-Form-Field
  'is_global'       => '1',
  'is_visible'      => '1',
  'is_required'     => '0',
  'is_user_defined' => '0',
  'frontend_label'  => 'Comments',
);
$attribute = new Mage_Eav_Model_Entity_Attribute();
$attribute->loadByCode($c['entity_type_id'], $c['attribute_code'])
          ->setStoreId(2)
          ->addData($c);
$attribute->save();

echo "Success!";
?>