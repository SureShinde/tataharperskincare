<?php

function getExcerpt($str, $startPos=0, $maxLength=100) {
	if(strlen($str) > $maxLength) {
		$excerpt   = mb_substr($str, $startPos, $maxLength-3, "UTF-8");
		$lastSpace = strrpos($excerpt, ' ');
		$excerpt   = mb_substr($excerpt, 0, $lastSpace, "UTF-8");
		$excerpt  .= '...';
	} else {
		$excerpt = $str;
	}
	
	return $excerpt;
}


if (isset($_GET['b1']))
	$b1 = $_GET['b1'];
if (isset($_GET['b2']))
	$b2 = $_GET['b2'];

$db_username = 'thsblogu';  
$db_password = 'g84ndfn3idm3tatharpdb';  
$db_database = 'blog';
$db_host = '0ef549e90e0f270df4fa0fb70d424e21f53e78af.rackspaceclouddb.com';

$blog_url = 'http://blog.tataharperskincare.com/';

mysql_connect($db_host, $db_username, $db_password);  
@mysql_select_db($db_database) or die("Unable to select database");

if (isset($b1)) {
	$query_one = "SELECT * FROM wp_posts WHERE id=$b1 AND post_status='publish'";
	$query_one_photo = "SELECT p.guid FROM wp_postmeta AS pm INNER JOIN wp_posts AS p ON pm.meta_value=p.ID WHERE pm.post_id=$b1 AND pm.meta_key = '_thumbnail_id'  LIMIT 1";
	$query_result_one = mysql_query($query_one);  
	$num_rows_one = mysql_numrows($query_result_one); 
	$query_result_one_photo = mysql_query($query_one_photo);
	if (!$query_result_one_photo || !mysql_num_rows($query_result_one_photo)) {
		echo '';
	}
	while ($row = mysql_fetch_array($query_result_one_photo)) {
		$photo_one_url = mysql_result($query_result_one_photo, 0);
	}
}

if (isset($b2)) {
	$query_two = "SELECT * FROM wp_posts WHERE id=$b2 AND post_status='publish'";
	$query_two_photo = "SELECT p.guid FROM wp_postmeta AS pm INNER JOIN wp_posts AS p ON pm.meta_value=p.ID WHERE pm.post_id=$b2 AND pm.meta_key = '_thumbnail_id'  LIMIT 1";
	$query_result_two = mysql_query($query_two);  
	$num_rows_two = mysql_numrows($query_result_two);
	$query_result_two_photo = mysql_query($query_two_photo);
	$photo_two_url = mysql_result($query_result_two_photo, 0);
}

mysql_close();  

echo "<h1>Featured natural skincare blog posts:</h1>";

if (isset($b1)) {
	for($i=0; $i<1; $i++){   
  
	//assign data to variables, $i is the row number, which increases with each run of the loop  
	$blog_date_one = mysql_result($query_result_one, $i, "post_date");  
	$blog_title_one = mysql_result($query_result_one, $i, "post_title");  
	$blog_content_one = mysql_result($query_result_one, $i, "post_content");  
	$blog_excerpt_one = mb_convert_encoding(getExcerpt($blog_content_one, 0, 400), "UTF-8");
	$blog_permalink_one = mysql_result($query_result_one, $i, "guid"); //use this line for p=11 format.  
	  
	$blog_permalink_one = $blog_url . mysql_result($query_result_one, $i, "post_name"); //combine blog url, with permalink title. Use this for title format  

	echo "<article>";
	echo "<div class='img_mask'>";
	if (isset($photo_one_url)) {
		echo "<a href='http://blog.tataharperskincare.com/?p=$b1'><img src='$photo_one_url' /></a>";
	}
	echo "</div>";
	echo "<h2><a href='http://blog.tataharperskincare.com/?p=$b1'>" . $blog_title_one . "</a></h2>"; 
	echo "<p>" . $blog_excerpt_one . "</p>";
	echo "<a class='read-more' href='http://blog.tataharperskincare.com/?p=$b1'>Read more" . '<img src="http://blog.tataharperskincare.com/wp-content/themes/angel-child/images/asset_repeat/arrow_right_pk.jpg">' . "</a>";
	echo "</article>";
	  
	//the following HTML content will be generated on the page as many times as the loop runs. In this case 5.  

	}
}

if (isset($b2))  {
	for($i=0; $i<1; $i++){   
  
	//assign data to variables, $i is the row number, which increases with each run of the loop  
	$blog_date_two = mysql_result($query_result_two, $i, "post_date");  
	$blog_title_two = mysql_result($query_result_two, $i, "post_title");  
	$blog_content_two = mysql_result($query_result_two, $i, "post_content");  
	$blog_excerpt_two = mb_convert_encoding(getExcerpt($blog_content_two, 0, 400), "UTF-8");
	$blog_permalink_two = mysql_result($query_result_two, $i, "guid"); //use this line for p=11 format.  
	  
	$blog_permalink_two = $blog_url . mysql_result($query_result_two, $i, "post_name"); //combine blog url, with permalink title. Use this for title format  

	echo "<article>";
	echo "<div class='img_mask'>";
	echo "<a href='http://blog.tataharperskincare.com/?p=$b2'><img src='$photo_two_url' /></a>";
	echo "</div>";
	echo "<h2><a href='http://blog.tataharperskincare.com/?p=$b2'>" . $blog_title_two . "</a></h2>"; 
	echo "<p>" . $blog_excerpt_two . "</p>";
	echo "<a class='read-more' href='http://blog.tataharperskincare.com/?p=$b2'>Read more" . '<img src="http://blog.tataharperskincare.com/wp-content/themes/angel-child/images/asset_repeat/arrow_right_pk.jpg">' . "</a>";
	echo "</article>";
	  
	//the following HTML content will be generated on the page as many times as the loop runs. In this case 5.  

	}
}