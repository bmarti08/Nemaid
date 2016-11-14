<?php

// On inclut les pages de connection à la BDD et des fonctions
include("connectionSQL.php");
include("functions.php");
include("includes/haut.php");
?>

<input type="button" name="Return" value="Return" onClick="document.location='visuBDD.php'" /><br />
<h2>List of characters:</h2><br />

<?php

//Affichage de la table characters

$result = mysqli_query($con,"SELECT name_character,entitled_character,explaination,weight,correction_factor,min_character,max_character,nb_state 
FROM CHARACTER1 natural join IS_COMPOUND_BY natural join ANALYSIS natural join MIN_MAX");

echo "<table border='1'>
<tr>
<th>name character</th>
<th>entitled character</th>
<th>explanations</th>
<th>weight</th>
<th>correction</th>
<th>min</th>
<th>max</th>
<th>nb_states</th>

</tr>";

while ($row = mysqli_fetch_array($result)){
echo "<tr>";

	echo "<td>" .$row['name_character'] . "</td>";
	echo "<td>" .$row['entitled_character'] . "</td>";
	echo "<td>" .$row['explaination'] . "</td>";
	echo "<td>" .$row['weight'] . "</td>";
	echo "<td>" .$row['correction_factor'] . "</td>";
	echo "<td>" .$row['min_character'] . "</td>";
	echo "<td>" .$row['max_character'] . "</td>";
	echo "<td>" .$row['nb_state'] . "</td>";
	
	
	echo "</tr>";
}

echo "</table>";


?>