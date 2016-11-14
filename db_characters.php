<?php
include('includes/haut.php');
include('connectionSQL.php');
include("functions.php");
/*
 * Created on 17 01 2014 by Manon Forconi
 * */
 ?>
<center><h1>The database management</h1></center><br />
<?php
include("menu_database_manage.php");
?>
<?php
echo "<h2> Characters in the database : </h2>";

	?>							
	<form method="POST" action="db_characters_update.php">	 



</table>
			<table border="1">
			<tr><h3>Characters in the database :</h3></tr>
			<tr>
				<th></th>
				<th >code</th>
				<th>Name</th>
				<th>Explanations</th>				
				<th>Weight</th>
				<th>Correction factors</th>
				<th>Min Value</th>
				<th>Maw Value</th>
				<th>number of States</th>
			</tr>
<?php
	$reponse = mysqli_query($con,"SELECT id_character, entitled_character, name_character, explaination, weight, correction_factor, min_character, max_character, nb_state FROM character1 natural join is_compound_by natural join analysis natural join min_max group by name_character");

	while ($row = mysqli_fetch_array($reponse))
	{

	
	echo "<tr>";
	$id=$row['id_character'];
	$entitled_character=$row['entitled_character'];
	$entitled_character=str_replace('"',"'",$entitled_character);
	$name_character=$row['name_character'];
	$name_character=str_replace('"',"'",$name_character);
	$explaination=$row['explaination'];
	$explaination=str_replace('"',"'",$explaination);
	echo "<td>" ."<input type='checkbox' name='id' value='".$id."' />"."</td>";
	echo '<td>'.$row['name_character'].'</td>';
	echo '<td>' . '<textarea name="entitled_characterSet'.$id.'" cols="30" rows="7">'.$entitled_character.'</textarea>'  . '</td>';
	echo '<td>' . '<textarea name="explainationSet'.$id.'" cols="30" rows="7">'.$explaination.'</textarea>'  . '</td>';
	echo "<td>" . "<INPUT TYPE='text' name='weightSet".$id."' size='4' value='".$row['weight']."'>"  . "</td>";
	echo "<td>" . "<INPUT TYPE='text' name='correction_factorSet".$id."' size='6' value='".$row['correction_factor']."'>"  . "</td>";
	echo "<td>" . "<INPUT TYPE='text' name='min_characterSet".$id."' size='4'  value='".$row['min_character']."'>"  . "</td>";
	echo "<td>" . "<INPUT TYPE='text' name='max_characterSet".$id."' size='4' value='".$row['max_character']."'>"  . "</td>";
	echo "<td>" . "<INPUT TYPE='text' name='nb_stateSet".$id."' size='4' value='".$row['nb_state']."'>"  . "</td>";
	echo "</tr>";
	
	}
	?>
	<input type="submit" value="Update">
	</table>
