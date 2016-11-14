<?php

// On inclut les pages de connection à la BDD et des fonctions
include("connectionSQL.php");
include("functions.php");
include("includes/haut.php");
?>

<input type="button" name="Return" value="Return" onClick="document.location='visuBDD.php'" /><br />
<h2>List of articles:</h2><br />
<div>Scroll down to the article of interest or enter the name of an author below:</div><br/>

<form method="post" action="search_references.php">
   <div>
	  <input name="author" type="text" />
	  <input type="submit" value="Go" />
   </div>
</form><br/>

<?php

//Affichage de la table references à côté du tableau species

$result = mysqli_query($con,"SELECT `name_author`,`year`,`publi_in`,`title`,`journal` FROM `BIBLIO_REF` natural join AUTHOR");

echo "<table border='1'>
<tr>
<th>Author</th>
<th>Year</th>
<th>Publi in</th>
<th>Title</th>
<th>Journal</th>
</tr>";

while ($ligne = mysqli_fetch_array($result)){
echo'<tr><td>';
echo $ligne['name_author'];
echo'</td>';
echo'<td>';
echo $ligne['year'];
echo'<td>';
echo $ligne['publi_in'];
echo'</td>';
echo'<td>';
echo $ligne['title'];
echo'</td>';
echo'<td>';
echo $ligne['journal'];
echo'</td></tr>';
}

echo "</table>";


?>