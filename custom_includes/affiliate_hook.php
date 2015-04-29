<?php

$email = $_POST['email'];

$con=mysqli_connect("0ef549e90e0f270df4fa0fb70d424e21f53e78af.rackspaceclouddb.com","94hebi48h48three","QrwFbKSFyA7E","8ehdh84_magentothree");

$query = "SELECT * FROM un38dj4_affiliate_signup_extra WHERE email = '$email'";
$result = mysqli_query($con, $query);

while ($row = mysqli_fetch_assoc($result)) {
	echo json_encode($row);
 }