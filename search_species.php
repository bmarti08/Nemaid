<?php

include("connectionSQL.php");
include("includes/haut.php");

$name = $_POST["specie"];
//$result = mysql_query("SELECT define.status, define.id_ref, id_data, author, year, define.code_spe, specie FROM define, `references`, species WHERE specie LIKE '%$name%' AND species.code_spe = define.code_spe AND define.id_ref = `references`.id_ref ORDER BY year");
$result = mysqli_query($con,"select SPECIES.previous_name, id_biblio, title, author, year, journal,publi_in from BIBLIO_REF natural join POPULATION natural join SPECIES where name_species ='$name' ORDER BY year");

echo "<h2> $name </h2>";

echo "<table border='1'>
<tr>
<th>Author(s)</th>
<th>Year</th>
<th>previous Name</th>
<th>Link to data</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
	echo "<tr>";
	
	echo "<td>" .$row['author'] . "</td>";
	echo "<td>" .$row['year'] . "</td>";
	echo "<td>" .$row['previous_name'] . "</td>";	
	
	$data = $row['id_data'];
	$idref = $row['id_ref'];
	$iddef = $row['id_def'];
	$nameURL = "View data";
	$url = "visuBDDDetails.php?iddata=";
	$url .= $data;
	$url .="&idref=".$idref;
	echo "<td>" ."<a href=$url target=$target>$nameURL</a>" . "</td>";
	
	echo "</tr>";
}

echo "</table>";

?>





