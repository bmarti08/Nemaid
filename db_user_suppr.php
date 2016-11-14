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
include("connectionSQL.php");
?>

<?php
	
$id=$_POST['id'];
$first_name=$_POST['first_nameSet'.$id.''];
$last_name=$_POST['last_nameSet'.$id.''];
$e_mail=$_POST['e_mailSet'.$id.''];
$institution=$_POST['institutionSet'.$id.''];
$city=$_POST['citySet'.$id.''];
$country=$_POST['countrySet'.$id.''];


 $update = mysqli_query($con,'DELETE FROM user WHERE id_user ="'.$id.'"');



if ($update==true){
		echo "<h3>Database updated successfully</h3>";
	}
	
	else {
		echo "Error updating record: " . mysqli_error($con);
	}
	

?>
<a href="db_users.php">Return</a>			