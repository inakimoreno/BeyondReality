<?php

	$sname= "localhost";

	$email= "root";

	$password = "";

	$db_name = "my_optimalperformance333";

	$conn = mysqli_connect($sname, $email, $password, $db_name);

	if (!$conn) {

	    echo "Connection failed!";

}
?>
