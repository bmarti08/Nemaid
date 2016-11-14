<?php
/*
 * Created on 18 mars 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
include("connectionSQL.php");
include("includes/haut.php");


$name=$_GET['nom'];

//$result = mysql_query("SELECT define.status, define.id_ref, id_data, author, year, define.code_spe, specie FROM define, `references`, species WHERE specie='$name' AND species.code_spe = define.code_spe AND define.id_ref = `references`.id_ref ORDER BY year");
$result = mysqli_query($con,"select id_biblio, name_author, year, previous_name from AUTHOR natural join BIBLIO_REF natural join ANALYSIS natural join SPECIES where name_species ='$name' ORDER BY year");

echo "<h2>$name</h2>";

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
	echo "<td>" .$row['name_author'] . "</td>";
	echo "<td>" .$row['year'] . "</td>";
	echo "<td>" .$row['previous_name'] . "</td>";
	
	//$idSpecies = $row['id_species'];
	$idref = $row['id_biblio'];
	
	//$iddef = $row['id_def'];
	$nameURL = "View data";
	$url = "visuBDDDetails.php?iddata=";
	//$url .= $data;
	$url .="&idref=".$idref;
	echo "<td>" ."<a href=$url target='_blank'>$nameURL</a>" . "</td>";
	//if($_SESSION['admin'] == 1){
		if(isset($_SESSION['adlmin']) && $_SESSION['admin']){
		$idSpecies = $row['id_species'];
		$idref = $row['id_biblio'];
		$nameURLToDel = "delete this definition";
		$urlToDel = "deleteDefine.php?iddata=";
		$urlToDel .= $data;
		$urlToDel .="&iddef=".$iddef;
		$text = '"Are you sure to delete this definition ?"';
		echo"<td>" . "<a href='$urlToDel' onclick = 'return confirm($text);' target=$target>$nameURLToDel</a>" . "</td>";
	}
	echo "</tr>";
}

echo "</table>";


?>