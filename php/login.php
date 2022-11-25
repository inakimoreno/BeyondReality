<?php

	$sname= "localhost";

	$email= "root";

	$password = "";

	$db_name = "beyondrealityDB";

	//$conn = mysqli_connect($sname, $email, $password, $db_name);

	$dsn = "mysql:host=localhost;dbname=$db_name";
	$dbh = new PDO($dsn, $email, $password);




	$email = $_POST['email'];
	$password = $_POST['password'];

	$stmt = $dbh->prepare("SELECT pass FROM users WHERE email = ?");
    $stmt->bindParam(1,$email);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
	$strResult = $stmt->fetch()['pass'];
	echo $strResult;


	if($password==$strResult){
		session_start();
		$_SESSION['user']=$email;
		header("Location: ../index.php");
	}

	echo $_SESSION['user'];
?>
