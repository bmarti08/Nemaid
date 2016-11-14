<?php

// On inclut les pages de connection à la BDD et des fonctions
include("connectionSQL.php");
include("functions.php");
include("includes/haut.php");
?>

<h2>Please select one of the available databases:</h2><br />
<?php
include("menu_database.php");
?>