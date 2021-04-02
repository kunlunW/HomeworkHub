<?php
 include "sql_connection.php";

// Create connection
$conn = OpenCon();

// Retrieve data from the frontend
$data = $_POST['formData'];
$json = json_decode($data, true);
$username = $json["username"];
$password = $json["password"];
$type = $json["type"];

//Check if username is already in database
$sql = "SELECT * FROM users WHERE username= '$username';";
$result = $conn->query($sql);
if ($result->num_rows != 0) {
    echo 2; //username taken
    return;
}

$sqlRegister = "INSERT INTO users (username, password, type) VALUES ('$username', '$password', '$type')";
$resultRegister = $conn->query($sqlRegister);
if(!$resultRegister) {
    echo 1;
} else {
    echo 0;
}

CloseCon($conn);
?>



