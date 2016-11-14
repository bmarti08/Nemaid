<?php
/*
 * Created on 8 january 2014 by Heia
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
<form method="post" action="addNewReferenceSpecies.php">
<label for="references"><h2>Complete the fields below to add a new reference</h2></label><br />
<table>
		<tr><td><label>Author</label> </td><td><input required type="text" name="author" /></td></tr>
		<tr>
        <td><label>Year</label> </td><td> <input type="text" name="year" /></td>
		</tr>
		<tr>
        <td><label>Published in</label> </td> <td><input type="text" name="year_publi" /></td>
		</tr>
		<tr>
        <td><label>Title</label> </td><td><input required type="text" name="title" /></td>
		</tr>
		<tr>
        <td><label>Journal</label> </td><td> <input type="text" name="journal" /></td>
		</tr>
</table>
	   <input type="submit" value="Submit">
</form>
