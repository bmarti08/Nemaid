<?php
include('includes/haut.php');
include('connectionSQL.php');
/*
 * Created on 17 01 2014 by Manon Forconi
 * */
 ?>
<center><h1>The database management</h1></center><br />
<?php
include("menu_database_manage.php");
include("connectionSQL.php");
?>
<input type="button" name="Return" value="Return" onClick="document.location='main.php'" /><br />
<?php
	/* $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
    $bdd = new PDO('mysql:host='.$serveur.';dbname='.$bdd.'', $user, $password, $pdo_options);
	$reponse = $bdd->query('SELECT f_name, l_name, email, institution, town, country FROM users '); */
	
	$query = mysqli_query($con,'SELECT id_user, first_name, last_name, e_mail, country, city, institution, password FROM user');
?>		

<form method="POST" action="db_user_suppr.php">							  
	<table>
	  <tr>
	  <th></th>
		<td><b> first name </b></td> 
		<td><b> last name </b></td> 
		<td><b> email </b></td> 
		<td><b> institution </b></td> 
		<td><b> town </b></td> 
		<td><b> country </b></td> 
	  </tr>
<?php
	while ($donnees = mysqli_fetch_array($query))
	{
		$id=$donnees['id_user'];
		
	echo '<tr>';
	echo "<td>" ."<input type='radio' name='id' value='".$id."' />"."</td>";
	echo '<td>' . '<name="first_nameSet'.$id.'" cols="30" rows="7">'.$donnees['first_name'].'</textarea>'  . '</td>';
	echo '<td>' . '<name="last_nameSet'.$id.'" cols="30" rows="7">'.$donnees['last_name'].'</textarea>'  . '</td>';
	echo '<td>' . '<name="e_mailSet'.$id.'" cols="30" rows="7">'.$donnees['e_mail'].'</textarea>'  . '</td>';
	echo '<td>' . '<name="institutionSet'.$id.'" cols="30" rows="7">'.$donnees['institution'].'</textarea>'  . '</td>';
	echo '<td>' . '<name="citySet'.$id.'" cols="30" rows="7">'.$donnees['city'].'</textarea>'  . '</td>';
	echo '<td>' . '<name="countrySet'.$id.'" cols="30" rows="7">'.$donnees['country'].'</textarea>'  . '</td>';

    echo '</tr>';
	}
	mysqli_close($con);	
	?>	
<input type="submit" value="Delete">	
	</table>
