<?php
/*
 * Created on 12 january 2014 by Heia
 *

 */

	include("includes/haut.php");
	include("connectionSQL.php");
	include("functions.php");
?>
 <center><h1>The database management</h1></center><br />
<input type="button" name="Return" value="Return" onClick="document.location='displaySpecies.php'" /><br />
<?php
/*
 * Created on 19 mars 2013 by Thomas CROS
 *
 * 
 * 
 */
 //on récupère le code de l'espèce


if(isset ($_POST['id_ref'])){
	$id_ref = $_POST['id_ref'];
}

else {
$nameSpe = $_POST['namespe'];
//on récupère toutes les données de la références créee prélalblement	
$author = $_POST['author'];
$year = $_POST['year'];
$publi_in = $_POST['publi_in'];
$title = $_POST['title'];
$journal = $_POST['journal'];
$title=mysqli_real_escape_string($con,$title);
$journal=mysqli_real_escape_string($con,$journal);
$author=mysqli_real_escape_string($con,$author);

//requete d'insertion dans la base de la ligne de référence
mysqli_query($con,"INSERT INTO author VALUES (NULL,'$author')");
$query= mysqli_query($con,"Select last(id_author) from author where name_author ='$author'";
$res = mysqli_fetch_array($query);
$IdAuthor= $res['id_author'];
mysqli_query($con,"INSERT INTO `biblio_ref` VALUES (NULL,'$IdAuthor','$title','$year','$journal','$publi_in')");






/* $result= mysqli_query($con,"Select id_biblio from biblio_ref where author ='$author' and year ='$year' and publi_in ='$publi_in' and title ='$title' and journal ='$journal'");
$result3= mysqli_query($con,"Select id_species from Species where name_species = '$nameSpe'");
$row3 = mysqli_fetch_array($result3);
$IdSpeceies= $row3['id_species'];
$result2= mysqli_query($con,"Select id_individu from population where id_species ='$IdSpeceies'");
$row2 = mysqli_fetch_array($result2);
$IdIndividu= $row2['id_individu'];
$row = mysqli_fetch_array($result);
$IdBiblio= $row['id_biblio'];

mysqli_query($con,"INSERT INTO `describes` VALUES('$IdIndividu','$IdBiblio')"); */

//$id_ref = mysqli_insert_id();
}
 

 
 $result = mysqli_query ($con,"SELECT id_character, name_character, entitled_character, explaination from character1");
 
?>

<form action="addDefine.php" method="post">
<?php
//$_SESSION['id_ref']=$id_ref;
$code=$_SESSION['code_spe'];
echo "<input type = 'hidden' name = 'code_spe' value = '$code'>";
//echo "<input type = 'hidden' name = 'id_ref' value = $id_ref>";

echo "<table border = '1'>";
echo "<tr>";
echo"<th> Status </th>";
echo "<td> Enter the status of the definition </td>";
echo"<td>" . "<input type = 'text' name ='status'> </td>";
echo "</tr>"; 
while ($row = mysqli_fetch_array($result))
{
	$id = $row['id_character'];
	echo "<tr>";
	echo "<th>" . $row['entitled_character'] . "</th>";
	echo "<td>" . $row['explaination'] . "</td>";
	echo "<td>" . "<input type = 'text' name = 'nameChar$id'> </td>";
	echo "</tr>";
}

echo "</table>";
?>	
<br>
Data are valid : <input type="checkbox" defaultChecked name="validity" value="1" />
<br>
Description on a population type : <input type="checkbox" defaultChecked name="pop_type" value="T" />
<br>
<input type="submit"  name="submitAddData" action="addDefine.php" value="Submit"  />
</form>


