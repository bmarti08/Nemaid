
<?php
		include('includes/haut.php');
		include("connectionSQL.php");
	connexion_bdd();
	
	// Récupération des données de l'utilisateur
	$genus_name = define_genus();
	
	if(isset($_POST['user_sample'])) {
		$user_sample = get_xml_data('user_sample',$_POST['user_sample']);		
	} 
	else {
		$informations = Array(true,'You must choose a sample to perform a comparison.',ROOTPATH.'/comparaison.php',5);
		require_once('informations.php');
		exit();
	}

	$_SESSION['results']= array();
	$result=$_SESSION['results'];
	
	// Création de la condition d'inclusion des espèces invalides
	if(!isset($_POST['validity'])) { $validity_condition = 'and validity != "0"';
	} else $validity_condition = '';
	
	// Appel de l'algo de comparaison selon le type de description cochée par l'utilisateur
	if(isset($_POST['choix']) && isset($_POST['choixAlgoVersion'])) { 
		$_SESSION['res_type'] = $_POST['choix'];
		$_SESSION['algoVersion'] = $_POST['choixAlgoVersion'];
		if ($_POST['choix'] == 'composite') {
				echo '<h2>'.'<br />'.'COMPOSITE COMPARISON</h2>'.'</br>';
				echo 'The comparison can take a few seconds...';
				AlgoComposite32($genus_name, $validity_condition, $user_sample);
		} elseif($_POST['choix'] == 'mixed') {
				//echo "mixed compositeAlgo31() & simpleAlgo31()".'</br>';
				echo '<h2>'.'<br />'.'ORIGINAL COMPARISON</h2>'.'</br>';
				echo 'The comparison can take a few seconds...';
				AlgoOriginal32($genus_name, true, $validity_condition, $user_sample);
				echo '<h2>'.'<br />'.'COMPOSITE COMPARISON</h2>'.'</br>';
				echo 'The comparison can take a few seconds...';
				AlgoComposite32($genus_name, $validity_condition, $user_sample);
		} else 
		{ // $_POST['choix'] == 'all ' ou 'originale'
			if($_POST['choix'] == 'originale') {
					echo '<h2>'.'<br />'.'ONLY ORIGINAL COMPARISON</h2>'.'</br>';
					echo 'The comparison can take a few seconds...';
					AlgoOriginal32($genus_name, true, $validity_condition, $user_sample);
			} else { // $_POST['choix'] == 'all'
					echo '<h2>'.'<br />'.'ALL COMPARISON (NO COMPOSITE DESCRIPTIONS)</h2>'.'</br>';
					echo 'The comparison can take a few seconds...';
					AlgoIndiv32($genus_name, false, $validity_condition, $user_sample);
			}
		}
	}

	mysqli_close($con);

