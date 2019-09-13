<?php
//PHP Code for get the last position of machine
require "../conect_mysql_hostinger.php";

 $query = "SELECT * FROM $table ORDER BY id DESC LIMIT 1;";
 $result=mysqli_query($con,$query);
 
 if ($result = mysqli_query($con, $query)) {
	 $last_data = mysqli_fetch_row($result);
		$lat=$last_data[6];
		$long=$last_data[7];
		$machine_id=$last_data[4];
	}
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en" >
<!--Start HTML Code for show the last position of machine-->
	<head>
	  <!--Configuration of Web Page-->
	   <title>Position Map</title>
	   <link rel="shortcut icon" href="icon.png" >
	   <meta charset='utf-8'>
	   <link rel="shortcut icon" href="icon.png" >
	   <meta http-equiv="X-UA-Compatible" content="IE=edge">
	   <meta name="viewport" content="width=device-width, initial-scale=1">
	   <link rel="stylesheet" href="style.css">
	   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	   <script src="menu_script.js"></script>
	</head>
	<body>
		<!--Build the menu-->
		<div id='cssmenu'>
		<ul>
		   <li class='active'><a href='index.html'><span>Real Time</span></a></li>
		   <li ><a href='dataset.php'><span>Dataset</span></a></li>
		   <li><a href='operation_map_browser.php'><span>Operation Map</span></a></li>
		   <li><a href='about.html'><span>About</span></a></li>
		</ul>
		</div>
		<!--Page Content-->
		  <div id="map" ></div>
		  <script type="text/javascript">
		 //Javascript Code of Bing Map
			function GetMap() {
				
				var map = new Microsoft.Maps.Map('#map', {
					//Hide the default navigation bar.
					showDashboard: false,
					allowHidingLabelsOfRoad: true
				});
				
				//Map configuration
				map.setView({
					mapTypeId: Microsoft.Maps.MapTypeId.aerial,
					center: new Microsoft.Maps.Location(<?php echo $lat ?>, <?php echo $long ?>),
					zoom: 20,
					labelOverlay: Microsoft.Maps.LabelOverlay.hidden
				});
				
				//Create Pushpin
				var position = new Microsoft.Maps.Location(<?php echo $lat ?>, <?php echo $long ?>);
				
				var pin = new Microsoft.Maps.Pushpin(position, {
					title: <?php echo json_encode ($machine_id) ?>,
					text: '1'
				});

				//Add the pushpin to the map
				map.entities.push(pin);
			}	  
		  </script>

		  <script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=Ago97Hg-bBpmQLwIlaefqNkAKjadbNKY7P893GKh9436_UtzKT1Y6v3g2gSQL947' async defer></script>


	</body>

</html>
