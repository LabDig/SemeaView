<?php
//PHP Code for export dataset to XLS Sheet
require "../conect_mysql_hostinger.php"; 
 //Filename
$file = 'dataset_semeaview.xls';
// Creat a xls table_xls
$table_xls .= '<table>';
$table_xls .= '<tr>';
	$table_xls .= '<td><b>ID</b></td>';
	$table_xls .= '<td><b>Date</b></td>';
	$table_xls .= '<td><b>Time</b></td>';
	$table_xls .= '<td><b>Machine ID</b></td>';
	$table_xls .= '<td><b>FieldID ID</b></td>';
	$table_xls .= '<td><b>Latitude(º)</b></td>';
	$table_xls .= '<td><b>Longitude(º)</b></td>';
	$table_xls .= '<td><b>Coordinate EW(m)</b></td>';
	$table_xls .= '<td><b>Coordinate NS(m)</b></td>';
	$table_xls .= '<td><b>Planter Speed(m/s)</b></td>';
	$table_xls .= '<td><b>Time Operation(h)</b></td>';
	$table_xls .= '<td><b>Operation Cap.(ha/h)</b></td>';
	$table_xls .= '<td><b>Sowing/Fertilizing Area(ha)</b></td>';
	$table_xls .= '<td><b>Plant Density (plant/ha) </b></td>';
	$table_xls .= '<td><b>Fertilizer Application Ratio (kg/ha) </b></td>';
$table_xls .= '</tr>';

// Read dataset and build XLS file
$query = "select * from $table order by id desc";
$result=mysqli_query($con,$query);
while ($row=mysqli_fetch_object($result))
{
	$table_xls .= '<tr>';
		$table_xls .= '<td>'.$row->LogID.'</td>';
		$table_xls .= '<td>'.$row->Date.'</td>';
		$table_xls .= '<td>'.$row->Time.'</td>';
		$table_xls .= '<td>'.$row->MachineID.'</td>';
		$table_xls .= '<td>'.$row->FieldID.'</td>';
		$table_xls .= '<td>'.$row->Lati.'</td>';
		$table_xls .= '<td>'.$row->Longi.'</td>';
		$table_xls .= '<td>'.$row->XUtm.'</td>';
		$table_xls .= '<td>'.$row->YUtm.'</td>';
		$table_xls .= '<td>'.$row->Speed.'</td>';
		$table_xls .= '<td>'.$row->TimeOperation.'</td>';
		$table_xls .= '<td>'.$row->OpCap.'</td>';
		$table_xls .= '<td>'.$row->Area.'</td>';
		$table_xls .= '<td>'.$row->Population.'</td>';
		$table_xls .= '<td>'.$row->FertRatio.'</td>';
	$table_xls .= '</tr>';
}
$table_xls .= '</table>';
// Force download
header ('Cache-Control: no-cache, must-revalidate');
header ('Pragma: no-cache');
header('Content-Type: application/x-msexcel');
header ("Content-Disposition: attachment; filename=\"{$file}\"");
echo $table_xls;
?>