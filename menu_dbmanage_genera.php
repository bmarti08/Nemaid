<?php
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
<td class ="menu"><a href="addNewGenera.php">Add a new genus</a></td>
<td class ="menu"><a href="visuBddByGenera.php">Find a genus</a></td>
<tr>
</table>
</center>