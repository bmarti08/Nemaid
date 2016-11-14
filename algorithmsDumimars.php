<?php
	include('includes/haut.php');
	connexion_bdd();
	
	// Récupération des données de l'utilisateur
	$genus_name = define_genus();
	
	//if(isset($_POST['user_sample'])) {
		$user_sample = get_xml_data('user_sample',$_POST['user_sample']);		
	//} elseif(isset($_POST['database_sample'])) { 
	//	$user_sample = $_POST['database_sample'];
	//} else {
	//	$informations = Array(true,'You must choose a sample to perform a comparison.',ROOTPATH.'/comparaison.php',5);
	//	require_once('informations.php');
	//	exit();
	//}

	$_SESSION['results'] = array();
	//appel de l'algorithme de comparaison
	Algo32($genus_name, $user_sample);
	
	arsort($_SESSION['results']);
	mysql_close();

//fonction de l'algorithme de comparaison
function Algo32($genus_name, $user_sample){	
				
	$species = mysql_query('SELECT code_spe, specie 	
				FROM species');
				
	while($spe = mysql_fetch_array($species)){
	
		// Création indice selon le code espèce (<=> "Ccode_spe") pour stockage des résultats dans le tableau $results 
		$index = 'spe'.$spe[0];
			
		// Initialisation de variables	
		$_SESSION['results'][$index]['coef'] = 0; // somme des Si*Wi ($temp*Wi calculé pour chaque caractère)
		$weight_sum = 0; // somme des Wi
		$temp = 0; // coefficient de similarité calculé (avant multiplication par le poids (Wi))
	
		$characters = mysql_query('SELECT code_char 	
				FROM characters WHERE name_genus="'.$genus_name.'"');
				
		//parours des characters d'un genus
		while ($code_char = mysql_fetch_array($characters)){
				$Mxi = $user_sample[''.$code_char[0].'']['value'];
				// Caractère quantitatifs!!
				$N = mysql_query("	SELECT sum(equation4 * Wi) as presque5, sum(Wi) as WiS
									FROM
									(
										SELECT
											(1- N/(rang-Ci)) as equation4, Wi
										FROM
										(
											SELECT GREATEST(abs('".$Mxi."'-Ms)-Ci,0) as N, (max-min) as rang, Ci, Wi
											FROM valeurAlgoQuantitatif
											WHERE my_character = '".$code_char[0]."' and code_spe = '".$spe[0]."'
										)
										as equation1et2
									)
									as suivant
									
								");

				if ($N != null){
				while($rev = mysql_fetch_array($N))
				{
					$weight_sum = $weight_sum + $rev['WiS'];
					//echo ' Wi : '.$rev['WiS'].'    ; presque5 :  '.$rev['presque5'].'</br>';
					$temp = $temp + $rev['presque5'];
				}
				}
			}
			if ($weight_sum!=0){$_SESSION['results'][$index]['coef'] = $temp/$weight_sum;}
			echo 'spe : '.$spe[0].'  ; result : '.$_SESSION['results'][$index]['coef'].'</br>';
	}
}
?>