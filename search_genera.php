<?php

include("connectionSQL.php");
include("includes/haut.php");
?>
<input type="button" name="Return" value="Return" onClick="document.location='visuBddByGenera.php'" /><br />
<?php
$name=$_POST['genera'];
$result = mysqli_query($con,"SELECT `name_genus` FROM `GENUS` WHERE `name_genus` LIKE '%".$name."%' ");
	
    //echo "<h2> $name </h2>";
	echo "<table border='1'>
<tr>
<th>Genus</th>
</tr>";

	while ($row = mysqli_fetch_array($result)){
	
	echo "<tr>";

	echo "<td>" .$row['name_genus'] . "</td>";
	
	echo "</tr>";
	
}

echo "</table>";

?>
