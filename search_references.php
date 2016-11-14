<?php

include("connectionSQL.php");
include("includes/haut.php");

$name=$_POST['author'];
echo "<h2> $name </h2>";
$result = mysqli_query($con,"SELECT name_author,year,publi_in,title,journal FROM BIBLIO_REF natural join AUTHOR WHERE name_author like '%$name%' ");
//$result = "SELECT `author`,`year`,`publi_in`,`title`,`journal` FROM `references` WHERE `author` like '%$name%' ";
//echo '<INPUT TYPE="text" name="ahaha" value="'.$result.'">';


	
	echo "<table border='1'>
<tr>
<th>Author(s)</th>
<th>Year</th>
<th>Publi_in</th>
<th>title</th>
<th>journal</th>
</tr>";

	while ($row = mysqli_fetch_array($result)){
	
	echo "<tr>";

	echo "<td>" .$row['name_author'] . "</td>";
	echo "<td>" .$row['year'] . "</td>";
	echo "<td>" .$row['publi_in'] . "</td>";
	echo "<td>" .$row['title'] . "</td>";
	echo "<td>" .$row['journal'] . "</td>";
	
	echo "</tr>";
	
}

echo "</table>";
?>
