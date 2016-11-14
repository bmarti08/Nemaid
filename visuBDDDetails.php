<?php
/*
 * Created on 12 mars 2013
 *
 * To change tde template for tdis generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 // On inclut les pages de connection à la BDD et des fonctions

include("includes/haut.php");
include("connectionSQL.php");

//requete
function request($char, $idData){
	$result = mysqli_query($con,"SELECT $char FROM data where id_data=$idData");
	return $result;
}

$idRef = $_GET["idref"];

//$result2 = mysqli_query($con,"SELECT title, name_author, journal, year, publi_in FROM `biblio_ref` natural join author where id_biblio=$idRef");
$result2 = mysqli_query($con,"select name_author, title, journal, year, publi_in from AUTHOR natural join BIBLIO_REF where id_biblio=$idRef" );


$character = mysqli_query($con,"SELECT id_character, entitled_character, explaination from CHARACTER1");

$title = mysqli_fetch_assoc($result2);
$titre = $title['title'];
$author = $title['name_author'];
$journal = $title['journal'];
$year = $title['year'];
$publi_in = $title['publi_in'];


	//echo "<h2>Description based on the article : </h2>  </br> <h3>$author  <br> $titre <br> $year <br> $journal</h3>";


	echo "<h2>Description based on the article : </h2> <h3>$author $titre $year , ok";
		if ($publi_in != 0)
			{ 
			echo " (published in $publi_in)";
			} 
	echo " $journal</h3>";


?>

<form action="updateBDD.php" method="post">


<?php
echo "<table border='1'>";
while ($rowChar = mysqli_fetch_array($character)){
	$idCharacter=$rowChar['id_character'];
	$val = mysqli_query($con,'SELECT distinct value_character from POPULATION natural join ANALYSIS natural join IS_COMPOUND_BY where id_character ="'.$idCharacter.'"');
while ($rowval = mysqli_fetch_array($val)){
	$valChar=$rowval['value_character'];
	echo "<tr>";
	echo "<th>" . $rowChar['entitled_character'] . "</th>";
	echo '<td>' . '<INPUT TYPE="text" name="ValueSet'.$idCharacter.'"  value="'.$valChar.'">'  . '</td>';
	/* $idData = $_GET["iddata"];
	echo "<input type='hidden' name='iddata' value=$idData> ";
	$result = request($rowChar['code_char'], $idData);
	while ($row = mysqli_fetch_array($result))
		{	
			$value = $row[$rowChar['code_char']];
			echo "<td>" . "<INPUT TYPE='text' name='" . $rowChar['code_char']. "' size='2' value='$value'>"  . "</td>";
		} */
echo "</tr>";
}
}
echo "</table>";


//if(isset($_SESSION['adlmin']) && $_SESSION['admin']){


?>