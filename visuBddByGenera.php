<?php

// On inclut les pages de connection à la BDD et des fonctions
include("connectionSQL.php");
include("functions.php");
include("includes/haut.php");
?>

<input type="button" name="Return" value="Return" onClick="document.location='visuBDD.php'" /><br />
<h2>List of genera:</h2><br />

<form method="post" action="search_genera.php">
   <div>
		<input name="genera" type="text" />
		<input type="submit" value="Go" />
   </div>
</form><br/>

<?php
$result = mysqli_query($con,"SELECT name_genus from genus");

echo "<table border='1'>
<tr>
<th>List of Genera</th>
</tr>";

while($row = mysqli_fetch_array($result))
  {
  	
  	//$nameGenera = $row['name_genus'];
  	//$url = "visuBddByGenera.php?name_genus=";
  	//$url .= $nameGenera;
  echo "<tr>";
  echo "<td>" .$row['name_genus'] . "</td>";
	// echo "<td>" ."<a href=$url target='_blank'>$nameGenera</a>" . "</td>";
  echo "</tr>";
  }
echo "</table>";

?>