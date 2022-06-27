<?php
// fma
	require_once('includes/config.php');
	//require_once('includes/functions.php');
	require_once('photo.php');


	if (!isset($_GET['page'])) {
    $id = 'home'; // display home page
	} 	else {
    $id = $_GET['page']; // else requested page
}

$output = '';
	 	switch ($id) {
		case 'home':
		# code...
		include 'index.php';
		break;
    default :
        include 'views/404.php';
	}	


	?>
