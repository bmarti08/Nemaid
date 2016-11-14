<?php
/*
 * Created on 7 december by Heia
 *

 */

	include("includes/haut.php");
	include("connectionSQL.php");
	include("functions.php");
?>
<center><h1>The database management</h1></center><br />
<?php
include("menu_database_manage.php");
include("menu_dbm_species.php")
?>
<input type="button" name="Return" value="Return" onClick="document.location='main.php'" /><br />
<form method="post" action="">
   <p>
       <label for="species">Please choose one species</label><br />
       <select name="species" id="species">
	   <?php
	   $result=mysqli_query($con,"SELECT name_species from SPECIES");
	   
	   while($row = mysqli_fetch_array($result))
	   {
		   $name = $_POST["name_species"];
	   ?>
	   <option value="<?php echo $row['name_species'];?>"><?php echo $row['name_species'];?></option>
	   <?php
	   }
	   ?>
       </select>
	   <input type="submit" value="Choose this species">
   </p>
</form>

<form>
<?php

 if(isset($_POST["species"])){
	 $name = $_POST["species"];
//$result1 = mysql_query("SELECT define.status, define.id_ref, id_data, author, year, define.code_spe, specie FROM define, `references`, species WHERE specie='$name' AND species.code_spe = define.code_spe AND define.id_ref = `references`.id_ref ORDER BY year");
$result1 = mysqli_query($con,"select id_biblio, name_author, year, previous_name from AUTHOR natural join BIBLIO_REF natural join ANALYSIS natural join SPECIES where name_species = '$name' group by id_biblio" );

echo "<h2> $name </h2>";

echo "<table border='1'>
<tr>
<th>Author(s)</th>
<th>Year</th>
<th>previous Name</th>
<th>Link to data</th>
</tr>";


while($rowref = mysqli_fetch_array($result1))
{
	echo "<tr>";
	echo "<td>" .$rowref['name_author'] . "</td>";
	echo "<td>" .$rowref['year'] . "</td>";
	echo "<td>" .$rowref['previous_name'] . "</td>";
	
	//$data = $rowref['id_data'];
	$idref = $rowref['id_biblio'];
	//$iddef = $rowref['id_def'];
	$nameURL = "View data";
	$url = "visuBDDBySpeciesDetails.php?";
	//$url .= $data;
	$url .="&idref=".$idref;
	echo "<td>" ."<a href=$url target=>$nameURL</a>" . "</td>";
	if($_SESSION['admin'] == 1){
		//$data = $rowref['id_data'];
		$idref = $rowref['id_biblio'];
		$nameURLToDel = "delete this definition";
		$urlToDel = "deleteDefine.php?iddata=";
		//$urlToDel .= $data;
		$urlToDel .="&idref=".$idref;
		$text = '"Are you sure to delete this definition ?"';
		echo"<td>" . "<a href='$urlToDel' target=>$nameURLToDel</a>" . "</td>";
	}
	echo "</tr>";
}

echo "</table>";
}
?>
</form>
