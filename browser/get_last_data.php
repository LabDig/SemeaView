 <?php
require "../conect_mysql_hostinger.php";
//Show the last data in WEG PAGE
 $query = "SELECT * FROM $table ORDER BY id DESC LIMIT 1;";
if ($result = mysqli_query($con, $query)) {
	 $last_data = mysqli_fetch_row($result);
	 echo "<h3> Date and Time of Last Data: </h3>";
	 echo "<h5>".$last_data[2]."<h5>"; 
	 echo "<h5>".$last_data[3]."<h5>"; 
	 echo "<h3> Machine ID </h3>";
	 echo "<h5>".$last_data[4]."<h5>"; 
	 echo "<h3> Field ID </h3>";
	 echo "<h5>".$last_data[5]."<h5>"; 
	 echo "<h3> Latitude and Longitude(º) </h3>";
	 echo "<h5>".$last_data[6]."<h5>";
	 echo "<h5>".$last_data[7]."<h5>"; 
	 echo "<h3> UTM Coordinate (m) </h3>";
	 echo "<h5>".$last_data[8]."<h5>";
	 echo "<h5>".$last_data[9]."<h5>"; 
	 echo "<h3> Speed Machine (m/s)</h3>";
	 echo "<h5>".$last_data[10]."<h5>";
	 echo "<h3> Operation  Cap. (ha/h)</h3>";
	 echo "<h5>".$last_data[11]."<h5>";
	 echo "<h3> Time Operation (m)</h3>";
	 echo "<h5>".$last_data[12]."<h5>";
	 echo "<h3> Sowing/Fertilizing Area (ha)</h3>";
	 echo "<h5>".$last_data[16]."<h5>"; 
	 echo "<h3> Plant Density (plants / ha) </h3>";
	 echo "<h5>".$last_data[13]."<h5>";
	 echo "<h3> Fertilizer Spreader Ratio(kg/ha)</h3>";
	 echo "<h5>".$last_data[14]."<h5>";
  }
 mysqli_close($con);
 ?>