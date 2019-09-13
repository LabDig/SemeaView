<?php
require "conect_mysql_hostinger.php";
//PHP used to pass data to MySQL dataset trough a link web page
$LogID=$_GET['LogID'];
$Date=$_GET['Date'];
$Time=$_GET['Time'];
$MachineID = $_GET['MachineID'];
$FieldID = $_GET['FieldID'];
$Lati = $_GET['Lati'];
$Longi = $_GET['Longi'];
$XUtm = $_GET['XUtm'];
$YUtm = $_GET['YUtm'];
$Speed = $_GET['Speed'];
$OpCap = $_GET['OpCap'];
$TimeOperation = $_GET['TimeOperation'];
$Population = $_GET['Population'];
$FertRatio = $_GET['FertRatio'];
$FertWgt = $_GET['FertWgt'];
$Area = $_GET['Area'];
//
// Perform queries 
mysqli_query($con,"SELECT * FROM $table");
mysqli_query($con,"INSERT INTO $table(LogID,Date,Time,MachineID,FieldID,Lati,Longi,XUtm,YUtm,Speed,OpCap,TimeOperation,Population,FertRatio,FertWgt,Area) VALUES ('$LogID','$Date','$Time','$MachineID','$FieldID','$Lati','$Longi','$XUtm','$YUtm','$Speed','$OpCap','$TimeOperation','$Population','$FertRatio','$FertWgt','$Area')");
mysqli_close($con);
?>