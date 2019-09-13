<?php
require "../conect_mysql_hostinger.php"; 
//read dataset and get Field ID, for build combobox in app
 $query = "select * from $table";
 $result=mysqli_query($con,$query);
 $ii=0;
 while ($row=mysqli_fetch_object($result))
{
	$field[$ii]=$row->FieldID;
	$ii=$ii+1;
}
mysqli_close($con);

//get the distinct elements
// Pick all elements one by one 
function printDistinct($arr, $n) {
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
        	echo $arr[$i];
		echo ",";
	}	
    }
}
printDistinct($field, $ii);	
?>