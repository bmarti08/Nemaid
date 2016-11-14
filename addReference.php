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



<h2> Add a new reference or choose a existing one in the list</h2>

</br>

<h3> Add a new reference </h3> <br>

<form action="addData.php" method="post">
<?php
if(isset ($_POST['id_spe'])){
	$code_spe = $_POST['id_spe'];
	
}
else {
	
	$nameSpe = $_POST['specie'];
	$nameGenus = $_POST['name_genus'];
	
	$query=mysqli_query($con,"SELECT COUNT(id_species) FROM species WHERE name_species='$nameSpe'");
		
	$result = mysqli_fetch_array($query);
	$NbId = $result['COUNT(id_species)'];

	
		if ($NbId>0){
			echo"This name already exists in the database";
			exit;
		}
		
		else{
			

	mysqli_query($con,"INSERT INTO species (id_species, name_species) VALUES (NULL, '$nameSpe')");
	$result= mysqli_query($con,"Select id_species from species where name_species ='$nameSpe'");
	$result2= mysqli_query($con,"Select id_genus from genus where name_genus ='$nameGenus'");
	$row2 = mysqli_fetch_array($result2);
	$row = mysqli_fetch_array($result);
	$IdSpeceies= $row['id_species'];
	$IdGenus= $row2['id_genus'];

	mysqli_query($con,"INSERT INTO belongs VALUES ('$IdSpeceies','$IdGenus')");
	//$code_spe = mysqli_insert_id();
	
		}
}
 //echo "<input type = 'hidden' name ='code_spe' value = $code_spe>";
 ?>
 
 
 
 
 
 
<table class ="no border">
	<tr>
		<td>Author(s) </td>
		<td><input required type="text" name="author" size = "100" ></td>
	</tr>
	<tr>
		<td>Year </td> 
		<td><input type="text" name="year" size = "100" ></td>
	</tr>
	<tr>
		<td>Published in </td> 
		<td><input type="text" name="publi_in" size = "100" ></td>
	</tr>
	<tr>
		<td>Title </td>
		<td><input required type="text" name="title" size = "100"></td>
	</tr>
	<tr>
		<td>Journal </td>
		<td><input type="text" name="journal" size = "100" ></td>
	</tr>
	<input type="hidden" name="namespe" value="<?php echo $nameSpe?>"/>
	</table>

<input type="submit" name="submitAddReference" value="Submit"  />
</form>

<br>
<br>

<h3> Select a reference </h3> <br>
<form action="addData.php" method="post">
<?php
 //echo "<input type = 'hidden' name ='code_spe' value = $code_spe>";
 ?>
<select id="id_ref"  onchange="document.getElementById('id_ref_content').value=this.options[this.selectedIndex].value">
<option name = "default" value = ""> --Choose a reference--</option>

<?php
$_SESSION['code_spe']=$code_spe;
$reference =mysqli_query($con,"SELECT id_biblio, title , year , name_author from biblio_ref natural join author ORDER BY title ");
while ($result = mysqli_fetch_array($reference))
{	
	$title = $result['title'];
	$title=str_replace('"',"'",$title);
	$year = $result['year'];
	$author = $result['name_author'];
	$author=str_replace('"',"'",$author);
	
	echo '<option name = "id_ref" value='. $result['id_biblio']. '>'. $year . " | " . $author .  " | "  . $title . '</option>' ;
}        

	

?>
</select>
<input type="hidden" name="id_ref" id="id_ref_content" value="" />
	<input type="submit"  name="submitGetReference" action="addData.php" value="Submit"  />

<br>

</form>