//fonction de l'algorithme de comparaison
function AlgoIndiv32($genus_name, $only_original, $validity_condition, $user_sample){
		if($only_original==false){
		$original_condition = '';
		$condition1='group by id';
		}
		$characters = mysqli_query($con,'SELECT name_character 	
				FROM character1 natural join min_max natural join genus WHERE name_genus="'.$genus_name.'"');
			
		//parours des characters d'un genus
		while ($code_char = mysqli_fetch_array($characters)){
				$Mxi = $user_sample[''.$code_char[0].'']['value'];
				// Caractère quantitatifs!!
				$quantitatif=mysqli_query($con,"SELECT (Si*Wi) as SiWi, code_spe, my_character, Wi, id, Si, validity, pop_type, Ms
									FROM
									(
									SELECT
									(1- N/(rang-Ci)) as Si, code_spe, Wi, my_character,id, validity, pop_type, Ms
									FROM
									(
									SELECT GREATEST(abs($Mxi-Ms)-Ci,0) as N, Ms, (max-min) as rang, Ci, Wi, code_spe, my_character,id, validity, pop_type
									FROM (SELECT idChar AS my_character, idData AS id, valeur AS Ms, weight AS Wi, min AS Min, correction AS Ci, max AS Max, name_genus, code_spe, validity, pop_type
FROM ((SELECT 'LON' as idChar, id_data as idData, LON as valeur FROM data)
UNION
(SELECT 'STY' as idChar, id_data as idData, STY as valeur FROM data)
UNION
(SELECT 'DGO' as idChar, id_data as idData, DGO as valeur FROM data)
UNION
(SELECT 'EXPO' as idChar, id_data as idData, EXPO as valeur FROM data)
UNION
(SELECT 'BAW' as idChar, id_data as idData, BAW as valeur FROM data)
UNION
(SELECT 'TAIL' as idChar, id_data as idData, TAIL as valeur FROM data)
UNION
(SELECT 'TAN' as idChar, id_data as idData, TAN as valeur FROM data)
UNION
(SELECT 'PHAS' as idChar, id_data as idData, PHAS as valeur FROM data)
UNION
(SELECT 'a' as idChar, id_data as idData, a as valeur FROM data)
UNION
(SELECT 'c' as idChar, id_data as idData, c as valeur FROM data)
UNION
(SELECT 'c_bis' as idChar, id_data as idData, c_bis as valeur FROM data)
UNION
(SELECT 'm' as idChar, id_data as idData, m as valeur FROM data)
UNION
(SELECT 'v' as idChar, id_data as idData, v as valeur FROM data)
UNION
(SELECT 'SPIC' as idChar, id_data as idData, SPIC as valeur FROM data)
UNION
(SELECT 'MALES1' as idChar, id_data as idData, MALES1 as valeur FROM data)
UNION
(SELECT 'DISC1' as idChar, id_data as idData, DISC1 as valeur FROM data)
UNION
(SELECT 'CAN1' as idChar, id_data as idData, CAN1 as valeur FROM data)
UNION
(SELECT 'HAB1' as idChar, id_data as idData, HAB1 as valeur FROM data)
UNION
(SELECT 'HAB2' as idChar, id_data as idData, HAB2 as valeur FROM data)
UNION
(SELECT 'LIP1' as idChar, id_data as idData, LIP1 as valeur FROM data)
UNION
(SELECT 'LIP2' as idChar, id_data as idData, LIP2 as valeur FROM data)
UNION
(SELECT 'INC1' as idChar, id_data as idData, INC1 as valeur FROM data)
UNION
(SELECT 'INC2' as idChar, id_data as idData, INC2 as valeur FROM data)
UNION
(SELECT 'LANN1' as idChar, id_data as idData, LANN1 as valeur FROM data)
UNION
(SELECT 'LANN2' as idChar, id_data as idData, LANN2 as valeur FROM data)
UNION
(SELECT 'LANN3' as idChar, id_data as idData, LANN3 as valeur FROM data)
UNION
(SELECT 'KBS1' as idChar, id_data as idData, KBS1 as valeur FROM data)
UNION
(SELECT 'KBS2' as idChar, id_data as idData, KBS2 as valeur FROM data)
UNION
(SELECT 'KBS3' as idChar, id_data as idData, KBS3 as valeur FROM data)
UNION
(SELECT 'TSH1' as idChar, id_data as idData, TSH1 as valeur FROM data)
UNION
(SELECT 'TSH2' as idChar, id_data as idData, TSH2 as valeur FROM data)
UNION
(SELECT 'TSH3' as idChar, id_data as idData, TSH3 as valeur FROM data)
UNION
(SELECT 'TSH4' as idChar, id_data as idData, TSH4 as valeur FROM data)
UNION
(SELECT 'GENB1' as idChar, id_data as idData, GENB1 as valeur FROM data)
UNION
(SELECT 'GENB2' as idChar, id_data as idData, GENB2 as valeur FROM data)
UNION
(SELECT 'GENB3' as idChar, id_data as idData, GENB3 as valeur FROM data)) as mavue JOIN characters ON mavue.idChar = characters.code_char JOIN define ON mavue.idData=define.id_data
WHERE characters.nb_states = 1 and min>0
ORDER BY idData) as vue
									WHERE my_character = '".$code_char[0]."' 
									$validity_condition
									$original_condition
									)
									as equation1et2
									)
									as suivant $condition1");
				//$req=mysql_query("insert into test(requete_sql) values('".str_replace("'", '"', $quantitatif)."');");;
				if ($quantitatif != null){
				while($rev = mysql_fetch_array($quantitatif))
				{
				// echo '--------------------------------------------'.'</br>';
				// echo 'Id data :'.$rev['id'].'</br>';
				// echo 'Character :'.$rev['my_character'].'</br>';
				// echo 'N :'.$rev['N'].'</br>';
				// echo 'Valeur du caractère Mx :'.$Mxi.'</br>';
				// echo 'Valeur caractère échantillon Ms :'.$rev['Ms'].'</br>';
				// echo 'Si :'.$rev['Si'].'</br>';
				// echo 'Wi :'.$rev['Wi'].'</br>';
				// echo '--------------------------------------------'.'</br>';
				if($rev['Si'] !=null or $rev['Si']>-1){
					$result[$rev['id']][$rev['my_character']]['Si']=$rev['Si'];
					$result[$rev['id']][$rev['my_character']]['SiWi']=$rev['SiWi'];
					$result[$rev['id']][$rev['my_character']]['Wi']=$rev['Wi'];
					$result[$rev['id']]['sum_siwi']+=$result[$rev['id']][$rev['my_character']]['SiWi'];
					$result[$rev['id']]['sum_wi']+=$result[$rev['id']][$rev['my_character']]['Wi'];
				// echo '--------------------------------------------'.'</br>';
				// echo 'SiWi :'.$result[$rev['id']][$rev['my_character']]['SiWi'].'</br>';
				// echo 'Sum SiWi :'.$result[$rev['id']]['sum_siwi'].'</br>';
				// echo 'Sum Wi :'.$result[$rev['id']]['sum_wi'].'</br>';
				// echo '--------------------------------------------'.'</br>';
				}
				else{
				$result[$rev['id']][$rev['my_character']]['Si']=0;
				$result[$rev['id']][$rev['my_character']]['SiWi']=0;
				}
				
				}
			}

			$qualitatif = mysql_query("	
									SELECT code_spe, my_character, Wi, id, Si, nb_states, N, Ci, Ms, validity, pop_type
									FROM
									(
									SELECT
									(1- N/(rang-Ci)) as Si, code_spe, Wi, my_character,id, nb_states, N, Ci, Ms, validity, pop_type
									FROM
									(
									SELECT GREATEST(abs($Mxi-Ms)-Ci,0) as N, (max-min) as rang, Ci, Wi, code_spe, my_character,id, nb_states, Ms, validity, pop_type
									FROM (SELECT code_char AS my_character, idData AS id, valeur AS Ms, weight AS Wi, min AS Min, correction AS Ci, max AS Max, name_genus, code_spe, nb_states, validity, pop_type
FROM ((SELECT 'LON' as idChar, id_data as idData, LON as valeur FROM data)
UNION
(SELECT 'STY' as idChar, id_data as idData, STY as valeur FROM data)
UNION
(SELECT 'DGO' as idChar, id_data as idData, DGO as valeur FROM data)
UNION
(SELECT 'EXPO' as idChar, id_data as idData, EXPO as valeur FROM data)
UNION
(SELECT 'BAW' as idChar, id_data as idData, BAW as valeur FROM data)
UNION
(SELECT 'TAIL' as idChar, id_data as idData, TAIL as valeur FROM data)
UNION
(SELECT 'TAN' as idChar, id_data as idData, TAN as valeur FROM data)
UNION
(SELECT 'PHAS' as idChar, id_data as idData, PHAS as valeur FROM data)
UNION
(SELECT 'a' as idChar, id_data as idData, a as valeur FROM data)
UNION
(SELECT 'c' as idChar, id_data as idData, c as valeur FROM data)
UNION
(SELECT 'c_bis' as idChar, id_data as idData, c_bis as valeur FROM data)
UNION
(SELECT 'm' as idChar, id_data as idData, m as valeur FROM data)
UNION
(SELECT 'v' as idChar, id_data as idData, v as valeur FROM data)
UNION
(SELECT 'SPIC' as idChar, id_data as idData, SPIC as valeur FROM data)
UNION
(SELECT 'MALES1' as idChar, id_data as idData, MALES1 as valeur FROM data)
UNION
(SELECT 'DISC1' as idChar, id_data as idData, DISC1 as valeur FROM data)
UNION
(SELECT 'CAN1' as idChar, id_data as idData, CAN1 as valeur FROM data)
UNION
(SELECT 'HAB1' as idChar, id_data as idData, HAB1 as valeur FROM data)
UNION
(SELECT 'HAB2' as idChar, id_data as idData, HAB2 as valeur FROM data)
UNION
(SELECT 'LIP1' as idChar, id_data as idData, LIP1 as valeur FROM data)
UNION
(SELECT 'LIP2' as idChar, id_data as idData, LIP2 as valeur FROM data)
UNION
(SELECT 'INC1' as idChar, id_data as idData, INC1 as valeur FROM data)
UNION
(SELECT 'INC2' as idChar, id_data as idData, INC2 as valeur FROM data)
UNION
(SELECT 'LANN1' as idChar, id_data as idData, LANN1 as valeur FROM data)
UNION
(SELECT 'LANN2' as idChar, id_data as idData, LANN2 as valeur FROM data)
UNION
(SELECT 'LANN3' as idChar, id_data as idData, LANN3 as valeur FROM data)
UNION
(SELECT 'KBS1' as idChar, id_data as idData, KBS1 as valeur FROM data)
UNION
(SELECT 'KBS2' as idChar, id_data as idData, KBS2 as valeur FROM data)
UNION
(SELECT 'KBS3' as idChar, id_data as idData, KBS3 as valeur FROM data)
UNION
(SELECT 'TSH1' as idChar, id_data as idData, TSH1 as valeur FROM data)
UNION
(SELECT 'TSH2' as idChar, id_data as idData, TSH2 as valeur FROM data)
UNION
(SELECT 'TSH3' as idChar, id_data as idData, TSH3 as valeur FROM data)
UNION
(SELECT 'TSH4' as idChar, id_data as idData, TSH4 as valeur FROM data)
UNION
(SELECT 'GENB1' as idChar, id_data as idData, GENB1 as valeur FROM data)
UNION
(SELECT 'GENB2' as idChar, id_data as idData, GENB2 as valeur FROM data)
UNION
(SELECT 'GENB3' as idChar, id_data as idData, GENB3 as valeur FROM data)) as mavue JOIN characters ON mavue.idChar = characters.code_char JOIN define ON mavue.idData=define.id_data
WHERE min=0 and max=1
ORDER BY idData) as vue
									WHERE my_character = '".$code_char[0]."' 
									$validity_condition
									$original_condition
									)
									as equation1et2
									)
									as suivant $condition1");
				if ($qualitatif != null){
				while($resultat = mysql_fetch_array($qualitatif))
				{
				$code=substr(''.$resultat['my_character'].'', 0, -1);
				// Stockage du score pour un état et un caractère
				// echo '--------------------------------------------'.'</br>';
				// echo 'Code spe :'.$resultat['code_spe'].'</br>';
				// echo 'Character :'.$resultat['my_character'].'</br>';
				// echo 'N :'.$resultat['N'].'</br>';
				// echo 'Valeur du caractère Mx :'.$Mxi.'</br>';
				// echo 'Valeur caractère échantillon Ms :'.$resultat['Ms'].'</br>';
				// echo 'Si :'.$resultat['Si'].'</br>';
				// echo 'Wi :'.$resultat['Wi'].'</br>';
				// echo '--------------------------------------------'.'</br>';
				if($resultat['Si'] !=null or $resultat['Si'] >-1){
					// Nombre d'état pour chaque caractère
				$result[$resultat['id']][$code]['etat']=$result[$resultat['id']][$code]['etat']+1;
				$result[$resultat['id']][$code]['Si']+=$resultat['Si'];
					}	
				
				}
				}
				$final = mysql_query("	
									SELECT code_spe, my_character, Wi, id, Si, nb_states, N, Ci, Ms, validity, pop_type
									FROM
									(
									SELECT
									(1- N/(rang-Ci)) as Si, code_spe, Wi, my_character,id, nb_states, N, Ci, Ms, validity, pop_type
									FROM
									(
									SELECT GREATEST(abs($Mxi-Ms)-Ci,0) as N, (max-min) as rang, Ci, Wi, code_spe, my_character,id, nb_states, Ms, validity, pop_type
									FROM (SELECT code_char AS my_character, idData AS id, valeur AS Ms, weight AS Wi, min AS Min, correction AS Ci, max AS Max, name_genus, code_spe, nb_states, validity, pop_type
FROM ((SELECT 'LON' as idChar, id_data as idData, LON as valeur FROM data)
UNION
(SELECT 'STY' as idChar, id_data as idData, STY as valeur FROM data)
UNION
(SELECT 'DGO' as idChar, id_data as idData, DGO as valeur FROM data)
UNION
(SELECT 'EXPO' as idChar, id_data as idData, EXPO as valeur FROM data)
UNION
(SELECT 'BAW' as idChar, id_data as idData, BAW as valeur FROM data)
UNION
(SELECT 'TAIL' as idChar, id_data as idData, TAIL as valeur FROM data)
UNION
(SELECT 'TAN' as idChar, id_data as idData, TAN as valeur FROM data)
UNION
(SELECT 'PHAS' as idChar, id_data as idData, PHAS as valeur FROM data)
UNION
(SELECT 'a' as idChar, id_data as idData, a as valeur FROM data)
UNION
(SELECT 'c' as idChar, id_data as idData, c as valeur FROM data)
UNION
(SELECT 'c_bis' as idChar, id_data as idData, c_bis as valeur FROM data)
UNION
(SELECT 'm' as idChar, id_data as idData, m as valeur FROM data)
UNION
(SELECT 'v' as idChar, id_data as idData, v as valeur FROM data)
UNION
(SELECT 'SPIC' as idChar, id_data as idData, SPIC as valeur FROM data)
UNION
(SELECT 'MALES1' as idChar, id_data as idData, MALES1 as valeur FROM data)
UNION
(SELECT 'DISC1' as idChar, id_data as idData, DISC1 as valeur FROM data)
UNION
(SELECT 'CAN1' as idChar, id_data as idData, CAN1 as valeur FROM data)
UNION
(SELECT 'HAB1' as idChar, id_data as idData, HAB1 as valeur FROM data)
UNION
(SELECT 'HAB2' as idChar, id_data as idData, HAB2 as valeur FROM data)
UNION
(SELECT 'LIP1' as idChar, id_data as idData, LIP1 as valeur FROM data)
UNION
(SELECT 'LIP2' as idChar, id_data as idData, LIP2 as valeur FROM data)
UNION
(SELECT 'INC1' as idChar, id_data as idData, INC1 as valeur FROM data)
UNION
(SELECT 'INC2' as idChar, id_data as idData, INC2 as valeur FROM data)
UNION
(SELECT 'LANN1' as idChar, id_data as idData, LANN1 as valeur FROM data)
UNION
(SELECT 'LANN2' as idChar, id_data as idData, LANN2 as valeur FROM data)
UNION
(SELECT 'LANN3' as idChar, id_data as idData, LANN3 as valeur FROM data)
UNION
(SELECT 'KBS1' as idChar, id_data as idData, KBS1 as valeur FROM data)
UNION
(SELECT 'KBS2' as idChar, id_data as idData, KBS2 as valeur FROM data)
UNION
(SELECT 'KBS3' as idChar, id_data as idData, KBS3 as valeur FROM data)
UNION
(SELECT 'TSH1' as idChar, id_data as idData, TSH1 as valeur FROM data)
UNION
(SELECT 'TSH2' as idChar, id_data as idData, TSH2 as valeur FROM data)
UNION
(SELECT 'TSH3' as idChar, id_data as idData, TSH3 as valeur FROM data)
UNION
(SELECT 'TSH4' as idChar, id_data as idData, TSH4 as valeur FROM data)
UNION
(SELECT 'GENB1' as idChar, id_data as idData, GENB1 as valeur FROM data)
UNION
(SELECT 'GENB2' as idChar, id_data as idData, GENB2 as valeur FROM data)
UNION
(SELECT 'GENB3' as idChar, id_data as idData, GENB3 as valeur FROM data)) as mavue JOIN characters ON mavue.idChar = characters.code_char JOIN define ON mavue.idData=define.id_data
WHERE min=0 and max=1
ORDER BY idData) as vue
									WHERE my_character = '".$code_char[0]."' 
									$validity_condition
									$original_condition
									)
									as equation1et2
									)
									as suivant $condition1");

				if ($final != null){
				while($reponse = mysql_fetch_array($final))
				{
				$code=substr(''.$reponse['my_character'].'', 0, -1);
				// Stockage du score pour un état et un caractère
				if(substr(''.$reponse['my_character'].'', -1, 1)==$reponse['nb_states']){
				// echo '--------------------------------------------'.'</br>';
				// echo 'Id data :'.$reponse['id'].'</br>';
				// echo 'Character :'.$reponse['my_character'].'</br>';
				// echo 'Sum Si for this character:'.$result[$reponse['id']][$code]['Si'].'</br>';
				// echo '--------------------------------------------'.'</br>';
					
					// Moyenne des scores
					// JUSTE!!!!!!!!!
	
					$result[$reponse['id']][$code]['Si']=$result[$reponse['id']][$code]['Si']/$result[$reponse['id']][$code]['etat'];
					// echo 'Moyenne score :'.$result[$reponse['id']][$code]['Si'].'</br>';
					if($result[$reponse['id']][$code]['Si']!=null or $result[$reponse['id']][$code]['Si']>-1){
					$result[$reponse['id']][$code]['Wi']=$reponse['Wi'];
					}
					else{
					$result[$reponse['id']][$code]['Wi']=0;
					}
					// echo 'Wi :'.$result[$reponse['id']][$code]['Wi'].'</br>';
					// Calcul de SiWi
					// JUUUSSTTTEEE!!!!!!!!!!
					$result[$reponse['id']][$code]['SiWi']=$result[$reponse['id']][$code]['Si']*$result[$reponse['id']][$code]['Wi'];
					// echo 'SiWi :'.$result[$reponse['id']][$code]['SiWi'].'</br>';
					
					// Somme des SiWi
					$result[$reponse['id']]['sum_siwi']+=$result[$reponse['id']][$code]['SiWi'];
					// echo 'Somme SiWi :'.$result[$reponse['id']]['sum_siwi'].'</br>';
					
					// Somme des poids
					$result[$reponse['id']]['sum_wi']+=$result[$reponse['id']][$code]['Wi'];
					// echo 'Somme Wi :'.$result[$reponse['id']]['sum_wi'].'</br>';
				}	
				}
				}
}
	if(isset($_POST['validity'])) {
		$condition= '';
		}
	elseif(!isset($_POST['validity'])){
	$condition = 'where validity!="0"';
	}
$data=mysql_query("Select id_data, specie, validity,pop_type from species join define on define.code_spe=species.code_spe $condition order by id_data");
$data1=mysql_query("Select id_data, specie, validity,pop_type from species join define on define.code_spe=species.code_spe $condition order by id_data");
?>
				<h3><br /> Best Results (Coefficient of similarity superior or equal to 95%)</h3>
				<table>
				<tr>
				<td width="500px" align=center><b>Species</b></td>
				<td width="500px" align=center><b>Identification number of data</b></td>
				<td width="500px" align=center><b>Sum score*weight</b></td>
				<td width="500px" align=center><b>Sum of weights</b></td>
				<td width="500px" align=center><b>Coefficient of similarity</b></td>
				</tr>
<?php

while($rep = mysql_fetch_array($data1)){

$taux=$result[$rep['id_data']]['sum_siwi']/$result[$rep['id_data']]['sum_wi'];
if($taux>=0){
$result[$rep['id_data']]['coefficient']=sprintf('%.2f',$taux);;
}
else{
$result[$rep['id_data']]['coefficient']=0;
}
if($result[$rep['id_data']]['sum_siwi']!=0 and $result[$rep['id_data']]['coefficient']>=0.95){
				echo '	<tr>';
				if($result[$rep['id_data']]['coefficient']==1){
				echo '<td width="500px" align=center style="background-color: #FF4000">'.$rep['specie'].'</td>
				<td width="500px" align=center style="background-color: #FF4000">'.$rep['id_data'].'</td>
				<td width="500px" align=center style="background-color: #FF4000">'.round($result[$rep['id_data']]['sum_siwi'],2).'</td>
				<td width="500px" align=center style="background-color: #FF4000">'.round($result[$rep['id_data']]['sum_wi'],2).'</td>
				<td width="500px" align=center style="background-color: #FF4000">'.$result[$rep['id_data']]['coefficient'].'</td>';
				}
				else{
				echo '<td width="500px" align=center>'.$rep['specie'].'</td>
				<td width="500px" align=center>'.$rep['id_data'].'</td>
				<td width="500px" align=center>'.round($result[$rep['id_data']]['sum_siwi'],2).'</td>
				<td width="500px" align=center>'.round($result[$rep['id_data']]['sum_wi'],2).'</td>
				<td width="500px" align=center>'.$result[$rep['id_data']]['coefficient'].'</td>';
				}
				echo '</tr>';
				}
				}
				echo '</table>';
		echo '
				<h3><br /> All results</h3>
				<table>
				<tr>
				<td width="500px" align=center><b>Species</b></td>
				<td width="500px" align=center><b>Identification number of data</b></td>
				<td width="500px" align=center><b>Sum score*weight</b></td>
				<td width="500px" align=center><b>Sum of weights</b></td>
				<td width="500px" align=center><b>Coefficient of similarity</b></td>
				</tr>';

while($row = mysql_fetch_array($data)){
$taux=$result[$row['id_data']]['sum_siwi']/$result[$row['id_data']]['sum_wi'];
if($taux>=0){
$result[$row['id_data']]['coefficient']=sprintf('%.2f',$taux);
}
else{
$result[$row['id_data']]['coefficient']=0;
}
if($result[$row['id_data']]['sum_siwi']!=0 ){
				echo '	<tr>
				<td width="500px" align=center>'.$row['specie'].'</td>
				<td width="500px" align=center>'.$row['id_data'].'</td>
				<td width="500px" align=center>'.round($result[$row['id_data']]['sum_siwi'],2).'</td>
				<td width="500px" align=center>'.round($result[$row['id_data']]['sum_wi'],2).'</td>
				<td width="500px" align=center>'.$result[$row['id_data']]['coefficient'].'</td>
				</tr>';
				}
				}
echo '</table>';
				}
?>
<?php function AlgoOriginal32($genus_name, $only_original, $validity_condition, $user_sample){
	if ($only_original){
		$original_condition = 'and pop_type="T" group by code_spe';
	}
		$characters = mysql_query('SELECT code_char 	
				FROM characters WHERE name_genus="'.$genus_name.'"');
			
		//parours des characters d'un genus
		while ($code_char = mysql_fetch_array($characters)){
				$Mxi = $user_sample[''.$code_char[0].'']['value'];
				// Caractère quantitatifs!!
				$quantitatif=mysql_query("SELECT (Si*Wi) as SiWi, code_spe, moy, my_character, Wi, id, Si, validity, pop_type, N
									FROM
									(
									SELECT
									(1- (N/(rang-Ci))) as Si, code_spe, Wi, moy, my_character,id, validity, pop_type, N
									FROM
									(
									SELECT GREATEST(abs($Mxi-avg(Ms))-Ci,0) as N, avg(Ms) as moy, (max-min) as rang, Ci, Wi, code_spe, my_character,id, validity, pop_type
									FROM (SELECT idChar AS my_character, idData AS id, valeur AS Ms, weight AS Wi, min AS Min, correction AS Ci, max AS Max, name_genus, code_spe, validity, pop_type
FROM ((SELECT 'LON' as idChar, id_data as idData, LON as valeur FROM data)
UNION
(SELECT 'STY' as idChar, id_data as idData, STY as valeur FROM data)
UNION
(SELECT 'DGO' as idChar, id_data as idData, DGO as valeur FROM data)
UNION
(SELECT 'EXPO' as idChar, id_data as idData, EXPO as valeur FROM data)
UNION
(SELECT 'BAW' as idChar, id_data as idData, BAW as valeur FROM data)
UNION
(SELECT 'TAIL' as idChar, id_data as idData, TAIL as valeur FROM data)
UNION
(SELECT 'TAN' as idChar, id_data as idData, TAN as valeur FROM data)
UNION
(SELECT 'PHAS' as idChar, id_data as idData, PHAS as valeur FROM data)
UNION
(SELECT 'a' as idChar, id_data as idData, a as valeur FROM data)
UNION
(SELECT 'c' as idChar, id_data as idData, c as valeur FROM data)
UNION
(SELECT 'c_bis' as idChar, id_data as idData, c_bis as valeur FROM data)
UNION
(SELECT 'm' as idChar, id_data as idData, m as valeur FROM data)
UNION
(SELECT 'v' as idChar, id_data as idData, v as valeur FROM data)
UNION
(SELECT 'SPIC' as idChar, id_data as idData, SPIC as valeur FROM data)
UNION
(SELECT 'MALES1' as idChar, id_data as idData, MALES1 as valeur FROM data)
UNION
(SELECT 'DISC1' as idChar, id_data as idData, DISC1 as valeur FROM data)
UNION
(SELECT 'CAN1' as idChar, id_data as idData, CAN1 as valeur FROM data)
UNION
(SELECT 'HAB1' as idChar, id_data as idData, HAB1 as valeur FROM data)
UNION
(SELECT 'HAB2' as idChar, id_data as idData, HAB2 as valeur FROM data)
UNION
(SELECT 'LIP1' as idChar, id_data as idData, LIP1 as valeur FROM data)
UNION
(SELECT 'LIP2' as idChar, id_data as idData, LIP2 as valeur FROM data)
UNION
(SELECT 'INC1' as idChar, id_data as idData, INC1 as valeur FROM data)
UNION
(SELECT 'INC2' as idChar, id_data as idData, INC2 as valeur FROM data)
UNION
(SELECT 'LANN1' as idChar, id_data as idData, LANN1 as valeur FROM data)
UNION
(SELECT 'LANN2' as idChar, id_data as idData, LANN2 as valeur FROM data)
UNION
(SELECT 'LANN3' as idChar, id_data as idData, LANN3 as valeur FROM data)
UNION
(SELECT 'KBS1' as idChar, id_data as idData, KBS1 as valeur FROM data)
UNION
(SELECT 'KBS2' as idChar, id_data as idData, KBS2 as valeur FROM data)
UNION
(SELECT 'KBS3' as idChar, id_data as idData, KBS3 as valeur FROM data)
UNION
(SELECT 'TSH1' as idChar, id_data as idData, TSH1 as valeur FROM data)
UNION
(SELECT 'TSH2' as idChar, id_data as idData, TSH2 as valeur FROM data)
UNION
(SELECT 'TSH3' as idChar, id_data as idData, TSH3 as valeur FROM data)
UNION
(SELECT 'TSH4' as idChar, id_data as idData, TSH4 as valeur FROM data)
UNION
(SELECT 'GENB1' as idChar, id_data as idData, GENB1 as valeur FROM data)
UNION
(SELECT 'GENB2' as idChar, id_data as idData, GENB2 as valeur FROM data)
UNION
(SELECT 'GENB3' as idChar, id_data as idData, GENB3 as valeur FROM data)) as mavue JOIN characters ON mavue.idChar = characters.code_char JOIN define ON mavue.idData=define.id_data
WHERE characters.nb_states = 1 and min>0
ORDER BY idData) as vue
									WHERE my_character = '".$code_char[0]."' 
									$validity_condition
									$original_condition
									)
									as equation1et2
									)
									as suivant $condition1");
				//$req=mysql_query("insert into test(requete_sql) values('".str_replace("'", '"', $quantitatif)."');");;
				if ($quantitatif != null){
				while($rev = mysql_fetch_array($quantitatif))
				{
				// echo '--------------------------------------------'.'</br>';
				// echo 'Code spe :'.$rev['code_spe'].'</br>';
				// echo 'Character :'.$rev['my_character'].'</br>';
				// echo 'N :'.$rev['N'].'</br>';
				// echo 'Valeur du caractère Mx :'.$Mxi.'</br>';
				// echo 'Moyenne valeur échantillons Ms :'.$rev['moy'].'</br>';
				// echo 'Si :'.$rev['Si'].'</br>';
				// echo 'Wi :'.$rev['Wi'].'</br>';
				// echo '--------------------------------------------'.'</br>';
				if($rev['Si'] !=null or $rev['Si'] >-1){
					$result[$rev['code_spe']][$rev['my_character']]['Si']=round($rev['Si'],2);
					$result[$rev['code_spe']][$rev['my_character']]['SiWi']=round($rev['SiWi'],2);
					$result[$rev['code_spe']][$rev['my_character']]['Wi']=$rev['Wi'];
					$result[$rev['code_spe']]['sum_siwi']+=$result[$rev['code_spe']][$rev['my_character']]['SiWi'];
					$result[$rev['code_spe']]['sum_wi']+=$result[$rev['code_spe']][$rev['my_character']]['Wi'];
				// echo '--------------------------------------------'.'</br>';
				// echo 'SiWi :'.$result[$rev['code_spe']][$rev['my_character']]['SiWi'].'</br>';
				// echo 'Sum SiWi :'.$result[$rev['code_spe']]['sum_siwi'].'</br>';
				// echo 'Sum Wi :'.$result[$rev['code_spe']]['sum_wi'].'</br>';
				// echo '--------------------------------------------'.'</br>';
				}
				else{
				$result[$rev['code_spe']][$rev['my_character']]['Si']=0;
				$result[$rev['code_spe']][$rev['my_character']]['SiWi']=0;
				}
				
				}
			}

			$qualitatif = mysql_query("	
									SELECT code_spe, my_character, Wi, id, Si, moy, nb_states, N, Ci, Ms, validity, pop_type
									FROM
									(
									SELECT
									(1-(N/(rang-Ci))) as Si, code_spe, Wi, moy, my_character,id, nb_states, N, Ci, Ms, validity, pop_type
									FROM
									(
									SELECT GREATEST(abs($Mxi-avg(Ms))-Ci,0) as N, avg(Ms) as moy, (max-min) as rang, Ci, Wi, code_spe, my_character,id, nb_states, Ms, validity, pop_type
									FROM (SELECT code_char AS my_character, idData AS id, valeur AS Ms, weight AS Wi, min AS Min, correction AS Ci, max AS Max, name_genus, code_spe, nb_states, validity, pop_type
FROM ((SELECT 'LON' as idChar, id_data as idData, LON as valeur FROM data)
UNION
(SELECT 'STY' as idChar, id_data as idData, STY as valeur FROM data)
UNION
(SELECT 'DGO' as idChar, id_data as idData, DGO as valeur FROM data)
UNION
(SELECT 'EXPO' as idChar, id_data as idData, EXPO as valeur FROM data)
UNION
(SELECT 'BAW' as idChar, id_data as idData, BAW as valeur FROM data)
UNION
(SELECT 'TAIL' as idChar, id_data as idData, TAIL as valeur FROM data)
UNION
(SELECT 'TAN' as idChar, id_data as idData, TAN as valeur FROM data)
UNION
(SELECT 'PHAS' as idChar, id_data as idData, PHAS as valeur FROM data)
UNION
(SELECT 'a' as idChar, id_data as idData, a as valeur FROM data)
UNION
(SELECT 'c' as idChar, id_data as idData, c as valeur FROM data)
UNION
(SELECT 'c_bis' as idChar, id_data as idData, c_bis as valeur FROM data)
UNION
(SELECT 'm' as idChar, id_data as idData, m as valeur FROM data)
UNION
(SELECT 'v' as idChar, id_data as idData, v as valeur FROM data)
UNION
(SELECT 'SPIC' as idChar, id_data as idData, SPIC as valeur FROM data)
UNION
(SELECT 'MALES1' as idChar, id_data as idData, MALES1 as valeur FROM data)
UNION
(SELECT 'DISC1' as idChar, id_data as idData, DISC1 as valeur FROM data)
UNION
(SELECT 'CAN1' as idChar, id_data as idData, CAN1 as valeur FROM data)
UNION
(SELECT 'HAB1' as idChar, id_data as idData, HAB1 as valeur FROM data)
UNION
(SELECT 'HAB2' as idChar, id_data as idData, HAB2 as valeur FROM data)
UNION
(SELECT 'LIP1' as idChar, id_data as idData, LIP1 as valeur FROM data)
UNION
(SELECT 'LIP2' as idChar, id_data as idData, LIP2 as valeur FROM data)
UNION
(SELECT 'INC1' as idChar, id_data as idData, INC1 as valeur FROM data)
UNION
(SELECT 'INC2' as idChar, id_data as idData, INC2 as valeur FROM data)
UNION
(SELECT 'LANN1' as idChar, id_data as idData, LANN1 as valeur FROM data)
UNION
(SELECT 'LANN2' as idChar, id_data as idData, LANN2 as valeur FROM data)
UNION
(SELECT 'LANN3' as idChar, id_data as idData, LANN3 as valeur FROM data)
UNION
(SELECT 'KBS1' as idChar, id_data as idData, KBS1 as valeur FROM data)
UNION
(SELECT 'KBS2' as idChar, id_data as idData, KBS2 as valeur FROM data)
UNION
(SELECT 'KBS3' as idChar, id_data as idData, KBS3 as valeur FROM data)
UNION
(SELECT 'TSH1' as idChar, id_data as idData, TSH1 as valeur FROM data)
UNION
(SELECT 'TSH2' as idChar, id_data as idData, TSH2 as valeur FROM data)
UNION
(SELECT 'TSH3' as idChar, id_data as idData, TSH3 as valeur FROM data)
UNION
(SELECT 'TSH4' as idChar, id_data as idData, TSH4 as valeur FROM data)
UNION
(SELECT 'GENB1' as idChar, id_data as idData, GENB1 as valeur FROM data)
UNION
(SELECT 'GENB2' as idChar, id_data as idData, GENB2 as valeur FROM data)
UNION
(SELECT 'GENB3' as idChar, id_data as idData, GENB3 as valeur FROM data)) as mavue JOIN characters ON mavue.idChar = characters.code_char JOIN define ON mavue.idData=define.id_data
WHERE min=0 and max=1
ORDER BY idData) as vue
									WHERE my_character = '".$code_char[0]."' 
									$validity_condition
									$original_condition
									)
									as equation1et2
									)
									as suivant");
				if ($qualitatif != null){
				while($resultat = mysql_fetch_array($qualitatif))
				{
				$code=substr(''.$resultat['my_character'].'', 0, -1);
				// Stockage du score pour un état et un caractère
				// echo '--------------------------------------------'.'</br>';
				// echo 'Code spe :'.$resultat['code_spe'].'</br>';
				// echo 'Character :'.$resultat['my_character'].'</br>';
				// echo 'N :'.$resultat['N'].'</br>';
				// echo 'Valeur du caractère Mx:'.$Mxi.'</br>';
				// echo 'Moyenne valeur échantillons connus Ms :'.$resultat['moy'].'</br>';
				// echo 'Si :'.$resultat['Si'].'</br>';
				// echo 'Wi :'.$resultat['Wi'].'</br>';
				// echo '--------------------------------------------'.'</br>';
				if($resultat['Si'] !=null or $resultat['Si']>-1){
					// Nombre d'état pour chaque caractère
				$result[$resultat['code_spe']][$code]['etat']+=1;
				$result[$resultat['code_spe']][$code]['Si']+=$resultat['Si'];
					}
				// Stockage du poids
					// JUSTE!!!!!!!!!!!!
					
				}
				}
				$final = mysql_query("	
									SELECT code_spe, my_character, Wi, id, Si, nb_states, N, Ci, Ms, validity, pop_type
									FROM
									(
									SELECT
									(1-(N/(rang-Ci))) as Si, code_spe, Wi, my_character,id, nb_states, N, Ci, Ms, validity, pop_type
									FROM
									(
									SELECT GREATEST(abs($Mxi-avg(Ms))-Ci,0) as N, (max-min) as rang, Ci, Wi, code_spe, my_character,id, nb_states, Ms, validity, pop_type
									FROM (SELECT code_char AS my_character, idData AS id, valeur AS Ms, weight AS Wi, min AS Min, correction AS Ci, max AS Max, name_genus, code_spe, nb_states, validity, pop_type
FROM ((SELECT 'LON' as idChar, id_data as idData, LON as valeur FROM data)
UNION
(SELECT 'STY' as idChar, id_data as idData, STY as valeur FROM data)
UNION
(SELECT 'DGO' as idChar, id_data as idData, DGO as valeur FROM data)
UNION
(SELECT 'EXPO' as idChar, id_data as idData, EXPO as valeur FROM data)
UNION
(SELECT 'BAW' as idChar, id_data as idData, BAW as valeur FROM data)
UNION
(SELECT 'TAIL' as idChar, id_data as idData, TAIL as valeur FROM data)
UNION
(SELECT 'TAN' as idChar, id_data as idData, TAN as valeur FROM data)
UNION
(SELECT 'PHAS' as idChar, id_data as idData, PHAS as valeur FROM data)
UNION
(SELECT 'a' as idChar, id_data as idData, a as valeur FROM data)
UNION
(SELECT 'c' as idChar, id_data as idData, c as valeur FROM data)
UNION
(SELECT 'c_bis' as idChar, id_data as idData, c_bis as valeur FROM data)
UNION
(SELECT 'm' as idChar, id_data as idData, m as valeur FROM data)
UNION
(SELECT 'v' as idChar, id_data as idData, v as valeur FROM data)
UNION
(SELECT 'SPIC' as idChar, id_data as idData, SPIC as valeur FROM data)
UNION
(SELECT 'MALES1' as idChar, id_data as idData, MALES1 as valeur FROM data)
UNION
(SELECT 'DISC1' as idChar, id_data as idData, DISC1 as valeur FROM data)
UNION
(SELECT 'CAN1' as idChar, id_data as idData, CAN1 as valeur FROM data)
UNION
(SELECT 'HAB1' as idChar, id_data as idData, HAB1 as valeur FROM data)
UNION
(SELECT 'HAB2' as idChar, id_data as idData, HAB2 as valeur FROM data)
UNION
(SELECT 'LIP1' as idChar, id_data as idData, LIP1 as valeur FROM data)
UNION
(SELECT 'LIP2' as idChar, id_data as idData, LIP2 as valeur FROM data)
UNION
(SELECT 'INC1' as idChar, id_data as idData, INC1 as valeur FROM data)
UNION
(SELECT 'INC2' as idChar, id_data as idData, INC2 as valeur FROM data)
UNION
(SELECT 'LANN1' as idChar, id_data as idData, LANN1 as valeur FROM data)
UNION
(SELECT 'LANN2' as idChar, id_data as idData, LANN2 as valeur FROM data)
UNION
(SELECT 'LANN3' as idChar, id_data as idData, LANN3 as valeur FROM data)
UNION
(SELECT 'KBS1' as idChar, id_data as idData, KBS1 as valeur FROM data)
UNION
(SELECT 'KBS2' as idChar, id_data as idData, KBS2 as valeur FROM data)
UNION
(SELECT 'KBS3' as idChar, id_data as idData, KBS3 as valeur FROM data)
UNION
(SELECT 'TSH1' as idChar, id_data as idData, TSH1 as valeur FROM data)
UNION
(SELECT 'TSH2' as idChar, id_data as idData, TSH2 as valeur FROM data)
UNION
(SELECT 'TSH3' as idChar, id_data as idData, TSH3 as valeur FROM data)
UNION
(SELECT 'TSH4' as idChar, id_data as idData, TSH4 as valeur FROM data)
UNION
(SELECT 'GENB1' as idChar, id_data as idData, GENB1 as valeur FROM data)
UNION
(SELECT 'GENB2' as idChar, id_data as idData, GENB2 as valeur FROM data)
UNION
(SELECT 'GENB3' as idChar, id_data as idData, GENB3 as valeur FROM data)) as mavue JOIN characters ON mavue.idChar = characters.code_char JOIN define ON mavue.idData=define.id_data
WHERE min=0 and max=1
ORDER BY idData) as vue
									WHERE my_character = '".$code_char[0]."' 
									$validity_condition
									$original_condition
									)
									as equation1et2
									)
									as suivant");

				if ($final != null){
				while($reponse = mysql_fetch_array($final))
				{
				$code=substr(''.$reponse['my_character'].'', 0, -1);
				// Stockage du score pour un état et un caractère
				if(substr(''.$reponse['my_character'].'', -1, 1)==$reponse['nb_states']){
				// echo 'Code spe :'.$reponse['code_spe'].'</br>';
				// echo 'Character :'.$reponse['my_character'].'</br>';
				
					
					// Moyenne des scores
					// JUSTE!!!!!!!!!
	
					$result[$reponse['code_spe']][$code]['Si']=$result[$reponse['code_spe']][$code]['Si']/$result[$reponse['code_spe']][$code]['etat'];
					// echo 'Moyenne score :'.$result[$reponse['code_spe']][$code]['Si'].'</br>';
					if($result[$reponse['code_spe']][$code]['Si']!=null or $result[$reponse['code_spe']][$code]['Si']>-1){
					$result[$reponse['code_spe']][$code]['Wi']=$reponse['Wi'];
					}
					else{
					$result[$reponse['code_spe']][$code]['Wi']=0;
					}
					
					// Calcul de SiWi
					// JUUUSSTTTEEE!!!!!!!!!!
					$result[$reponse['code_spe']][$code]['SiWi']=$result[$reponse['code_spe']][$code]['Si']*$result[$reponse['code_spe']][$code]['Wi'];
					// echo 'SiWi :'.$result[$reponse['code_spe']][$code]['SiWi'].'</br>';
					
					// Somme des SiWi
					$result[$reponse['code_spe']]['sum_siwi']+=$result[$reponse['code_spe']][$code]['SiWi'];
					// echo 'Somme SiWi :'.$result[$reponse['code_spe']]['sum_siwi'].'</br>';
					
					// Somme des poids
					$result[$reponse['code_spe']]['sum_wi']+=$result[$reponse['code_spe']][$code]['Wi'];
					// echo 'Somme Wi :'.$result[$reponse['code_spe']]['sum_wi'].'</br>';
					// echo '--------------------------------------------'.'</br>';
					// echo 'Sum Si :'.$result[$reponse['code_spe']][$code]['Si'].'</br>';
					// echo 'Sum Wi :'.$result[$reponse['code_spe']][$code]['Wi'].'</br>';
					// echo '--------------------------------------------'.'</br>';
				
				}
				}
				}
}
if ($only_original and !isset($_POST['validity'])){
		$condition = 'where pop_type="T" and validity!="0" group by code_spe';
	} elseif($only_original==false and isset($_POST['validity'])) {
		$condition= '';
		}
	elseif($only_original and isset($_POST['validity'])){
	$condition = 'where pop_type="T" group by code_spe';
	}
	elseif($only_original==false and !isset($_POST['validity'])){
	$condition = 'where validity!="0" group by code_spe';
	}
$data=mysql_query("Select species.code_spe, specie, validity,pop_type 
from species join define on define.code_spe=species.code_spe 
$condition");
$data1=mysql_query("Select species.code_spe, specie, validity,pop_type 
from species join define on define.code_spe=species.code_spe 
$condition");
?>
<table>
				<h3><br />Best Results (Coefficient of similarity superior or equal to 95%)</h3>
				<table>
				<tr>
				<td width="500px" align=center><b>Species</b></td>
				<td width="500px" align=center><b>Code species</b></td>
				<td width="500px" align=center><b>Sum score*weight</b></td>
				<td width="500px" align=center><b>Sum of weights</b></td>
				<td width="500px" align=center><b>Coefficient of similarity</b></td>
				</tr>
<?php
while($rep = mysql_fetch_array($data1)){

$taux=$result[$rep['code_spe']]['sum_siwi']/$result[$rep['code_spe']]['sum_wi'];
if($taux>=0){
$result[$rep['code_spe']]['coefficient']=sprintf('%.2f',$taux);;
}
else{
$result[$rep['code_spe']]['coefficient']=0;
}
if($result[$rep['code_spe']]['sum_siwi']!=0 and $result[$rep['code_spe']]['coefficient']>=0.95){
				echo '	<tr>';
				if($result[$rep['code_spe']]['coefficient']==1){
				echo '<td width="500px" align=center style="background-color: #FF4000">'.$rep['specie'].'</td>
				<td width="500px" align=center style="background-color: #FF4000">'.$rep['code_spe'].'</td>
				<td width="500px" align=center style="background-color: #FF4000">'.round($result[$rep['code_spe']]['sum_siwi'],2).'</td>
				<td width="500px" align=center style="background-color: #FF4000">'.round($result[$rep['code_spe']]['sum_wi'],2).'</td>
				<td width="500px" align=center style="background-color: #FF4000">'.$result[$rep['code_spe']]['coefficient'].'</td>';
				}
				else{
				echo '<td width="500px" align=center>'.$rep['specie'].'</td>
				<td width="500px" align=center>'.$rep['code_spe'].'</td>
				<td width="500px" align=center>'.round($result[$rep['code_spe']]['sum_siwi'],2).'</td>
				<td width="500px" align=center>'.round($result[$rep['code_spe']]['sum_wi'],2).'</td>
				<td width="500px" align=center>'.$result[$rep['code_spe']]['coefficient'].'</td>';
				}
				echo '</tr>';
				}
				}
				echo '</table>';
		?>
		<table>
		<h3><br /> All Results </h3>
				<table>
				<tr>
				<td width="500px" align=center><b>Species</b></td>
				<td width="500px" align=center><b>Code species</b></td>
				<td width="500px" align=center><b>Sum score*weight</b></td>
				<td width="500px" align=center><b>Sum of weights</b></td>
				<td width="500px" align=center><b>Coefficient of similarity</b></td>
				</tr>
				
		<?php
while($row = mysql_fetch_array($data)){
$taux=$result[$row['code_spe']]['sum_siwi']/$result[$row['code_spe']]['sum_wi'];
if($taux>=0){
$result[$row['code_spe']]['coefficient']=sprintf('%.2f',$taux);;
}
else{
$result[$row['code_spe']]['coefficient']=0;
}
if($result[$row['code_spe']]['sum_siwi']!=0 ){
				echo '	<tr>
				<td width="500px" align=center>'.$row['specie'].'</td>
				<td width="500px" align=center>'.$row['code_spe'].'</td>
				<td width="500px" align=center>'.round($result[$row['code_spe']]['sum_siwi'],2).'</td>
				<td width="500px" align=center>'.round($result[$row['code_spe']]['sum_wi'],2).'</td>
				<td width="500px" align=center>'.$result[$row['code_spe']]['coefficient'].'</td>
				</tr>';
				}
				
				}
echo '</table>';
				}
?>


<?php function AlgoComposite32($genus_name, $validity_condition, $user_sample){	
		$characters = mysql_query('SELECT code_char 	
				FROM characters WHERE name_genus="'.$genus_name.'"');
			
		//parours des characters d'un genus
		while ($code_char = mysql_fetch_array($characters)){
				
				$Mxi = $user_sample[''.$code_char[0].'']['value'];
				// Caractère quantitatifs!!
				$quantitatif =mysql_query("	
									SELECT Si*Wi as SiWi, code_spe, my_character, Wi, Si, moy, N
									FROM
									(
									SELECT
									(1- N/(rang-Ci)) as Si, code_spe, Wi, my_character,id, moy, N
									FROM
									(
									SELECT GREATEST(abs($Mxi-avg(Ms))-Ci,0) as N, avg(Ms) as moy, (max-min) as rang, Ci, Wi, code_spe, my_character,id
									FROM (SELECT idChar AS my_character, idData AS id, valeur AS Ms, weight AS Wi, min AS Min, correction AS Ci, max AS Max, name_genus, code_spe, validity, pop_type
FROM ((SELECT 'LON' as idChar, id_data as idData, LON as valeur FROM data)
UNION
(SELECT 'STY' as idChar, id_data as idData, STY as valeur FROM data)
UNION
(SELECT 'DGO' as idChar, id_data as idData, DGO as valeur FROM data)
UNION
(SELECT 'EXPO' as idChar, id_data as idData, EXPO as valeur FROM data)
UNION
(SELECT 'BAW' as idChar, id_data as idData, BAW as valeur FROM data)
UNION
(SELECT 'TAIL' as idChar, id_data as idData, TAIL as valeur FROM data)
UNION
(SELECT 'TAN' as idChar, id_data as idData, TAN as valeur FROM data)
UNION
(SELECT 'PHAS' as idChar, id_data as idData, PHAS as valeur FROM data)
UNION
(SELECT 'a' as idChar, id_data as idData, a as valeur FROM data)
UNION
(SELECT 'c' as idChar, id_data as idData, c as valeur FROM data)
UNION
(SELECT 'c_bis' as idChar, id_data as idData, c_bis as valeur FROM data)
UNION
(SELECT 'm' as idChar, id_data as idData, m as valeur FROM data)
UNION
(SELECT 'v' as idChar, id_data as idData, v as valeur FROM data)
UNION
(SELECT 'SPIC' as idChar, id_data as idData, SPIC as valeur FROM data)
UNION
(SELECT 'MALES1' as idChar, id_data as idData, MALES1 as valeur FROM data)
UNION
(SELECT 'DISC1' as idChar, id_data as idData, DISC1 as valeur FROM data)
UNION
(SELECT 'CAN1' as idChar, id_data as idData, CAN1 as valeur FROM data)
UNION
(SELECT 'HAB1' as idChar, id_data as idData, HAB1 as valeur FROM data)
UNION
(SELECT 'HAB2' as idChar, id_data as idData, HAB2 as valeur FROM data)
UNION
(SELECT 'LIP1' as idChar, id_data as idData, LIP1 as valeur FROM data)
UNION
(SELECT 'LIP2' as idChar, id_data as idData, LIP2 as valeur FROM data)
UNION
(SELECT 'INC1' as idChar, id_data as idData, INC1 as valeur FROM data)
UNION
(SELECT 'INC2' as idChar, id_data as idData, INC2 as valeur FROM data)
UNION
(SELECT 'LANN1' as idChar, id_data as idData, LANN1 as valeur FROM data)
UNION
(SELECT 'LANN2' as idChar, id_data as idData, LANN2 as valeur FROM data)
UNION
(SELECT 'LANN3' as idChar, id_data as idData, LANN3 as valeur FROM data)
UNION
(SELECT 'KBS1' as idChar, id_data as idData, KBS1 as valeur FROM data)
UNION
(SELECT 'KBS2' as idChar, id_data as idData, KBS2 as valeur FROM data)
UNION
(SELECT 'KBS3' as idChar, id_data as idData, KBS3 as valeur FROM data)
UNION
(SELECT 'TSH1' as idChar, id_data as idData, TSH1 as valeur FROM data)
UNION
(SELECT 'TSH2' as idChar, id_data as idData, TSH2 as valeur FROM data)
UNION
(SELECT 'TSH3' as idChar, id_data as idData, TSH3 as valeur FROM data)
UNION
(SELECT 'TSH4' as idChar, id_data as idData, TSH4 as valeur FROM data)
UNION
(SELECT 'GENB1' as idChar, id_data as idData, GENB1 as valeur FROM data)
UNION
(SELECT 'GENB2' as idChar, id_data as idData, GENB2 as valeur FROM data)
UNION
(SELECT 'GENB3' as idChar, id_data as idData, GENB3 as valeur FROM data)) as mavue JOIN characters ON mavue.idChar = characters.code_char JOIN define ON mavue.idData=define.id_data
WHERE characters.nb_states = 1 and min>0
ORDER BY idData) as vue
									WHERE my_character = '".$code_char[0]."' 
									$validity_condition group by code_spe
									)
									as equation1et2
									)
									as suivant group by code_spe");

				if ($quantitatif != null){
				while($rev = mysql_fetch_array($quantitatif))
				{
				//echo '--------------------------------------------'.'</br>';
				//echo 'Code spe :'.$rev['code_spe'].'</br>';
				//echo 'Character :'.$rev['my_character'].'</br>';
				//echo 'N :'.$rev['N'].'</br>';
				//echo 'Valeur du caractère Mx :'.$Mxi.'</br>';
				//echo 'Moyenne valeur échantillons connus Ms:'.$rev['moy'].'</br>';
				//echo 'Si :'.$rev['Si'].'</br>';
				//echo 'Wi :'.$rev['Wi'].'</br>';
				
				//echo '--------------------------------------------'.'</br>';
				if($rev['Si'] !=null or $rev['Si'] >-1){
					$result[$rev['code_spe']][$rev['my_character']]['Si']=round($rev['Si'],2);
					$result[$rev['code_spe']][$rev['my_character']]['SiWi']=round($rev['SiWi'],2);
					$result[$rev['code_spe']][$rev['my_character']]['Wi']=$rev['Wi'];
					$result[$rev['code_spe']]['sum_siwi']+=$result[$rev['code_spe']][$rev['my_character']]['SiWi'];
					$result[$rev['code_spe']]['sum_wi']+=$result[$rev['code_spe']][$rev['my_character']]['Wi'];
				//echo '--------------------------------------------'.'</br>';
				//echo 'SiWi :'.$result[$rev['code_spe']][$rev['my_character']]['SiWi'].'</br>';
				//echo 'Sum SiWi :'.$result[$rev['code_spe']]['sum_siwi'].'</br>';
				//echo 'Sum Wi :'.$result[$rev['code_spe']]['sum_wi'].'</br>';
				//echo '--------------------------------------------'.'</br>';
				}
				else{
				$result[$rev['code_spe']][$rev['my_character']]['Si']=0;
				$result[$rev['code_spe']][$rev['my_character']]['SiWi']=0;
				}
				
				}
			}
			
			$qualitatif = mysql_query("	
									SELECT code_spe, my_character, Wi, id, Si, nb_states, N, Ci, Ms, moy
									FROM
									(
									SELECT
									(1- N/(rang-Ci)) as Si, code_spe, Wi, my_character,id, nb_states, N, Ci, Ms, moy
									FROM
									(
									SELECT GREATEST(abs($Mxi-avg(Ms))-Ci,0) as N,avg(Ms) as moy, (max-min) as rang, Ci, Wi, code_spe, my_character,id, nb_states, Ms
									FROM (SELECT code_char AS my_character, idData AS id, valeur AS Ms, weight AS Wi, min AS Min, correction AS Ci, max AS Max, name_genus, code_spe, nb_states, validity, pop_type
FROM ((SELECT 'LON' as idChar, id_data as idData, LON as valeur FROM data)
UNION
(SELECT 'STY' as idChar, id_data as idData, STY as valeur FROM data)
UNION
(SELECT 'DGO' as idChar, id_data as idData, DGO as valeur FROM data)
UNION
(SELECT 'EXPO' as idChar, id_data as idData, EXPO as valeur FROM data)
UNION
(SELECT 'BAW' as idChar, id_data as idData, BAW as valeur FROM data)
UNION
(SELECT 'TAIL' as idChar, id_data as idData, TAIL as valeur FROM data)
UNION
(SELECT 'TAN' as idChar, id_data as idData, TAN as valeur FROM data)
UNION
(SELECT 'PHAS' as idChar, id_data as idData, PHAS as valeur FROM data)
UNION
(SELECT 'a' as idChar, id_data as idData, a as valeur FROM data)
UNION
(SELECT 'c' as idChar, id_data as idData, c as valeur FROM data)
UNION
(SELECT 'c_bis' as idChar, id_data as idData, c_bis as valeur FROM data)
UNION
(SELECT 'm' as idChar, id_data as idData, m as valeur FROM data)
UNION
(SELECT 'v' as idChar, id_data as idData, v as valeur FROM data)
UNION
(SELECT 'SPIC' as idChar, id_data as idData, SPIC as valeur FROM data)
UNION
(SELECT 'MALES1' as idChar, id_data as idData, MALES1 as valeur FROM data)
UNION
(SELECT 'DISC1' as idChar, id_data as idData, DISC1 as valeur FROM data)
UNION
(SELECT 'CAN1' as idChar, id_data as idData, CAN1 as valeur FROM data)
UNION
(SELECT 'HAB1' as idChar, id_data as idData, HAB1 as valeur FROM data)
UNION
(SELECT 'HAB2' as idChar, id_data as idData, HAB2 as valeur FROM data)
UNION
(SELECT 'LIP1' as idChar, id_data as idData, LIP1 as valeur FROM data)
UNION
(SELECT 'LIP2' as idChar, id_data as idData, LIP2 as valeur FROM data)
UNION
(SELECT 'INC1' as idChar, id_data as idData, INC1 as valeur FROM data)
UNION
(SELECT 'INC2' as idChar, id_data as idData, INC2 as valeur FROM data)
UNION
(SELECT 'LANN1' as idChar, id_data as idData, LANN1 as valeur FROM data)
UNION
(SELECT 'LANN2' as idChar, id_data as idData, LANN2 as valeur FROM data)
UNION
(SELECT 'LANN3' as idChar, id_data as idData, LANN3 as valeur FROM data)
UNION
(SELECT 'KBS1' as idChar, id_data as idData, KBS1 as valeur FROM data)
UNION
(SELECT 'KBS2' as idChar, id_data as idData, KBS2 as valeur FROM data)
UNION
(SELECT 'KBS3' as idChar, id_data as idData, KBS3 as valeur FROM data)
UNION
(SELECT 'TSH1' as idChar, id_data as idData, TSH1 as valeur FROM data)
UNION
(SELECT 'TSH2' as idChar, id_data as idData, TSH2 as valeur FROM data)
UNION
(SELECT 'TSH3' as idChar, id_data as idData, TSH3 as valeur FROM data)
UNION
(SELECT 'TSH4' as idChar, id_data as idData, TSH4 as valeur FROM data)
UNION
(SELECT 'GENB1' as idChar, id_data as idData, GENB1 as valeur FROM data)
UNION
(SELECT 'GENB2' as idChar, id_data as idData, GENB2 as valeur FROM data)
UNION
(SELECT 'GENB3' as idChar, id_data as idData, GENB3 as valeur FROM data)) as mavue JOIN characters ON mavue.idChar = characters.code_char JOIN define ON mavue.idData=define.id_data
WHERE min=0 and max=1
ORDER BY idData) as vue
									WHERE my_character = '".$code_char[0]."' 
									$validity_condition group by code_spe
									)
									as equation1et2
									)
									as suivant group by code_spe");
				if ($qualitatif != null){
				while($resultat = mysql_fetch_array($qualitatif))
				{
				$code=substr(''.$resultat['my_character'].'', 0, -1);
				//echo '--------------------------------------------'.'</br>';
				//echo 'Code spe :'.$resultat['code_spe'].'</br>';
				//echo 'Character :'.$resultat['my_character'].'</br>';
				//echo 'N :'.$resultat['N'].'</br>';
				//echo 'Valeur du caractère Mx:'.$Mxi.'</br>';
				//echo 'Moyenne valeur échantillons connus Ms :'.$resultat['moy'].'</br>';
				//echo 'Si :'.$resultat['Si'].'</br>';
				//echo 'Wi :'.$resultat['Wi'].'</br>';
				//echo '--------------------------------------------'.'</br>';
				// Stockage du score pour un état et un caractère
				if($resultat['Si'] !=null or $resultat['Si']>-1){
					// Nombre d'état pour chaque caractère
				$result[$resultat['code_spe']][$code]['etat']+=1;
				$result[$resultat['code_spe']][$code]['Si']+=$resultat['Si'];
					}	
				
				}
				}
				$final = mysql_query("	
									SELECT code_spe, my_character, Wi, id, Si, nb_states, N, Ci, Ms, moy
									FROM
									(
									SELECT
									(1- N/(rang-Ci)) as Si, code_spe, Wi, my_character,id, nb_states, N, Ci, Ms,moy
									FROM
									(
									SELECT GREATEST(abs($Mxi-avg(Ms))-Ci,0) as N, (max-min) as rang, Ci, Wi, avg(Ms) as moy, code_spe, my_character,id, nb_states, Ms
									FROM (SELECT code_char AS my_character, idData AS id, valeur AS Ms, weight AS Wi, min AS Min, correction AS Ci, max AS Max, name_genus, code_spe, nb_states, validity, pop_type
FROM ((SELECT 'LON' as idChar, id_data as idData, LON as valeur FROM data)
UNION
(SELECT 'STY' as idChar, id_data as idData, STY as valeur FROM data)
UNION
(SELECT 'DGO' as idChar, id_data as idData, DGO as valeur FROM data)
UNION
(SELECT 'EXPO' as idChar, id_data as idData, EXPO as valeur FROM data)
UNION
(SELECT 'BAW' as idChar, id_data as idData, BAW as valeur FROM data)
UNION
(SELECT 'TAIL' as idChar, id_data as idData, TAIL as valeur FROM data)
UNION
(SELECT 'TAN' as idChar, id_data as idData, TAN as valeur FROM data)
UNION
(SELECT 'PHAS' as idChar, id_data as idData, PHAS as valeur FROM data)
UNION
(SELECT 'a' as idChar, id_data as idData, a as valeur FROM data)
UNION
(SELECT 'c' as idChar, id_data as idData, c as valeur FROM data)
UNION
(SELECT 'c_bis' as idChar, id_data as idData, c_bis as valeur FROM data)
UNION
(SELECT 'm' as idChar, id_data as idData, m as valeur FROM data)
UNION
(SELECT 'v' as idChar, id_data as idData, v as valeur FROM data)
UNION
(SELECT 'SPIC' as idChar, id_data as idData, SPIC as valeur FROM data)
UNION
(SELECT 'MALES1' as idChar, id_data as idData, MALES1 as valeur FROM data)
UNION
(SELECT 'DISC1' as idChar, id_data as idData, DISC1 as valeur FROM data)
UNION
(SELECT 'CAN1' as idChar, id_data as idData, CAN1 as valeur FROM data)
UNION
(SELECT 'HAB1' as idChar, id_data as idData, HAB1 as valeur FROM data)
UNION
(SELECT 'HAB2' as idChar, id_data as idData, HAB2 as valeur FROM data)
UNION
(SELECT 'LIP1' as idChar, id_data as idData, LIP1 as valeur FROM data)
UNION
(SELECT 'LIP2' as idChar, id_data as idData, LIP2 as valeur FROM data)
UNION
(SELECT 'INC1' as idChar, id_data as idData, INC1 as valeur FROM data)
UNION
(SELECT 'INC2' as idChar, id_data as idData, INC2 as valeur FROM data)
UNION
(SELECT 'LANN1' as idChar, id_data as idData, LANN1 as valeur FROM data)
UNION
(SELECT 'LANN2' as idChar, id_data as idData, LANN2 as valeur FROM data)
UNION
(SELECT 'LANN3' as idChar, id_data as idData, LANN3 as valeur FROM data)
UNION
(SELECT 'KBS1' as idChar, id_data as idData, KBS1 as valeur FROM data)
UNION
(SELECT 'KBS2' as idChar, id_data as idData, KBS2 as valeur FROM data)
UNION
(SELECT 'KBS3' as idChar, id_data as idData, KBS3 as valeur FROM data)
UNION
(SELECT 'TSH1' as idChar, id_data as idData, TSH1 as valeur FROM data)
UNION
(SELECT 'TSH2' as idChar, id_data as idData, TSH2 as valeur FROM data)
UNION
(SELECT 'TSH3' as idChar, id_data as idData, TSH3 as valeur FROM data)
UNION
(SELECT 'TSH4' as idChar, id_data as idData, TSH4 as valeur FROM data)
UNION
(SELECT 'GENB1' as idChar, id_data as idData, GENB1 as valeur FROM data)
UNION
(SELECT 'GENB2' as idChar, id_data as idData, GENB2 as valeur FROM data)
UNION
(SELECT 'GENB3' as idChar, id_data as idData, GENB3 as valeur FROM data)) as mavue JOIN characters ON mavue.idChar = characters.code_char JOIN define ON mavue.idData=define.id_data
WHERE min=0 and max=1
ORDER BY idData) as vue 
									WHERE my_character = '".$code_char[0]."' 
									$validity_condition group by code_spe
									)
									as equation1et2
									)
									as suivant group by code_spe");

				if ($final != null){
				while($reponse = mysql_fetch_array($final))
				{
				
				$code=substr(''.$reponse['my_character'].'', 0, -1);
				// Stockage du score pour un état et un caractère
				if(substr(''.$reponse['my_character'].'', -1, 1)==$reponse['nb_states']){
					//echo '--------------------------------------------'.'</br>';
					//echo 'Code spe :'.$reponse['code_spe'].'</br>';
					//echo 'Character :'.$reponse['my_character'].'</br>';
					//echo 'Si :'.$reponse['Si'].'</br>';
					//echo 'Wi character :'.$reponse['Wi'].'</br>';
					//echo '--------------------------------------------'.'</br>';
					
					// Moyenne des scores
					// JUSTE!!!!!!!!!
	
					$result[$reponse['code_spe']][$code]['Si']=$result[$reponse['code_spe']][$code]['Si']/$result[$reponse['code_spe']][$code]['etat'];
					//echo 'Moyenne score :'.$result[$reponse['code_spe']][$code]['Si'].'</br>';
					if($result[$reponse['code_spe']][$code]['Si']>-1 or $result[$reponse['code_spe']][$code]['Si']!=null){
					$result[$reponse['code_spe']][$code]['Wi']=$reponse['Wi'];
					}
					else{
					$result[$reponse['code_spe']][$code]['Wi']=0;
					}
					//echo 'Wi :'.$result[$reponse['code_spe']][$code]['Wi'].'</br>';
					// Calcul de SiWi
					// JUUUSSTTTEEE!!!!!!!!!!
					$result[$reponse['code_spe']][$code]['SiWi']=$result[$reponse['code_spe']][$code]['Si']*$result[$reponse['code_spe']][$code]['Wi'];
					//echo 'SiWi :'.$result[$reponse['code_spe']][$code]['SiWi'].'</br>';
					
					// Somme des SiWi
					$result[$reponse['code_spe']]['sum_siwi']+=$result[$reponse['code_spe']][$code]['SiWi'];
					//echo 'Somme SiWi :'.$result[$reponse['code_spe']]['sum_siwi'].'</br>';
					
					// Somme des poids
					$result[$reponse['code_spe']]['sum_wi']+=$result[$reponse['code_spe']][$code]['Wi'];
					//echo 'Somme Wi :'.$result[$reponse['code_spe']]['sum_wi'].'</br>';
				}				
				}
				}
}
$data=mysql_query("Select id_data, specie, define.code_spe, validity, pop_type from species join define on define.code_spe=species.code_spe group by specie");
$data1=mysql_query("Select id_data, specie, define.code_spe, validity, pop_type from species join define on define.code_spe=species.code_spe group by specie");
?>

				<h3><br />Best Results (Coefficient of similarity superior or equal to 95%)</h3>
				<table>
				<tr>
				<td width="500px" align=center><b>Species</b></td>
				<td width="500px" align=center><b>Code species</b></td>
				<td width="500px" align=center><b>Sum score*weight</b></td>
				<td width="500px" align=center><b>Sum of weights</b></td>
				<td width="500px" align=center><b>Coefficient of similarity</b></td>
				</tr>
<?php
while($rep = mysql_fetch_array($data1)){

$taux=$result[$rep['code_spe']]['sum_siwi']/$result[$rep['code_spe']]['sum_wi'];
if($taux>=0){
$result[$rep['code_spe']]['coefficient']=sprintf('%.2f',$taux);;
}
else{
$result[$rep['code_spe']]['coefficient']=0;
}
if($result[$rep['code_spe']]['sum_siwi']!=0 and $result[$rep['code_spe']]['coefficient']>=0.95){
				echo '	<tr>';
				if($result[$rep['code_spe']]['coefficient']==1){
				echo '<td width="500px" align=center style="background-color: #FF4000">'.$rep['specie'].'</td>
				<td width="500px" align=center style="background-color: #FF4000">'.$rep['code_spe'].'</td>
				<td width="500px" align=center style="background-color: #FF4000">'.round($result[$rep['code_spe']]['sum_siwi'],2).'</td>
				<td width="500px" align=center style="background-color: #FF4000">'.round($result[$rep['code_spe']]['sum_wi'],2).'</td>
				<td width="500px" align=center style="background-color: #FF4000">'.$result[$rep['code_spe']]['coefficient'].'</td>';
				}
				else{
				echo '<td width="500px" align=center>'.$rep['specie'].'</td>
				<td width="500px" align=center>'.$rep['code_spe'].'</td>
				<td width="500px" align=center>'.round($result[$rep['code_spe']]['sum_siwi'],2).'</td>
				<td width="500px" align=center>'.round($result[$rep['code_spe']]['sum_wi'],2).'</td>
				<td width="500px" align=center>'.$result[$rep['code_spe']]['coefficient'].'</td>';
				}
				echo '</tr>';
				}
				}
				echo '</table>';
		?>
		
		<h3><br /> All Results </h3>
				<table>
				<tr>
				<td width="500px" align=center><b>Species</b></td>
				<td width="500px" align=center><b>Code species</b></td>
				<td width="500px" align=center><b>Sum score*weight</b></td>
				<td width="500px" align=center><b>Sum of weights</b></td>
				<td width="500px" align=center><b>Coefficient of similarity</b></td>
				</tr>
				
		<?php
			while($row = mysql_fetch_array($data)){
			$taux=$result[$row['code_spe']]['sum_siwi']/$result[$row['code_spe']]['sum_wi'];
			if($taux>=0){
			$result[$row['code_spe']]['coefficient']=sprintf('%.2f',$taux);;
			}
			else{
			$result[$row['code_spe']]['coefficient']=0;
			}
			if($result[$row['code_spe']]['sum_siwi']!=0 ){
							echo '	<tr>
							<td width="500px" align=center>'.$row['specie'].'</td>
							<td width="500px" align=center>'.$row['code_spe'].'</td>
							<td width="500px" align=center>'.round($result[$row['code_spe']]['sum_siwi'],2).'</td>
							<td width="500px" align=center>'.round($result[$row['code_spe']]['sum_wi'],2).'</td>
							<td width="500px" align=center>'.$result[$row['code_spe']]['coefficient'].'</td>
							</tr>';
							}
							
							}
			echo '</table>';
							}
		?>