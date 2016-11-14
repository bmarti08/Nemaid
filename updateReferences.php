<?php
/*
 * Created on 13 january 2014 by Heia
 *

 */

	include("includes/haut.php");
	include("connectionSQL.php");
	include("functions.php");
?>
<center><h1>The database management</h1></center><br />
<?php
include("menu_database_manage.php");
?>
<input type="button" name="Return" value="Return" onClick="document.location='displayReferences.php'" /><br />
<?php

$id=$_POST['id'];
$author=$_POST['authorSet'.$id.''];
$year=$_POST['yearSet'.$id.''];
$publi_in=$_POST['publi_inSet'.$id.''];
$title=$_POST['titleSet'.$id.''];
$journal=$_POST['journalSet'.$id.''];

 $update = mysqli_query($con,'UPDATE BIBLIO_REF SET biblio_ref.journal="'.$journal.'",
biblio_ref.year="'.$year.'", biblio_ref.publi_in="'.$publi_in.'", biblio_ref.title="'.$title.'" WHERE id_biblio="'.$id.'"');

$query = mysqli_query($con,'select id_author from BIBLIO_REF where id_biblio="'.$id.'"');
while ($result = mysqli_fetch_array($query)){
	$IdAuthor=$result['id_author'];

}
	 $update2 = mysqli_query($con,'UPDATE AUTHOR SET name_author="'.$author.'" WHERE id_author="'.$IdAuthor.'"');






if ($update==true){
		echo "<h3>Database updated successfully</h3>";
	}
	
	else {
		echo "Error updating record: " . mysqli_error($con);
	}
?>
