<?php
require "conect_mysql_hostinger.php";
mysqli_query($con,"DELETE FROM $table  WHERE id IN (20576,20693)");
mysqli_close($con);
echo "Deleted!";
?>