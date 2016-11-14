<?php
	include("includes/haut.php");
	include("connectionSQL.php");
	include("functions.php");
?>
<center><h1>The database management</h1></center><br />
<?php
include("menu_database_manage.php");
?>
<center>
							<table class="menu">
								<tr>
								<td class ="menu"><a href="addNewReference.php">Add a new genus</a></td>
								<td class ="menu"><a href="visuBddByGenera.php">Find a genus</a></td>
								<tr>
							</table>
						</center>
<input type="button" name="Return" value="Return" onClick="document.location='main.php'" /><br />
<form method="post" action="addNewGenera.php">
<label for="genera"><h2>Complete the field below to add a new genus</h2></label><br />
<table>
		<tr><td><label>Name</label> </td><td><input required type="text" name="name_genus" /></td></tr>
		<tr>
</table>
	   <input type="submit" value="Submit" name="create_newGenera">
</form>
<?php 
connexion_bdd();

if(isset($_POST['name_genus']))      $name_genus=$_POST['name_genus'];
else      $nom="";


// On vérifie si les champs sont vides 
if(empty($name_genus)) 
    { 
    null;
    } 

// Aucun champ n'est vide, on peut enregistrer dans la table 
else      
    { 

    // on écrit la requête sql 
	$name_genus= $_POST['name_genus'];
$query = mysqli_query($con,'INSERT INTO `genus` VALUES (NULL,"'.$name_genus.'")')  or die('Erreur de connexion '.mysqli_error()) ;   

    echo "This type has been added"; 


						}
						
			
mysqli_close($con);
?>