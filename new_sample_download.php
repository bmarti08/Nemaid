<?php
		/* session_start();
		
		//pour télécharger
		$full_path = ROOTPATH.'/'.$_SESSION['current_name'].'.xml'; // chemin système (local) vers le fichier
		$file_name = basename($full_path);
					
		header('Content-Description: File Transfer'); //spécifie au navigateur que les données qu'il va recevoir doivent être considérées comme un fichier à télécharger.
		ini_set('zlib.output_compression', 0);
		$date = gmdate(DATE_RFC1123);
		header('Pragma: public');
		header('Cache-Control: must-revalidate, pre-check=0, post-check=0, max-age=0');
 
		//header('Content-Transfer-Encoding: binary');//précise que le fichier à traiter devra être envoyé en binaire. 
		header('Content-Tranfer-Encoding: none');
		header('Content-Length: '.filesize($full_path));
		header('Content-MD5: '.base64_encode(md5_file($full_path)));
		header('Content-Type: application/octetstream; name="'.$file_name.'"');// indique que le flux de données qui va suivre est de type « flux d'octet ».
		//header("Content-Type: application/force-download"); 
		header('Content-Disposition: attachment; filename="'.$file_name.'"');//attribue un nom au fichier.
 
		header('Date: '.$date);
		header('Expires: '.gmdate(DATE_RFC1123, time()+1));
		header('Last-Modified: '.gmdate(DATE_RFC1123, filemtime($full_path)));
		
		//3 prochaines lignes :  ces lignes ordonnent au navigateur de ne pas mettre les fichiers en cache pour que le téléchargement soit déclenché à chaque fois
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($full_path)); //donne au navigateur la taille du fichier
		
		ob_clean();
		flush();
		readfile($full_path);
		exit; // nécessaire pour être certain de ne pas envoyer de fichier corrompu */

		
		
header("Content-type: application/force-download");
header("Content-Disposition: attachment; filename='112-user2_sample.xml'");
readfile($chem/'112-user2_sample.xml');
		
		
?>