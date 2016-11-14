<?php

// On inclut les pages de connection à la BDD et des fonctions
include("connectionSQL.php");
include("connectionSQL.php");
include("includes/haut.php");
?>

<input type="button" name="Return" value="Return" onClick="document.location='visuBDD.php'" /><br />
<h2>List of species:</h2><br />
<div>Scroll down to the species of interest or enter its name below:</div><br/>

<form method="post" action="search_species.php">
   <div>
		<input name="specie" type="text" />
		<input type="submit" value="Go" />
   </div>
</form><br/>

<?php
$result = mysqli_query($con,"SELECT name_species from SPECIES");

echo "<table border='1'>
<tr>
<th>List of Species</th>
</tr>";

while($row = mysqli_fetch_array($result))
  {
  	
  	$nameSpecies = $row['name_species'];
  	$url = "visuBDDBySpecies.php?specie=";
  	$url .= $nameSpecies;
  echo "<tr>";
 // echo "<td>" ."<a href=$url target='_blank'>'$nameSpecies'</a> . </td>";
  echo "<td>" ."<a href='visuBDDBySpecies.php?nom=$nameSpecies'>$nameSpecies</a>. </td>";
  echo "</tr>";
  }
echo "</table>";

//Affichage de la table references à côté du tableau species

/* $result = mysql_query("SELECT `author`,`year`,`publi_in`,`title`,`journal` FROM `references`");

echo "<table border='1'>
<tr>
<th>Author</th>
<th>Year</th>
<th>Date_publi</th>
<th>Title</th>
<th>Journal</th>'
</tr>";

while ($ligne = mysql_fetch_array($result)){
echo'<tr><td>';
echo $ligne['author'];
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

echo "</table>"; */


?>