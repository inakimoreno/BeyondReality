<?php
    #connecting the names of the user put fields and the table column names so the data can go to the correct places
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$conpassword = $_POST['conpassword'];


	#empty user input field error handlers
	if(empty($fname)) {
	header("location:registration.html?error=First name is required");
		exit();
	}

	else if(empty($lname)) {
		header("location:registration.html?error=Last name is required");
		exit();
	}

	else if(empty($email)) {
		header("Location:registration.html?error=Email is required");
		exit();
	}

	else if(empty($password)) {
		header("Location:registration.html?error=Password is required");
		exit();
	}

	else if(empty($conpassword)) {
		header("Location:registration.html?error=Confirm Password is required");
		exit();
	}

	// Database connection
	#defining what table it needs to connect to 
    #defining the database table
	$conn = new mysqli('localhost','root','','beyondrealityDB');
	if($conn->connect_error){
		
	#connecting error handlers
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} else {

		#defining the data that needs to be sent to the database and their data types
		$stmt = $conn->prepare("insert into signup (fname, lname, email, password, conpassword) values(?, ?, ?, ?)");
		$stmt->bind_param("ssss", $fname, $lname, $email, $password, $conpassword);
		$execval = $stmt->execute();
		echo $execval;

		#where the user will be sent once the data is correctly filled in and sent to the database
		header("Location: immersivehub.html");
    	exit();

    	#connection to the datbase closed
		$stmt->close();
		$conn->close();
	}
?>
