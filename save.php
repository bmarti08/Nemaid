<?php
include('includes/haut.php');
include("connectionSQL.php");
if(isset($_POST)) {
	extract($_POST);
	/* file_type = champs caché dans les formulaires (au niveau des boutons submit)
	 * Permet de savoir quel type de fichier doit être sauvegardé
	 * parameters => fichier contenant les parametres de d'utilisateur
	 * sample => contient les données du sample a analyser
	 * genus => affiche juste un message d'information pour indiquer que le genre a bien été défini
	 * Les fichiers sont unique pour un user et supprimés à la déconnexion
	 */
	 	 /*$_SESSION['my_file']=NULL;*/
	if ($file_type == 'parameters') {
		generate_xml_file($genus);
		echo 'Your parameters have been saved temporaly on server.'; // <br /><a href="'.ROOTPATH.'/download.php?s=0">Click here to download</a> it on your own computer.';
		
	} elseif ($file_type == 'sample') {
		$genus_name = define_genus();
		if(isset($_SESSION['nb_sample_saved'])) $_SESSION['nb_sample_saved']++;
		else $_SESSION['nb_sample_saved'] = 1;		
		save_user_sample($genus_name, $sample_id, $sample_date, $remarks);
?>		
		<h3>Your sample have been saved on server</h3>
		<?php
		//echo 'Your sample have been saved on server.'; 
		
		//echo '<br /><a href="'.ROOTPATH.'/download.php?s='.$_SESSION['nb_sample_saved'].'">Click here to download</a> it on your own computer.';

		//echo '</br> <a href="new_sample_download.php">Click here to download</a> it on your own computer. </br>';
		
		//echo 'To save xml file on your own computer, click on "<u>Display yours data entry</u>" button. After displaying the file, right click anywhere on the page and save the file.';
	 	echo '<br><br>';
		echo '<A href="../_NEMAID/'.$_SESSION['current_name'].'.xml" target="_blank">Display yours data entry</A> ';
		echo '<br>';
		echo"(After displaying the file, right click on the page and save the file)";
		echo '<br><br>'; 
		
	} elseif ($file_type == 'genus') {
		if(isset($genus) && $genus != '') {
			$_SESSION['genus_n'] = $genus;
		}
	
		$informations = Array(false,'Genus set !',ROOTPATH.'/main.php',3);
		require_once('informations.php');
		exit();
	}
	
	//echo '<p align="center"><img src="/Nemaid/images/screenXml.png" height="450" width="700" border="3" title="After displaying the file, right click on the page and save the file"></p>';
		
	 		
		//modifications par manon forconi (début)
		
		//modifications ajoutées pour l'affichage des résultats :
		
		$error=0; //comptabilise le nombre total d'erreurs dans le tableau
		{ //on recré un formulaire pour que l'utilisateur puisse corriger directement?>
		<form name="new_sample" action="save.php" method="post">
		<?php }
		
		//echo 'Saved data; Errors are noted in red';
		echo '<br><br>';
		echo '
		<table>
			<tr>
				<th>Characters</th>
				<th>Values</th>
				<th>Weight</th>
				<th>Correction Factors</th>
			</tr>';
			
			$query1 = mysqli_query($con,"select id_character from MIN_MAX natural join GENUS where name_genus ='$genus_name'");
				while ($row = mysqli_fetch_array($query1)){
					$idCharacter=$row['id_character'];
					$query2 = mysqli_query($con,"select entitled_character, explaination,weight, correction_factor 
				from CHARACTER1 natural join IS_COMPOUND_BY natural join ANALYSIS 
				where quantitative=false and id_character='$idCharacter' ");
				
				$query3 = mysqli_query($con,"select entitled_character, explaination,weight, correction_factor 
				from CHARACTER1 natural join IS_COMPOUND_BY natural join ANALYSIS 
				where quantitative=true and id_character='$idCharacter' ");
		
		
		while ($row3 = mysqli_fetch_array($query3))
{
						$weight=$row3['weight'];
						$correction=$row3['correction_factor'];
						$value=$_POST['ValueSet'.$idCharacter.''];
						//echo"$fcorrection";
			echo "<tr>";

				echo "<td>" .$row3['entitled_character'] . "</td>";
				echo '<td>'  .$value  . '</td>';
				echo '<td>' .$weight.'</td>';
				echo '<td>' .$correction.'</td>';
				
				
				echo "</tr>";
}
		
		while ($row2 = mysqli_fetch_array($query2))
{
						$weight=$row2['weight'];
						$correction=$row2['correction_factor'];
						$value=$_POST['Value2Set'.$idCharacter.''];
						//echo"$fcorrection";
			echo "<tr>";

				echo "<td>" .$row2['entitled_character'] . "</td>";
				echo '<td>'  .$value  . '</td>';
				echo '<td>' .$weight.'</td>';
				echo '<td>' .$correction.'</td>';
				
				
				echo "</tr>";			
						
		
		/* if (is_numeric(substr($row[1],-1))) $row[1] = substr($row[1],0,-1);
		
		//on recupère les variables entrées précédemment
		$name = "$row[1] - $row[2]";
		//si la valeur de correction n'existe pas, on l'initialise à null (non renseignée)
		if (!isset($_POST[''.$row2[0].'_c'])) $fcorrection = 'NULL';
		else { $fcorrection = $_POST[''.$row2[0].'_c']; $_SESSION[''.$row2[0].'_c']=$_POST[''.$row2[0].'_c']; }
		if (!isset($_POST[''.$row[0].'_w'])) $weight = 'NULL';
		else { $weight = $_POST[''.$row[0].'_w']; $_SESSION[''.$row[0].'_w']=$_POST[''.$row[0].'_w']; }
		if (!isset($_POST[''.$row[0].'_v'])) $val = 'NULL';
		else {$val = $_POST[''.$row[0].'_v']; $_SESSION[''.$row[0].'_v']=$_POST[''.$row[0].'_v']; }
		
		echo"$fcorrection";
		echo '
			<tr> 
				<td> '.$name.'</td>';
		if ($val<0) { echo '<td><FONT COLOR="red" > '.$val.' </FONT></td>'; $error=$error+1; }
		else echo '<td> '.$val.' </td>';
		if ($weight<0) { echo '<td><FONT COLOR="red" > '.$weight.' </FONT></td>'; $error=$error+1; }
		else echo '<td> '.$weight.' </td>';
		if ($fcorrection<0) { echo '<td><FONT COLOR="red" > '.$fcorrection.' </FONT></td>'; $error=$error+1; }
		else echo '<td> '.$fcorrection.' </td>';		
		echo '</tr>'; */
}
		
		}
		echo '</table>';
		if ($error !=0 ) {echo 'Number of error : '.$error.'</br>';}
		{ ?>
		<br/><br/>
		<input type=hidden name="gen" value=$genus> 
		<input type="button" name="Return" value="Save a new sample" onClick="document.location='new_sample.php'" /><br />
		<input type="hidden" name="genus" value="$genus_name">
		
		<?php }
		mysqli_close($con);
		//------------------------------- (fin)
}
?>