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
<form method="post" action="">
<label for="references"><h2>Search area</h2></label><br />
<table>
		<tr><td><label>By author</label></td><td><input type="text" name="author" /></td></tr>
</table>
	   <input type="submit" value="Submit">
</form>
<form method="post" action="">
<table>
		<tr><td><label>By title</label></td><td><input type="text" name="title" /></td></tr>
</table>
	   <input type="submit" value="Submit">
</form>


<?php

?>
<form method="post" action="updateReferences.php">

</table>
			<table border="1">
			<tr><h3>Characters in the database :</h3></tr>
			<tr>
				<th></th>
				<th >Author</th>
				<th>Title</th>
				<th>Year</th>				
				<th>Published in</th>
				<th>Journal</th>
			</tr>
<?php

if(empty($_POST['author']) && empty($_POST['title'])){
$requete=mysqli_query($con,"SELECT id_biblio, title, year, publi_in, journal, name_author FROM biblio_ref natural join author");


while($row = mysqli_fetch_array($requete))
{
	echo "<tr>";
	$id=$row['id_biblio'];
	$title=$row['title'];
	$title=str_replace('"',"'",$title);
	$author=$row['name_author'];
	$author=str_replace('"',"'",$author);
	$journal=$row['journal'];
	$journal=str_replace('"',"'",$journal);
	echo "<td>" ."<input type='checkbox' name='id' value='".$id."' />"."</td>";
	echo '<td>' . '<textarea name="authorSet'.$id.'" cols="30" rows="7">'.$author.'</textarea>'  . '</td>';
	echo '<td>' . '<textarea name="titleSet'.$id.'" cols="30" rows="7">'.$title.'</textarea>'  . '</td>';
	echo "<td>" . "<INPUT TYPE='text' name='yearSet".$id."' size='4' value='".$row['year']."'>"  . "</td>";
	echo "<td>" . "<INPUT TYPE='text' name='publi_inSet".$id."' size='4' value='".$row['publi_in']."'>"  . "</td>";
	echo '<td>' . '<textarea name="journalSet'.$id.'" cols="30" rows="7">'.$journal.'</textarea>'  . '</td>';
	echo "</tr>";
}
}
if(isset($_POST['author']) && empty($_POST['title'])) {
$author=$_POST['author'];
$result = mysqli_query($con,"SELECT id_biblio,title, year, publi_in, journal, name_author FROM biblio_ref natural join author where name_author like'%$author%'");


while($row1 = mysqli_fetch_array($result))
{
	echo "<tr>";
	$id=$row1['id_biblio'];
	$title=$row1['title'];
	$title=str_replace('"',"'",$title);
	$author=$row1['name_author'];
	$author=str_replace('"',"'",$author);
	$journal=$row1['journal'];
	$journal=str_replace('"',"'",$journal);
	echo "<td>" ."<input type='checkbox' name='id' value='".$id."' />"."</td>";
	echo '<td>' . '<INPUT TYPE="text" name="authorSet'.$id.'" size="40" value="'.$author.'">'  . '</td>';
	echo '<td>' . '<INPUT TYPE="text" name="titleSet'.$id.'" size="50" value="'.$title.'">'  . '</td>';
	echo "<td>" . "<INPUT TYPE='text' name='yearSet".$id."' size='4' value='".$row1['year']."'>"  . "</td>";
	echo "<td>" . "<INPUT TYPE='text' name='publi_inSet".$id."' size='4' value='".$row1['publi_in']."'>"  . "</td>";
	echo '<td>' . '<INPUT TYPE="text" name="journalSet'.$id.'" size="50" value="'.$journal.'">'  . '</td>';
	echo "</tr>";
}
}

if(isset($_POST['title']) && empty($_POST['author'])) {
$title=$_POST['title'];
$result2 = mysqli_query($con,"SELECT id_biblio, title, year, publi_in, journal, name_author FROM biblio_ref natural join author WHERE title like '%$title%'");

while($row1 = mysqli_fetch_array($result2))
{
	echo "<tr>";
	$id=$row1['id_biblio'];
	$title=$row1['title'];
	$title=str_replace('"',"'",$title);
	$author=$row1['name_author'];
	$author=str_replace('"',"'",$author);
	$journal=$row1['journal'];
	$journal=str_replace('"',"'",$journal);
	echo "<td>" ."<input type='checkbox' name='id' value='".$id."' />"."</td>";
	echo '<td>' . '<INPUT TYPE="text" name="authorSet'.$id.'" size="40" value="'.$author.'">'  . '</td>';
	echo '<td>' . '<INPUT TYPE="text" name="titleSet'.$id.'" size="50" value="'.$title.'">'  . '</td>';
	echo "<td>" . "<INPUT TYPE='text' name='yearSet".$id."' size='4' value='".$row1['year']."'>"  . "</td>";
	echo "<td>" . "<INPUT TYPE='text' name='publi_inSet".$id."' size='4' value='".$row1['publi_in']."'>"  . "</td>";
	echo '<td>' . '<INPUT TYPE="text" name="journalSet'.$id.'" size="50" value="'.$journal.'">'  . '</td>';
	echo "</tr>";
}
}

?>
<input type="submit" value="Update">
</form>