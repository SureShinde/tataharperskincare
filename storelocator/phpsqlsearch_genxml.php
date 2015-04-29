<?php  

include('/root/www/private/c.php');

// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

$con=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

// Get parameters from URL
$center_lat = $_REQUEST["lat"];
$center_lng = $_REQUEST["lng"];
$radius = $_REQUEST["radius"];

$mysql_center_lat = mysqli_real_escape_string($con,$center_lat);
$mysql_center_lng = mysqli_real_escape_string($con, $center_lng);
$mysql_radius = mysqli_real_escape_string($con, $radius);

$format = "SELECT address, city, state, zip, phone, title, lat, lng, (3959 * acos(cos(radians('%s')) * cos(radians(lat)) * cos(radians(lng) - radians('%s')) + sin(radians('%s')) * sin(radians(lat)))) AS distance FROM un38dj4_magentostudy_stores HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20";

$query = sprintf($format, $mysql_center_lat, $mysql_center_lng, $mysql_center_lat, $mysql_radius);

// echo "query: " . $query . "<br />";

$result = mysqli_query($con, $query);

if (!$result) {
  die("Invalid query: " . mysql_error());
}

/*echo "<pre>";
var_dump($result);
echo "</pre>";*/

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each
while ($row = mysqli_fetch_assoc($result)){
  // echo "<pre>";
  // var_dump($row);
  // echo "</pre>";
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("name", $row['title']);
  $newnode->setAttribute("address", $row['address']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("distance", $row['distance']);
  $newnode->setAttribute("city", $row['city']);
  $newnode->setAttribute("state", $row['state']);
  $newnode->setAttribute("zip", $row['zip']);
  $newnode->setAttribute("phone", $row['phone']);
}

echo $dom->saveXML();
