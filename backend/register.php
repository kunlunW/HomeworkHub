<?php
 error_reporting(E_ALL);
 ini_set('display_errors', 1);
$servername = "localhost";
$username = "root";
$password = "";
$db = "test1";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);

// Retrieve data from the frontend
$recText = $_POST['text'];
$recUsername = $_POST['username'];
$recPassword = $_POST['password'];
$recType = $_POST['type'];

// Check connection
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

$result = mysqli_query($conn, "INSERT INTO users (name) VALUES ('$recText')");

if(!$result) {
    echo $recText;
    echo "Insertion failed";
} else {
    echo "Insertion success";
}

// Register User Account Insertion
// Attribute: username, password, type (teacher/parent)
$sqlRegister = "INSERT INTO Users (username, password, type) VALUES ('$recUsername', '$recPassword', '$recType')";
$resultRegister = $conn->query($sqlRegister);

if(!$resultRegister) {
    echo $recUsername;
    echo "User Account Establishment failed";
} else {
    echo "User Account Establishment success";
}

?>


