<?php
if(!isset($_SESSION))
    session_start();
/*
echo $_POST['name'];
echo $_POST['description'];
echo $_POST['category'];
echo $_POST['supplier'];
echo file_get_contents($_FILES['asset']['tmp_name']);*/
echo $_SESSION['user'];

$name = $_POST['name'];
$description = $_POST['description'];
$category = $_POST['category'];
$supplier = $_POST['supplier'];
$asset = file_get_contents($_FILES['asset']['tmp_name']);

$conn = new mysqli('localhost','root','','beyondrealitydb');
if($conn->connect_error){
    
#connecting error handlers
    echo "$conn->connect_error";
    die("Connection Failed : ". $conn->connect_error);
} else {

    #defining the data that needs to be sent to the database and their data types
    $stmt = $conn->prepare("insert into assets (name, description, category, supplier, user, asset) values(?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $description, $category, $supplier, $_SESSION['user'], $asset);
    $execval = $stmt->execute();
    //echo $execval;

    #where the user will be sent once the data is correctly filled in and sent to the database
    //header("Location: ../html/immersivehub.html");
    //exit();

    #connection to the datbase closed
    $stmt->close();
    $conn->close();
}
?>