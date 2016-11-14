<?php
include('includes/haut.php');
include('connectionSQL.php');
include("functions.php");
/*
 * Created on 17 01 2014 by Manon Forconi
 * */
 ?>
<center><h1>The database management</h1></center><br />
<?php
include("menu_database_manage.php");
include("connectionSQL.php");
?>

<?php
echo "<h2> Characters in the database : </h2>";
	
	
$id=$_POST['id'];
$entitled_character=$_POST['entitled_characterSet'.$id.''];
//$name_character=$_POST['name_characterSet'.$id.''];
$explaination=$_POST['explainationSet'.$id.''];
$weight=$_POST['weightSet'.$id.''];
$correction_factor=$_POST['correction_factorSet'.$id.''];
$min_character=$_POST['min_characterSet'.$id.''];
$nb_state=$_POST['nb_stateSet'.$id.''];
$max_character=$_POST['max_characterSet'.$id.''];

 $update = mysqli_query($con,'UPDATE character1
 SET character1.entitled_character="'.$entitled_character.'", character1.explaination="'.$explaination.'" 
WHERE id_character="'.$id.'"');

$update = mysqli_query($con,'UPDATE min_max
 SET min_max.max_character="'.$max_character.'", min_max.min_character="'.$min_character.'" 
WHERE id_character="'.$id.'"');

$update = mysqli_query($con,'UPDATE is_compound_by 
 SET is_compound_by.weight="'.$weight.'" WHERE id_character="'.$id.'"');
 
$select = mysqli_query($con,'Select id_analysis from is_compound_by where id_character = "'.$id.'"');
while ($row2 = mysqli_fetch_array($select))
	{
$IdGAnalysis= $row2['id_analysis'];
$update = mysqli_query($con,'UPDATE analysis
 SET analysis.correction_factor="'.$correction_factor.'", analysis.nb_state="'.$nb_state.'" 
WHERE id_analysis="'.$IdGAnalysis.'"');
}


if ($update==true){
		echo "<h3>Database updated successfully</h3>";
	}
	
	else {
		echo "Error updating record: " . mysqli_error($con);
	}
	

?>
<a href="db_characters.php">Return</a>			