<?php
include 'sql_connection.php';

$data = $_POST['formData'];
$json = json_decode($data, true);
$username = $json["username"];
$password = $json["password"];

$conn = OpenCon();

$sql = "SELECT * FROM users WHERE username='$username' AND password='$password';";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    echo $row["type"];
} else {
    echo 2;
}

CloseCon($conn);
?>
