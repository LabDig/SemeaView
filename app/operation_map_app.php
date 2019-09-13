 <?php
//Fuctio to get distint elements in a list
 function printDistinct($arr, $n) {
	$kk=0;
for($i = 0; $i < $n; $i++) {
        // Check if the picked element 
        // is already printed 
        $j;
		
        for($j = 0; $j < $i; $j++) 
        if ($arr[$i] == $arr[$j]) 
            break; 
        // If not printed  
        // earlier, then print it 
        if ($i == $j) {
        	$list[$kk]=$arr[$i];
			$kk=$kk+1;
	}	
    }
	return $list;
}
//Conect to Database
require "../conect_mysql_hostinger.php"; 
//Type of map and Field it is in link build by App.
$type=$_GET['type'];  //operation_map_app.php?type=1&field=F0
$field=$_GET['field'];
//Read dataset
$i=0;
$query = "SELECT * FROM $table";
$result=mysqli_query($con,$query);
while ($row=mysqli_fetch_object($result))
 {
	$field_id=$row->FieldID;
	if ($field_id==$field){
		$lat[$i] = $row->Lati;
		$long[$i] = $row->Longi;
		if ($type=='1') {
			$var[$i] = $row->Speed;
			$legend='<center>Machine Speed (m/s) </br></center>';
		}
		if ($type=='2') {
			$var[$i] = $row->Population;
			$legend='<center>Plant Density (plant/ha) </br></center>';
		}
		if ($type=='3') {
			$var[$i] = $row->FertRatio;
			$legend='<center>Fert. Spreader Ratio (kg/ha) </br></center>';
		}
		$i=$i+1;
	}
}
//
//Group the $Var in Class to Build Map
if ($type=='1') { // Speed
	$dt=(max($var)-min($var))/4;
	$group=5; //Build always 5 classes
}
else { //Fertilizer and Population
	$list=printDistinct($var, $i);
	sort($list);
	$group=sizeof($list); //Classes number is defined acord distinct elements
}
//
//Color used for Bluid Map
//First is to Group 0
$color = ['#00FFFF00','#0000ff', '#00ffff', '#ffff00', '#ff0000'];

mysqli_close($con); //close database connection
//End PHP Code
?>

<!--Start HTML Code-->
<!DOCTYPE html>
<html>
  <head>
    <!--Configurations of Page-->
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title> Operation Map</title>
    <!--Style in CSS-->
	<style>
      .mapContainer {
				margin: 0;
				padding: 0;
				height: 80%;
			}
			#myMap {
				height: 100%;
			}
			#legend {
				position: absolute;
				top: 150px;
				right: 10px;
				background-color: rgba(255,255,255,0.8);
				border-radius: 5px;
				width: 70px;
				height: 135px;
				line-height: 15px;
				padding: 10px;
				font-family: "Trebuchet MS", Helvetica, sans-serif;
				font-size: 12px;
			}
	  
    </style>
    <!--JavaScript Code for Bing Map-->
		<script type='text/javascript'>
		//
		function GetMap() { //Funcition to build map
			//Create map
			var map = new Microsoft.Maps.Map('#myMap', {
				//$i cotain lengh of array
				center: new Microsoft.Maps.Location(<?php echo $lat[$i-1]?>, <?php echo $long[$i-1]?>),
				zoom: 50,
				mapTypeId: Microsoft.Maps.MapTypeId.aerial,
				showDashboard: false, //not show Bing Function
				allowHidingLabelsOfRoad: true, //Not show Road's name
				labelOverlay: Microsoft.Maps.LabelOverlay.hidden //hide labels
			});
			//Draw a line using point k and k+1
			//The color refers to magnitude value of variable
			//k i is total number of point
			<?php for($k=0;$k<$i-1;$k++){ 
			
				// The color refers to magnitude value of variable
				//if variable is speed, use one of 5 groups defined in PHP Code
				//Result it's color index
				
				if ($type=='1') {
					$color_index=intval(($var[$k]-min($var))/$dt);
				//if pop or fer, search in list, the position of $var[$k]; The result it's 
				//color index.
				}
				else {
					$srch = array_keys($list, $var[$k]); 
					$color_index=$srch[0];
				} 
				?>
				var points = [
					new Microsoft.Maps.Location(<?php echo $lat[$k]?>, <?php echo $long[$k]?>),
					new Microsoft.Maps.Location(<?php echo $lat[$k+1]?>, <?php echo $long[$k+1]?>)
				
				];
				
				var color = <?php echo json_encode($color[$color_index]); ?>;
				//Create a polygon
				var polygon = new Microsoft.Maps.Polygon(points, {
					fillColor: color,
					strokeColor: color,
					strokeThickness: 10
				});
				//Add the polygon to map
				map.entities.push(polygon);
			
			<?php } ?>
			
			//Create the legend.
			createLegend();
		}
    
	
		function createLegend() {
			//Create HTML for legend
			var legendHtml = [];
			//For each variable class
			//Class 0 is not showed
			legendHtml.push(<?php echo json_encode ($legend)?>);
			<?php for($n=1;$n<$group;$n++){ 
				if ($type=='1') $label=min($var)+$n*$dt; //1 is speed
				else  $label = $list[$n]; ?> //Fert ou Seed
            legendHtml.push('<svg width="20" height="20"><rect width="20" height="20" style="fill:'); //Build rectangle
            legendHtml.push(<?php echo json_encode($color[$n])?>, '"></rect></svg> ');//color
            legendHtml.push(<?php echo json_encode($label)?>, '<br/>'); //name
			<?php } ?>
			document.getElementById('legend').innerHTML = legendHtml.join('');
		}
		
		<!--End of JavaScript Code for Bing Map-->
		</script>
		<!--Script that Cal Get Map and contain Bing Key-->
		<script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=Ago97Hg-bBpmQLwIlaefqNkAKjadbNKY7P893GKh9436_UtzKT1Y6v3g2gSQL947' async defer>
		</script>
	</head>
	<body>
		<!--Div's Map and Legend-->
		<div class="mapContainer">
			<div id="myMap"></div>
			<div id="legend"></div>
		</div>
	</body>
<!--End of HTML-->
</html>