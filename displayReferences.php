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
