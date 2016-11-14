<?php include('includes/haut.php');
include("connectionSQL.php");

/* if(!(empty($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['file']['tmp_name'])) && isset($_POST)){


  $file = $_FILES['file']['tmp_name'];   // Le fichier téléversé
  if($_POST['file_type'] == 'params') { 
	$dest = '/_NEMAID/users_files/user'.$_SESSION['user_id'].'_params.xml'; // Sa destination
	
  } elseif($_POST['file_type'] == 'sample') {
	// Incrémentation du nombre de fichier sample du user présent sur le serveur
	if(!isset($_SESSION['nb_sample_saved'])) $_SESSION['nb_sample_saved'] = 1;
	else $_SESSION['nb_sample_saved']++;
	
	// Création du nom du nouveau fichier sample
	if(!substr_count($_FILES['file']['name'],$_SESSION['user_id']."_sample")){
		$_SESSION['my_file']=$_SESSION['nb_sample_saved'].'-user'.$_SESSION['user_id'].'_sample$'.$_FILES['file']['name'];
		$dest = '/_NEMAID/users_files/'.$_SESSION['nb_sample_saved'].'-user'.$_SESSION['user_id'].'_sample$'.$_FILES['file']['name']; // Sa destination
	}
	else {
		if(substr_count(substr($_FILES['file']['name'],2),'-')) {
		$_SESSION['my_file']=$_SESSION['nb_sample_saved'].'-'.substr($_FILES['file']['name'],2);
		$dest = '/_NEMAID/users_files/'.$_SESSION['nb_sample_saved'].'-'.substr($_FILES['file']['name'],2);
		}
		else {
		$_SESSION['my_file']=$_SESSION['nb_sample_saved'].'-'.$_FILES['file']['name'];	
		$dest = '/_NEMAID/users_files/'.$_SESSION['nb_sample_saved'].'-'.$_FILES['file']['name'];
		}
	}
  
  } else {
	$informations = Array(true,'Download not permitted.',ROOTPATH.'/new_sample.php',5);
	$_SESSION['my_file']=NULL;
	require_once('informations.php');
	exit();
  }

  $conn_id = ftp_connect(FTP_SERVER);   // Création de la connexion au serveur FTP

  if(empty($conn_id)) {
    $informations = Array(true,'Download failed... Problems with ftp server (error f001). <br /> Please contact the administrator if this problem continues.',ROOTPATH.'/new_sample.php',5);
	$_SESSION['my_file']=NULL;
	require_once('informations.php');
	exit();
  } else {
    // Définition du délai de connexion
    ftp_set_option($conn_id, FTP_TIMEOUT_SEC, CONFIG_TIMEOUT);

    //echo 'Connecté au serveur FTP.<br/>';
        
    // Identification avec le nom d'utilisateur et le mot de passe
    $login_result = ftp_login($conn_id, FTP_USERNAME, FTP_PASSWORD);

    if(!$login_result) {
    //  echo 'Échec d\'identification à ' . FTP_SERVER;
		$informations = Array(true,'Download failed... Problems with ftp server (error f002). <br /> Please contact the administrator if this problem continues.',ROOTPATH.'/new_sample.php',5);
		$_SESSION['my_file']=NULL;
		require_once('informations.php');
		exit();
    } else {
      // Tentative de chargement sur le serveur FTP
      if(ftp_put($conn_id, $dest, $file, FTP_BINARY)) {		
		$informations = Array(false,'File downloaded with success.',ROOTPATH.'/new_sample.php',3);
		require_once('informations.php');
		exit();
	  } else {
        $informations = Array(true,'You must first choose a file (using "Parcourir") before clicking on Upload. <br /> Please contact the administrator if this problem continues.',ROOTPATH.'/new_sample.php',5);
		$_SESSION['my_file']=NULL;
		require_once('informations.php');
		exit();
      }
	}
    // Fermeture de la connexion
    ftp_close($conn_id);
  }
} else {
	$informations = Array(true,'Download failed... Problems with ftp server (error f000). <br /> Please contact the administrator if this problem continues.',ROOTPATH.'/new_sample.php',5);
	$_SESSION['my_file']=NULL;
	require_once('informations.php');
	exit();
} */

$genus_name = $_POST['genus_name'];



