<?php

$email = $_POST["logged_in_customer_email"];
$phone = $_POST["phone_number_extra"];
$address = $_POST["address_extra"];
$country = $_POST["country_extra"];
$dob = $_POST["dob_extra"];
$website_name = $_POST["website_name_extra"];
$website_url = $_POST["website_url_extra"];
$website_about = $_POST["website_about_extra"];
$website_for = $_POST["website_for_extra"];
$website_type = $_POST["type_extra"];
if ($_POST["type_other_extra"] != "")
	$website_type = $_POST["type_other_extra"];
$unique_visitors = $_POST["unique_visitors_extra"];

$topics = "";
$traffic = "";

if ($_POST["topics-health-beauty"] == 1)
	$topics .= "Health & Beauty, ";
if ($_POST["topics-home-garden"] == 1)
	$topics .= "Home & Garden, ";
if ($_POST["topics-kids-baby"] == 1)
	$topics .= "Kids & Baby, ";
if ($_POST["topics-health-wellness"] == 1)
	$topics .= "Health & Wellness, ";
if ($_POST["topics-lifestyle-travel"] == 1)
	$topics .= "Lifestyle & Travel, ";
if ($_POST["topics-clothing-jewelry"] == 1)
	$topics .= "Clothing, Shoes, & Jewelry, ";

$topics = substr_replace($topics, "", -1);
$topics = substr_replace($topics, "", -1);

if ($_POST["traffic-paid-search"] == 1)
	$traffic .= "Paid Search Forum, ";
if ($_POST["traffic-display-advertising"] == 1)
	$traffic .= "Display Advertising, ";
if ($_POST["traffic-seo"] == 1)
	$traffic .= "SEO, ";
if ($_POST["traffic-email"] == 1)
	$traffic .= "Email, ";
if ($_POST["traffic-social-networks"] == 1)
	$traffic .= "Social Networks, ";
if ($_POST["traffic-blogs"] == 1)
	$traffic .= "Blogs, ";

$traffic = substr_replace($traffic, "", -1);
$traffic = substr_replace($traffic, "", -1);


//mail("anthony@reignitegroup.com", "Test", "Test 1");
// mail("anthony@reignitegroup.com", "Topics", $topics);

$con=mysqli_connect("0ef549e90e0f270df4fa0fb70d424e21f53e78af.rackspaceclouddb.com","94hebi48h48three","QrwFbKSFyA7E","8ehdh84_magentothree");

$count_query = "SELECT * FROM un38dj4_affiliate_signup_extra WHERE email = '$email'";
$count_result = mysqli_query($con, $count_query);
$num_rows = mysqli_num_rows($count_result);

if ($num_rows == 0)
{
	mail("anthony@reignitegroup.com", "THS Affiliate Account Created", $topics);
	$query = "INSERT INTO un38dj4_affiliate_signup_extra (email,phone,address,country,dateofbirth,websitename,websiteurl,websiteabout,websitefor,topics,traffic,uniquevisitors,websitetype) VALUES ('$email','$phone','$address','$country','$dob','$website_name','$website_url','$website_about', '$website_for', '$topics', '$traffic', '$unique_visitors', '$website_type')";
	$result = mysqli_query($con, $query);
}