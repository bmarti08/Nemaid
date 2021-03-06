<?php
include('includes/haut.php');
include("functions.php");
connexion_bdd();

if(isset($_SESSION['user_id'])) {
	header('Location: '.ROOTPATH.'/main.php');
	exit();
}

if(isset($_POST)) {
	// Les identifiants sont transmis ?
	if(!empty($_POST['login'])) {
		extract($_POST);
		$sql = "SELECT id_user, e_mail, password, admin FROM USER WHERE e_mail = '".$login."'";
		$req = mysqli_query($con ,$sql) or die(mysqli_error($con));
		
		// L'utilisateur existe t'il dans la base ?
		if (mysqli_num_rows($req) > 0) {
			$data = mysqli_fetch_assoc($req);
			
			// Le mot de passe est-il correct ?
			// if($data['password'] !== md5($password)) {  
				// $informations = Array(true,'Wrong password',ROOTPATH.'/index.php',5);
				// require_once('informations.php');
				// exit();
			// } else {
				// On enregistre le type d'user en session => accession aux pages admin
				$_SESSION['user_id'] = $data['id_user'];
				
				if($data['admin']) $_SESSION['admin'] = true;
				$_SESSION['genus_n'] = NULL;
				
				$informations = Array(false,'Your are connected ! Redirection in few seconds',ROOTPATH.'/select_genus.php',0);
				require_once('informations.php');
				exit();
			// }
		} else {
			$informations = Array(true,'Unknown login.',ROOTPATH.'/index.php',5);
			require_once('informations.php');
			exit();
		}		  
	} else {
		$informations = Array(true,'Please enter a login and a password.',ROOTPATH.'/index.php',5);
		require_once('informations.php');
		exit();
	}
}

mysql_close();
?>