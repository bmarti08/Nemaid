<?php
/*
 * Created on 25 november by Heia
 *

 */

include("connectionSQL.php");
include("includes/haut.php");
 
 
$id_def = $_GET["iddef"];

$deleteDefine = "DELETE FROM define where id_def = '$id_def'";
$deleteData = "DELETE FROM data where id_data = '$id_data'";

if (mysql_query($deleteDefine)){
	if (mysql_query($deleteData)){
		echo "<h2> Delete successfull </h2>";
	}
	
	else {
		echo "Error deleting record: " . mysql_error();
	}
}
else {
		echo "Error deleting record: " . mysql_error();
	}

?>