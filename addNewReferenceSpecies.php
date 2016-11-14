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
<?php
include("menu_database_manage.php");
?>
<center>
							<table class="menu">
								<tr>
								<td class ="menu"><a href="addNewReference.php">Add a new reference</a></td>
								<td class ="menu"><a href="formDisplayReferences.php">Search a reference</a></td>
								<tr>
							</table>
						</center>
<input type="button" name="Return" value="Return" onClick="document.location='main.php'" /><br />
<?php
$author = $_POST['author'];
$year = $_POST['year'];
$year_publi= $_POST['year_publi'];
$title = $_POST['title'];
$journal = $_POST['journal'];

if($author!=null && $title!=null && $journal!=null){
?>

<p>View of your values</p>
<table>
		<tr>
		<td>Author</td>
		<td><?php echo $author; ?></td>
		</tr>
		<tr>
		<td>Year</td>
		<td><?php echo $year; ?></td>
		</tr>
		<tr>
		<td>Publish in</td>
		<td><?php echo $year_publi; ?></td>
		</tr>
		<tr>
		<td>Title</td>
		<td><?php echo $title; ?></td>
		</tr>
		<tr>
		<td>Journal</td>
		<td><?php echo $journal; ?></td>
		</tr>
		
</table>

<?php

$requete = mysqli_query($con,"INSERT INTO author(`ID_AUTHOR`, `NAME_AUTHOR`) VALUES (NULL,'$author')");
$requete2 = mysqli_query($con,"SELECT max(id_author) from author where name_author ='$author'");
$row = mysqli_fetch_array($requete2);
$IdAuthor= $row['max(id_author)'];
$update = ("INSERT INTO biblio_ref(`ID_BIBLIO`, `ID_AUTHOR`,`TITLE`, `YEAR`, `JOURNAL`, `PUBLI_IN`) VALUES (NULL,'$IdAuthor','$title','$year','$journal','$year_publi')");


if (mysqli_query($con,$update)){
		echo "<h3>Database updated successfully</h3>";
	}
	
	else {
		echo "Error updating record: " . mysqli_error($con);
	}


	   }
	   ?>
