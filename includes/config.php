<?php
	# pass the db credentials to the connect function, store handle in $link

	$link = mysqli_connect(
		'mysqlsrv.', 
		'rlucas', 
		'password', 
		'dbschema'
	);

	if (mysqli_connect_errno()) {
		echo "theres an error";
		exit(mysqli_connect_error());
	}

?>