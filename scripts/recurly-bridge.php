<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

set_time_limit(0);
ignore_user_abort(1);

/*
 * AX 12.1.14
 * Recurly Bridge
*/

require_once('/root/www/htdocs/www.tataharperskincare.com/app/Mage.php');
Mage::app();

require_once(Mage::getBaseDir('lib') . '/Recurly/recurly.php');

Recurly_Client::$subdomain = 'tata-harper-skincare';
Recurly_Client::$apiKey = '81b3d8d9efc449e189af7f5053b880b2';

$transactions = Recurly_TransactionList::get(array('state' => 'successful', 'type' => 'purchase'));

$resource = Mage::getSingleton('core/resource');
$writeConnection = $resource->getConnection('core_write');

foreach ($transactions as $transaction) {
    if (strtotime($transaction->created_at->format('Y-m-d H:i:s')) >= strtotime('-3 day')) {

        $subscription = $transaction->subscription->get();
        $account = $subscription->account->get();

        $firstName = $account->first_name;
        $lastName = $account->last_name;
        $email = $account->email;
        
        $plan = $subscription->plan->plan_code;
        $period = substr($plan, -2);
        $sku = substr($plan, 0, -3); // first half
        $sku .= "-S" . $period; // second half

        $accountCode = $account->account_code;

        $address['address1'] = $account->address->address1;
        $address['address2'] = $account->address->address2;
        $address['city'] = $account->address->city;
        $address['state'] = $account->address->state;
        $address['zip'] = $account->address->zip;
        $address['country'] = $account->address->country;
        $address['phone'] = $account->address->phone;

        if (strlen($address['state']) != 2 && $address['country'] == 'US') {
            $address['state'] = getStateAbbr($address['state']);
        }

        if ($address['country'] == 'US') {
             $region = Mage::getModel('directory/region')->loadByCode($address['state'], 'US');
             $address['region_id'] = $region->getId(); //12

             try {

                $billingInfo = Recurly_BillingInfo::get($accountCode);
                $cardType = $billingInfo->card_type;

                // Check to see if transaction already imported into Magento

                $table = 'recurly_bridge';
                $query = 'SELECT uuid FROM ' . $table . ' WHERE uuid="' .   $transaction->uuid . '" LIMIT 1';

                $alreadyimported = $writeConnection->fetchOne($query);

                if (!$alreadyimported)  {

                    // echo "Not imported yet: " . $lastName . " " . $sku . "<br />";

                    createOrder($email, $sku, $firstName, $lastName, $address, $cardType);

                    $sql = "INSERT INTO recurly_bridge (uuid) VALUES ('" . $transaction->uuid . "')";
                    $add = $writeConnection->query($sql);
                }
                // else {
                //     echo "Already imported: " . $lastName . " " . $sku . "<br />";

                // }

            } catch (Recurly_NotFoundError $e) {
                print "No billing information.\n";
            }

        } else {
            $message = "Recurly - Email: " . $email . ", Plan: " . $plan; 
            // echo "Sending message";
            $headers = 'From: anthony@reignitegroup.com' . "\r\n" .
           'Reply-To: anthony@reignitegroup.com' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();
            mail ("vanessa@tataharper.com " , "Order did not get imported to Magento" , $message, $headers);
            // echo "Sent message";
        }    
        
    }
}

function getStateAbbr($state) {

    $states = array(
        'Alabama'=>'AL',
        'Alaska'=>'AK',
        'Arizona'=>'AZ',
        'Arkansas'=>'AR',
        'California'=>'CA',
        'Colorado'=>'CO',
        'Connecticut'=>'CT',
        'Delaware'=>'DE',
        'Florida'=>'FL',
        'Georgia'=>'GA',
        'Hawaii'=>'HI',
        'Idaho'=>'ID',
        'Illinois'=>'IL',
        'Indiana'=>'IN',
        'Iowa'=>'IA',
        'Kansas'=>'KS',
        'Kentucky'=>'KY',
        'Louisiana'=>'LA',
        'Maine'=>'ME',
        'Maryland'=>'MD',
        'Massachusetts'=>'MA',
        'Michigan'=>'MI',
        'Minnesota'=>'MN',
        'Mississippi'=>'MS',
        'Missouri'=>'MO',
        'Montana'=>'MT',
        'Nebraska'=>'NE',
        'Nevada'=>'NV',
        'New Hampshire'=>'NH',
        'New Jersey'=>'NJ',
        'New Mexico'=>'NM',
        'New York'=>'NY',
        'North Carolina'=>'NC',
        'North Dakota'=>'ND',
        'Ohio'=>'OH',
        'Oklahoma'=>'OK',
        'Oregon'=>'OR',
        'Pennsylvania'=>'PA',
        'Rhode Island'=>'RI',
        'South Carolina'=>'SC',
        'South Dakota'=>'SD',
        'Tennessee'=>'TN',
        'Texas'=>'TX',
        'Utah'=>'UT',
        'Vermont'=>'VT',
        'Virginia'=>'VA',
        'Washington'=>'WA',
        'West Virginia'=>'WV',
        'Wisconsin'=>'WI',
        'Wyoming'=>'WY'
    );

    return $states[$state];
}

function createOrder($email, $sku, $firstName, $lastName, $address, $cardType) {

    $quote = Mage::getModel('sales/quote')
    ->setStoreId(2);

    $customer = Mage::getModel('customer/customer')
        ->setWebsiteId(1)
        ->loadByEmail($email);
    
    $quote->assignCustomer($customer);

    $product_id = Mage::getModel("catalog/product")->getIdBySku($sku);

    $product = Mage::getModel('catalog/product')->load($product_id);

    $buyInfo = array(
        'qty' => 1,
    );
    $quote->addProduct($product, new Varien_Object($buyInfo));

    echo "Product ID: " . $product_id . "<br />";

    $addressData = array(
        'firstname' => $firstName,
        'lastname' => $lastName,
        'street' => $address['address1'],
        'city' => $address['city'],
        'postcode'=>$address['zip'],
        'telephone' => $address['phone'],
        'country_id' => $address['country'],
        'region_id' => $address['region_id']
    );

    //Add address array to both billing AND shipping address objects.   
    $billingAddress = $quote->getBillingAddress()->addData($addressData);
    $shippingAddress = $quote->getShippingAddress()->addData($addressData);
    $quote->getShippingAddress()->setFreeShipping(true);

    $shippingAddress->setCollectShippingRates(true)->collectShippingRates()
        ->setShippingMethod('flatrate_flatrate');

    $quote->getPayment()->importData(array('method' => 'checkmo'));
    $quote->getShippingAddress()->setFreeShipping(true);
    $quote->setCouponCode('RECURLYIMPORT'); 
    $quote->collectTotals()->save();

    $service = Mage::getModel('sales/service_quote', $quote);
    $service->submitAll();
    $order = $service->getOrder();
    $order->addStatusHistoryComment('Card type: ' . $cardType);
    $order->save();

    printf("Created order %s\n", $order->getIncrementId());
}