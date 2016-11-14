<?php
/*
 * Created on 7 december by Heia
 *

 */

	include("includes/haut.php");
	include("connectionSQL.php");
	include("functions.php");
?>
<center><h1>The database management</h1></center><br />
<?php
include("menu_database_manage.php");
include("menu_dbm_species.php")
?>
<input type="button" name="Return" value="Return" onClick="document.location='main.php'" /><br />
 <form action = "addReference.php" method = "post">
 
<?php
// création nouvelle espèce d'un genre'
echo "<h3> Create a new species </h3>";
echo "Name of the new species ";
echo '<tr>';
echo '	<td><SUP title="NameSpecies"></SUP></td>';
echo '	<td><input type="text" name="specie"></td>';
echo '</tr>';
//$namespe = $_POST['specie'];

//Selection du genre de l'espèce			



$recuperation_species = mysqli_query($con,"SELECT name_genus from genus");

?>
        
        <br>
        <br>
        Genus of the new Species :
        <select name="name_genus" >
        <!--<option selected="selected"></option> -->
        
<?php
while ($tableau_client = mysqli_fetch_array($recuperation_species))
{
	echo '<option value='. $tableau_client['name_genus']. '>' . $tableau_client['name_genus'] . '</option>' ;
}        



?>
        </select>
        <input type="submit" name="submitAddSpecies" action="addReference.php" value="Submit"  />
        </form>
 <form action = "addReference.php" method = "post">        
         

<?php 
echo "<h3> Select an existing species </h3>";      
$recuperation_species = mysqli_query($con,"SELECT name_species from species ");

?>
        
        Name of the existing species :
       <select id="id_spe" name="id_spe" onchange="document.getElementById('id_spe_content').value=this.options[this.selectedIndex].value">
		  <option name="default" value="">--Choose a species--</option> -->
  
<?php
while ($tableau_species = mysqli_fetch_array($recuperation_species))
{
	echo '<option value='. $tableau_species['name_species'].'>'.$tableau_species['name_species']. '</option>' ;
}        


?>
</select>
</select>
<input type="hidden" name="id_spe" id="id_spe_content" value="" />
<input type="submit" name="submitAddSpecies" value="Submit"  />
</form>