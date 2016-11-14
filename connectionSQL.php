<?php
	$serveur = "91.216.107.161";
	$user = "genis9685";
	$password = "666732";
	$bdd = "genis9685";

//      Version développement 2015
//	$serveur = "localhost";
//	$user = "root";
//	$password = "";
//	$bdd = "NEMAID2";
	
	$con = mysqli_connect($serveur, $user, $password,$bdd);

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
	
	/* mysql_connect($serveur, $user, $password);
	mysql_select_db($bdd) */;

?>