<?php
//Conect to MySQL Hostinger Dataset
// PHP: 7.2
//Login Datasrt	
$user="u327797756_semea";
$passwd="K5tScUjLtDgs";
$host="localhost";
$name="u327797756_semea";
$table="SemeaTable";
$con=mysqli_connect($host,$user,$passwd,$name);
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

?>

