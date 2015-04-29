<?php ?>
<?php

/*
 * AX 4.12.13
 * Import reviews from original WP site
 * http://www.magentocommerce.com/boards/viewthread/231920/
 * http://stackoverflow.com/questions/12255463/how-to-import-product-reviews-into-magento
 * Future reference - adding custom fields to review form: http://stackoverflow.com/questions/8909185/magento-add-a-custom-field-in-review-form
 */

function parseFile()
{
	require_once('app/Mage.php');
	Mage::app();

	$file = fopen('import4.csv', "r");

	$rownames = fgetcsv($file); // skip this line

	$info = array();

	while (($data = fgetcsv($file)) !== FALSE) {

		$info['nickname'] = $data[0];
		$info['title'] = $data[2];
		$info['detail'] = $data[3];
		$info['rating'] = $data[4];
		$info['productid'] = $data[5];
		$info['location'] = $data[6];	

		$_review = Mage::getModel('review/review')
		    ->setEntityPkValue($info['productid'])
		    ->setStatusId(1)
		    ->setTitle($info['title'])
		    ->setDetail($info['detail'])
		    ->setLocation($info['location'])
		    ->setEntityId(1)
		    ->setStoreId(2)
		    ->setStores(array(0, 2))
		    ->setCustomerId(1)
		    ->setNickname($info['nickname'])
		    ->save();
		 
		 /*
		 if ($info['rating'] != 0)
		 {
		     $_rating = Mage::getModel('rating/rating')
	            ->setRatingId(3)
	            ->setReviewId($_review->getId())
	            ->setCustomerId(1)
	            ->addOptionVote($info['rating'], $info['productid']);
	     }
         */
	}

	echo "hello world";


}

parseFile();

?>
