<?php

/*
 * Created on 19 mars 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
include('includes/haut.php');
include('connectionSQL.php');

$idref = $_POST['id_ref'];
$status = $_POST['status'];
$validity = $_POST['validity'];
$pop_type = $_POST['pop_type'];



// enregistrement des data
/* $result = mysqli_query ("SELECT id_character,name_character from character1");

$requete=mysqli_query("Show columns from character1");
$champs=array();
$resultat=mysqli_num_rows($requete);

while($requete && $row=mysqli_fetch_array($requete)){
$champs[]=$row["Field"];
}
if(isset ($_POST['nameChar1'])){
	$val = $_POST['nameChar1'];
}
else{
$val=NULL;
}

$insert=mysqli_query("Insert into data($champs[1]) values($val)");
//récupération l'id data		
$id_data = mysqli_insert_id();

$compteur=0;
while($row = mysqli_fetch_array($result)){
	$compteur=$compteur+1;
	$id=$row['id_char'];
	if($_POST['nameChar'.$id]!=NULL){
	$valeur=$_POST['nameChar'.$id];
	}
	else
	{
	$valeur=NULL;
	}
	$update=mysqli_query("Update data set $champs[$compteur]=$valeur where id_data=$id_data");
}

//insertion dans la table define
$code=$_SESSION['code_spe'];
$sQuery=("INSERT INTO `define` (id_def, validity, pop_type, code_spe, id_data, id_ref, status)
VALUES ('','$validity', '$pop_type', '$code', '$id_data', '$idref', '$status');"); */

//test de la validité de la fonction SQL		
if (mysqli_query($sQuery))
{
	echo ("<h2>Data saved successfully</h2>");
}
else
{
	echo "Error inserting record: " . mysqli_error();
}	


?>