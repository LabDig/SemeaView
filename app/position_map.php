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
	  <meta charset="UTF-8">
	  <title>LAST POSITION</title>
	  <link rel="stylesheet" href="style.css">
	  <link rel="shortcut icon" href="icon.png" >
	  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
	  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	  <style id="compiled-css" type="text/css">
	  <!--CSS Style for the map-->
	  #map {
			height: 95%;
		  }
		  html, body {
			height: 100%;
			margin: 0;
			padding: 0;
		  }
		</style>
	</head>
	<body>
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
