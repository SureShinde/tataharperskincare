<?php
require_once('lib/recurly.php');

// Required for the API
Recurly_Client::$subdomain = 'tata-harper-skincare';
Recurly_Client::$apiKey = '81b3d8d9efc449e189af7f5053b880b2';

$accounts = Recurly_AccountList::getActive('active');
foreach ($accounts as $account) {
  echo $account->first_name . " " . $account->last_name . ", " . $account->email . "<br />";
}


?>