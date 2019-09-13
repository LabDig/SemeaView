 <?php
 //PHP Code to Read Database
//Title of Page 
//Conect to Database
require "../conect_mysql_hostinger.php"; 
//Function to identifie distinct elements in database
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
//Build a list of distint element in database.
//Build list of Field ID's
//Conect to Database
$query = "select * from $table";
$result=mysqli_query($con,$query);
$ii=0;
//Read all database
while ($row=mysqli_fetch_object($result))
{
	$field[$ii]=$row->FieldID;
	$ii=$ii+1;
}
$list_field=printDistinct($field, $ii);
//

//When Button is clicked
if(isset($_POST['submit'])){
	$type = $_POST['type'];
	$field = $_POST['field'];
	//Read Databased and stores build array for variable and field selected	
	//$Lat , $ Long and $ Var
	$i=0;
	$query = "select * from $table";
	$result=mysqli_query($con,$query);
	//Read all database
	while ($row=mysqli_fetch_object($result)){
		$field_id=$row->FieldID;//Field ID Collum
		if ($field_id==$field){
			$lat[$i] = $row->Lati;
			$long[$i] = $row->Longi;
			//Var contain the variable selected in combobox
			//legend is title of legend
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
}
mysqli_close($con); //close database connection
//End PHP Code
?> 

<!--Start HTML Code-->
<!DOCTYPE html>
<html>
	<head>
		<!--Configurations of Page-->
	   <title>Operation Map</title>
	   <link rel="shortcut icon" href="icon.png" >
	   <meta charset='utf-8'>
	   <link rel="shortcut icon" href="icon.png" >
	   <meta http-equiv="X-UA-Compatible" content="IE=edge">
	   <meta name="viewport" content="width=device-width, initial-scale=1">
	   <link rel="stylesheet" href="style.css">
	   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	   <script src="menu_script.js"></script>

		<!--JavaScript Code for Bing Map-->
		<script type='text/javascript'>
		//
		function GetMap() { //Funcition to build map
			//Create map
			var map = new Microsoft.Maps.Map('#map', {
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
		<!--Build the menu-->
		<div id='cssmenu'>
		<ul>
		   <li ><a href='index.html'><span>Real Time</span></a></li>
		   <li ><a href='dataset.php'><span>Dataset</span></a></li>
		   <li class='active'><a href='operation_map_browser.php'><span>Operation Map</span></a></li>
		   <li><a href='about.html'><span>About</span></a></li>
		</ul>
		</div>
		<!--Page Content-->
		<?php
			//Generate ComboBox for Field ID
			echo '<form name="field" method="post"> <select name="field">';
			for($k=0;$k<sizeof($list_field);$k++){ 
				 echo '<option >'.$list_field[$k].'</option>';
			}
			echo '</select>';
			// 
			//Combox por Variable Map : Speed, Fert and Seed
			echo'<form name="type" method="post"> <select name="type" >';
			echo '<option value="1">Speed Machine</option>';
			echo ' <option value="2">Plant Density</option>';
			echo '<option value="3">Fertilizer Spreader Ratio</option>';
			echo '</select>';
			//Plot button 
			echo '<input type="submit" value="Plot" name="submit"/>';
			echo '</form>';
		?>
		<!--Div's Map and Legend-->
		<div class="mapContainer">
			<div id="map"></div>
			<div id="legend"></div>
		</div>
	</body>
<!--End of HTML-->
</html>