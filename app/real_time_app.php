<?php
//Used from mobile app to get the last data in dataset
require "../conect_mysql_hostinger.php";
//
$query = "SELECT * FROM $table ORDER BY id DESC LIMIT 1;";
//Build a message : A#B#C..., where A,B, C ...it is the variables
if ($result = mysqli_query($con, $query)) {
	$last = mysqli_fetch_row($result);
	for ($i = 0; $i < 16; $i++) {
		echo $last[$i];
		echo "#";
	} 
	echo $last[16]; //the last data
}
mysqli_close($con);
?>