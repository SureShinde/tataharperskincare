<?php ?>
<?php

$con=mysqli_connect("0ef549e90e0f270df4fa0fb70d424e21f53e78af.rackspaceclouddb.com","94hebi48h48","bVXXYQ3E2hwpSTHu","8ehdh84_magento");
$result = mysqli_query($con, "SELECT * FROM un38dj4_review");
// printf("Select returned %d rows.\n", mysqli_num_rows($result));
// echo "<br />";

$newids = array();
$oldids = array();

while($row = mysqli_fetch_array($result))
{
	//echo "Original review ID: " . $row["review_id"] . "<br />";
	$oldids[] = $row["review_id"];
}

$newids = array_reverse($oldids);
$count = 9872;

foreach ($oldids as $key => $value) {

	$oldid = $value;
	$newid = $newids[$key];

	// $result = mysqli_query($con, "UPDATE un38dj4_review set review_id = $newid WHERE review_id = $oldid");
	// $result = "UPDATE un38dj4_review set new_id = $newid WHERE review_id = $oldid;";
	$result = "UPDATE un38dj4_review set review_id = $count WHERE review_id = $oldid;";
	echo $result . "<br />";
	$count++;
}

echo "hell yeah";
?>
