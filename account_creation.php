
<?php 
/*test github*/
include('includes/haut.php');
include('connectionSQL.php');
connexion_bdd();

if(isset($_SESSION['user_id'])) {
	header('Location: '.ROOTPATH.'/main.php');
	exit();
}
if ($_SESSION['inscrit'] != "termine") {
	// Verification des informations pour inscription
	$verif = false;
	if(isset($_POST["create_account"]))	{
		if ($_POST["firstname"] != NULL && $_POST["lastname"] != NULL && $_POST["country"] != NULL && $_POST["email"] != NULL && $_POST["password"] != NULL) {
			// Verification de tous les champs (la fonction trim sert a supprimer les espaces avant et apres)
			$firstname = trim($_POST['firstname']);
			$lastname = trim($_POST['lastname']);
			$institution = trim($_POST['institution']);
			$town = trim($_POST['town']);
			$country = trim($_POST['country']);
			$email = trim($_POST['email']);
			$pwd = trim($_POST['password']);
			  /* if (checkmail($email) == 'isnt') {
				$verif = false; 
				
				 $informations = Array(false,'Wrong email ! Redirection in few seconds to inscription page...',ROOTPATH.'/inscription.php',5);
				require_once('informations.php');
				exit(); 
			} */ 
			/*  else {
			 	$query = mysqli_query($con,'SELECT COUNT(id_user) 
									  FROM user 
									  WHERE e_mail = "'.$email.'"');
				if(mysqli_result($con,$query, 0) == 0) {
					$verif = true;
				} else {
					$informations = Array(true,'Your are already registered on Nemaid 3.3.',ROOTPATH.'/index.php',5);
					require_once('informations.php');
					exit();
				}
			} */
			//if ($verif) {
				if ($_POST["institution"] == NULL) {
					if ($_POST["town"] == NULL)
						$insertion =mysqli_query($con,"INSERT INTO user VALUES (NULL, '$firstname', '$lastname', '$email','$country', NULL, NULL, 'md5($pwd)',0)");
					else
						$insertion = mysqli_query($con,"INSERT INTO user VALUES (NULL, '$firstname', '$lastname', '$email', '$country','$town', NULL, 'md5($pwd)',0)");
				} elseif($_POST["town"] == NULL)
					$insertion = mysqli_query($con,"INSERT INTO user VALUES (NULL, '$firstname', '$lastname', '$email','$country', NULL,'$institution','md5($pwd)',0)");
				else 
					$insertion = mysqli_query($con,"INSERT INTO user VALUES (NULL, '$firstname', '$lastname', '$email', '$country','$town','$institution', 'md5($pwd)',0)");
				/* if(mysql_query($insertion)) {
					vidersession();
					$_SESSION['inscrit'] = "termine";
					
					information_mail($firstname, $lastname, $email, $institution, $town, $country);
					inscription_mail($email, $pwd);
					
					$informations = Array(false,'Your have been successfully registered on NEMAID 3.0.<br />A confirmation email has been sent.',ROOTPATH.'/index.php',3);
					require_once('informations.php');
					exit();

				} else {
					$informations = Array(true,'Error : Insertion failed.<br />Please contact administrator.',ROOTPATH.'/index.php',10);
					require_once('informations.php');
					exit();
				 */
				 echo "Thank you for your submission";
				 }
				 else {
					 echo"You have to fill all items";
				 }
			//}
		} 
		/* else {
			$informations = Array(true,'All fields with * are mandatory.',ROOTPATH.'/inscription.php',2);
			require_once('informations.php');
			exit(); */
		//}
	}

 /* else {
	$informations = Array(true,'Your are already registered on NEMAID 3.0.',ROOTPATH.'/index.php',2);
	require_once('informations.php');
	exit();
} */
//mysql_close();
?>