$dossier = 'C:\wamp\www\_NEMAID\users_files';
$fichier = basename($_FILES['avatar']['name']);
$taille_maxi = 100000;
$taille = filesize($_FILES['avatar']['tmp_name']);
$extensions = array('.xml');
$extension = strrchr($_FILES['avatar']['name'], '.'); 
//Début des vérifications de sécurité...
if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
{
     $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...';
}
if($taille>$taille_maxi)
{
     $erreur = 'Le fichier est trop gros...';
}
if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
{
     //On formate le nom du fichier ici...
     $fichier = strtr($fichier, 
          'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
          'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
     $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
       if(move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
     {
          echo 'Upload effectué avec succès !';
     }
     else //Sinon (la fonction renvoie FALSE).
     {
          echo 'Echec de l\'upload !';
     }  
}
else
{
     echo $erreur;
};
$f='C:\wamp\www\_NEMAID\users_files\38-user2_sample.xml'; 

//$file=file_get_contents($f);
//echo"$file";


$xml = simplexml_load_file($f);








?>
<table border="1">
<tr><h3>Quantitative characters</h3></tr>
						<tr>Enter your sample data in the column "Values". Weights and correction factors are used for the
						computation of the similarity coefficient. You can change the default values at will or set all 
						weights and/or correction factors if you prefer to use non weighted data.</tr>
						<tr>
							<th >Characters</th>
							<th>Values</th>				
							<th>Weights</th>
							<th>Correction factors</th>
						</tr>
<?php	
						foreach($xml as $node){


$tableau1 = array ($node->value_Q);
$tableau2 = array ($node->name_Quantitative);
$tableau3 = array ($node->weight_Q);
$tableau4 = array ($node->correction_Q);

$var = 'tableau1';
$var2 = 'tableau2';
$var3 = 'tableau3';
$var4 = 'tableau4';
$nb_elements = count (${$var});
$nb_elements2 = count (${$var2});
$nb_elements3 = count (${$var3});
$nb_elements4 = count (${$var4});
for ($i=0; $i<$nb_elements2; $i++) {
	// on accede aux éléments du tableau $tableau1
	$nb=${$var}[$i];
	$nb2=${$var2}[$i];
	$nb3=${$var3}[$i];
	$nb4=${$var4}[$i];
	//echo ${$var}[$i].'<br />';


							/* $query1 = mysqli_query($con,"select id_character from min_max natural join genus where name_genus ='$genus_name'");
							while ($row = mysqli_fetch_array($query1)){
								$idCharacter=$row['id_character'];
								$query2 = mysqli_query($con,"select entitled_character, explaination,weight, correction_factor 
							from character1 natural join is_compound_by natural join analysis 
							where quantitative=true and id_character='$idCharacter' group by name_character"); */
								
							
							
							/* while($row = mysqli_fetch_row($query)){
							$code_char=$row[0];
							if(isset($valeur)){
							$val=$user_sample[$code_char]['value'];
							/* if($user_sample!=NULL){
							$val=$user_sample[$code_char]['value']; */
							//}
							//else{
							//$val='';
							//} 
								/* if($use_user_params) {
									$weight = $user_params[(string)$row["code_char"]]['weight'];
									$correction = $user_params[(string)$row["code_char"]]['correction'];
									$explanations = $user_params[(string)$row["code_char"]]['explanations'];
									$rangeValue = $รง[(string)$row["code_char"]]['rangeValue'];
								} else {
									$weight = sprintf('%.2f',round($row["weight"],2));
									$correction = sprintf('%.2f',round($row["correction"],2));
									$rangeValue = sprintf('%.2f',round($row["rangeValue"],2));
									$explanations = $user_params[(string)$row["code_char"]]['explanations'];
								} */
								/* while ($row2 = mysqli_fetch_array($query2))
			{
									$weight=$row2['weight'];
									$correction=$row2['correction_factor']; */

				if(nb)					
									echo "<tr>";

				echo "<td><b>" .$nb2 . "</b></td>";
				//echo "<td>" .$row2['explaination'] . "</td>";
				echo '<td>' . '<INPUT TYPE="text" name="ValueSet"  value="'.$nb.'">'  . '</td>';
				echo '<td>' . '<INPUT TYPE="text" name="WeightSet"  value="'.$nb3.'">'  . '</td>';
				echo '<td>' . '<INPUT TYPE="text" name="WeightSet" value="'.$nb4.'">'  . '</td>';

				
				
				echo "</tr>";
								}
							}
						?>
						
							<tr>
							<th></th>
							<th></th>
							
							<td>
								<input type="button" value="Set all to 1" onclick="allto1('qt_weight')">
								<br/>
								<input type="button" value="Defaults values" onclick="default_values('qt_weight')">
							</td>
							<td>
								<input type="button" value="Defaults values" onclick="default_values('qt_correction')">
							</td>
							<!--<td>
								<input type="button" value="Calculate range" onclick="default_values('qt_rangeValue')">
							</td> -->
						</tr>
						</table>
						<table border="1">

						<tr><h3><br />Qualitative characters</h3>
						</tr>
						<tr>For each qualitative character, enter each state separately as the percentage of specimens 
						presenting that state.
						Percentages must be entered as decimal values, not as percents (e.g. enter 0.57 instead of 57%).</tr>
						<tr>
							<th>Characters </th>
							<th>Values</th>				
							<th>Weights</th>
							<th>Correction factors</th>
						</tr>
						<?php
						
							foreach($xml as $node){


$tableau1 = array ($node->value_NoQ);
$tableau2 = array ($node->name_NoQuantitative);
$tableau3 = array ($node->weight_NoQ);
$tableau4 = array ($node->correction_NoQ);

$var = 'tableau1';
$var2 = 'tableau2';
$var3 = 'tableau3';
$var4 = 'tableau4';
$nb_elements = count (${$var});
$nb_elements2 = count (${$var2});
$nb_elements3 = count (${$var3});
$nb_elements4 = count (${$var4});
for ($i=0; $i<$nb_elements2; $i++) {
	// on accede aux éléments du tableau $tableau1
	$nb=${$var}[$i];
	$nb2=${$var2}[$i];
	$nb3=${$var3}[$i];
	$nb4=${$var4}[$i];
	//echo ${$var}[$i].'<br />';

						
						
											
								/* $query1 = mysqli_query($con,"select id_character from min_max natural join genus where name_genus ='$genus_name'");
							while ($row = mysqli_fetch_array($query1)){
								$idCharacter=$row['id_character'];
								$query2 = mysqli_query($con,"select COUNT(*) AS id_char, entitled_character, explaination,weight, correction_factor 
							from character1 natural join is_compound_by natural join analysis 
							where quantitative=false and id_character='$idCharacter' group by entitled_character"); */
							
							
							
							/* while($row = mysqli_fetch_row($query)){
							$code_char=$row[0];
							if(isset($valeur)){
							$val=$user_sample[$code_char]['value'];
							/* if($user_sample!=NULL){
							$val=$user_sample[$code_char]['value']; */
							//}
							//else{
							//$val='';
							//} 
								/* if($use_user_params) {
									$weight = $user_params[(string)$row["code_char"]]['weight'];
									$correction = $user_params[(string)$row["code_char"]]['correction'];
									$explanations = $user_params[(string)$row["code_char"]]['explanations'];
									$rangeValue = $รง[(string)$row["code_char"]]['rangeValue'];
								} else {
									$weight = sprintf('%.2f',round($row["weight"],2));
									$correction = sprintf('%.2f',round($row["correction"],2));
									$rangeValue = sprintf('%.2f',round($row["rangeValue"],2));
									$explanations = $user_params[(string)$row["code_char"]]['explanations'];
								} */
			/* 					while ($row2 = mysqli_fetch_array($query2))
			{ */
									//$weight=$row2['weight'];
									//$correction=$row2['correction_factor'];

									
			
	
	/* foreach($xml as $node) {
    //$corr   = (string)$node->correction;
	//$weight   = (string)$node->weight;
	$value   = (string)$node->value;
	$val=$value[2];
	echo"$val "; */

						
							/* while ($row2 = mysqli_fetch_array($query2)){ */
						
			
					
					
					
   

				echo "<tr>";

				echo "<td><b>" .$nb2 . "</b></td>";		
				//echo "<td>" .$row2['explaination'] . "</td>";
				
				echo '<td>' . '<INPUT TYPE="text" name="Value2Set" required pattern="0\.\d{2}|NULL"  title="example 0.53 = 53%" value="'.$nb.'">'  . '</td>';
				
				echo '<td>' . '<INPUT TYPE="text" name="Weight2Set" value="'.$nb3.'">'  . '</td>';
				echo '<td>' . '<INPUT TYPE="text" name="Corr2Set" value="'.$nb4.'">'  . '</td>';
				
				
				echo "</tr>";
								
							
							}
							
							}			
	//}
							//}
							
							
							?>
							
						
					</table>
					<br/><br/>
					<input type="hidden" name="file_type" value="sample">
					<input type="submit" value="Save sample" > 
				</form>
				</ul>
			</div>