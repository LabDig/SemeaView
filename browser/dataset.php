 <?php
require "../conect_mysql_hostinger.php"; 
//PHP Code for show dataset in table format
 $i=0;
 $query = "select * from $table";
 $result=mysqli_query($con,$query);
 //Read all dataset
 while ($row=mysqli_fetch_object($result))
 {
	$logID[$i] =$row->LogID;
	$date[$i] = $row->Date;
	$time[$i] = $row->Time;
	$fielid[$i]=$row->FieldID;
	$machid[$i]=$row->MachineID;
	$lat[$i] = $row->Lati;
	$long[$i] = $row->Longi;
	$utm_ew[$i] = $row->XUtm;
	$utm_ns[$i] = $row->YUtm;
	$speed[$i] = $row->Speed;
	$opcap[$i] = $row->OpCap;
	$timeop[$i] = $row->TimeOperation;
	$area[$i] = $row->Area;
	$pop[$i] = $row->Population;
	$fertrt[$i] = $row->FertRatio;
	$i=$i+1;
}
mysqli_close($con);
//End of PHP Code
?>

<!DOCTYPE html>
<!--Start HTML Code-->
<html>
	<head>
	  <!--Configurations of Page-->
	   <meta charset='utf-8'>
	   <link rel="shortcut icon" href="icon.png" >
	   <title>Dataset</title>
	   <meta http-equiv="X-UA-Compatible" content="IE=edge">
	   <meta name="viewport" content="width=device-width, initial-scale=1">
	   <link rel="stylesheet" href="style.css">
	   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	   <script src="menu_script.js"></script>
	</head>
	<!--Page Start-->
	<body>
		<!--Build the menu-->
		<div id='cssmenu'>
		<ul>
		   <li><a href='index.html'><span>Real Time</span></a></li>
		   <li class='active'><a href='dataset.php'><span>Dataset</span></a></li>
		   <li><a href='operation_map_browser.php'><span>Operation Map</span></a></li>
		   <li><a href='about.html'><span>About</span></a></li>
		</ul>
		</div>
		<!--Page Content-->
		<!--Button for Export-->
		<div id="button"><a href="export.php">Export Dataset </a></div></br>
		<!--Build the table header-->
		<table border="1">
		  <tr>
			<th>ID</th>
			<th>Date</th>
			<th>Time UTC</th>
			<th>Machine ID</th>
			<th>Field ID</th>
			<th>Latitude(º)</th>
			<th>Longitude(º) </th>
			<th>Coordinate E-W(m)</th>
			<th>Coordinate NS(m)</th>
			<th>Planter speed (m/s)</th>
			<th>Time Operation(h)</th>
			<th>Operation Cap. (ha/h)</th>
			<th>Sowing/Fertilizing Area (ha)</th>
			<th>Plant Density(plant/ha)</th>
			<th>Fertilizer Application Ration (kg/ha)</th>
		  </tr>
		 <!--Build the table row's in PHP--> 
		 <?php for($k=$i-1;$k>0;$k--){
			echo "<tr>";
				echo "<td>".$logID[$k]."</td>";
				echo "<td>".$date[$k]."</td>";
				echo "<td>".$time[$k]."</td>";
				echo "<td>".$machid[$k]."</td>";
				echo "<td>".$fielid[$k]."</td>";
				echo "<td>".$lat[$k]."</td>";
				echo "<td>".$long[$k] ."</td>";
				echo "<td>".$utm_ew[$k]."</td>";
				echo "<td>".$utm_ns[$k] ."</td>";
				echo "<td>".$speed[$k] ."</td>";
				echo "<td>".$timeop[$k]."</td>";
				echo "<td>".$opcap[$k]."</td>";
				echo "<td>".$area[$k] ."</td>";
				echo "<td>".$pop[$k] ."</td>";
				echo "<td>".$fertrt[$k] ."</td>";
			echo "</tr>";
		  } ?>
		</table>
	</body>
<!--End of HTML Code-->
</html>