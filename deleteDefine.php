<?php
/*
 * Created on 19 mars 2013 by DRI
 *

 */

include("connectionSQL.php");
include("includes/haut.php");
 
 
$id_ref = $_GET["idref"];
//$id_data = $_GET["iddata"];

$deleteDefine = "DELETE FROM biblio_ref where id_biblio = '$id_ref'";
//$deleteData = "DELETE FROM data where id_data = '$id_data'";

if (mysqli_query($con,$deleteDefine)){
/* 	if (mysql_query($deleteData)){ */
		echo "<h2> Delete successfull </h2>";
	}
	
	else {
		echo "Error deleting record: " . mysqli_error($con);
	}

?>