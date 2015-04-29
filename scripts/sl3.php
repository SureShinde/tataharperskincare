<?php

function csv_to_array($filename='activestores.csv', $delimiter=',')
{
    if(!file_exists($filename) || !is_readable($filename))
        return FALSE;

    $header = NULL;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
        {
            if(!$header)
                $header = $row;
            else
                $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }
    return $data;
}

$con = new mysqli("0ef549e90e0f270df4fa0fb70d424e21f53e78af.rackspaceclouddb.com","94hebi48h48three","QrwFbKSFyA7E","8ehdh84_magentothree");

// $query = "DELETE FROM un38dj4_magentostudy_stores WHERE stores_id > 1";

// $result = mysqli_query($con, $query);

// while ($row = mysqli_fetch_assoc($result)){
//   echo "<pre>";
//   var_dump($row);
//   echo "</pre>";
//   }


$data = csv_to_array();

foreach ($data as $d) {

	$title = $d['Title'];
	$phone = $d['Phone'];
	$street = $d['Street'];
	$city = $d['City'];
	$state = $d['State'];
	$zip = $d['Zip'];
	$lat = $d['Lat'];
	$lng = $d['Long'];
	$country = $d['Country'];
	$author = "THS";
	$content = "*";

	$insert_row = mysqli_query($con, "INSERT INTO un38dj4_magentostudy_stores (title, address, city, state, zip, phone, lat, lng, author, content) VALUES ('$title', '$street', '$city', '$state', '$zip', '$phone', '$lat', '$lng', '$author', '$content')");

	if($insert_row){
	    print 'Success!';
	}else{
	   print 'Error';
	}
}

$query = "SELECT * FROM un38dj4_magentostudy_stores";

$result = $con->query($query);
$count = 0;

while ($row = mysqli_fetch_assoc($result)){
    $count++;
  echo "<pre>";
  var_dump($row);
  echo "</pre>";
}

echo "total: " . $count;
