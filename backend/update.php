<?php
// @codeCoverageIgnoreStart
 include "sql_connection.php";

// Create connection
$conn = OpenCon();

// Retrieve data from the frontend
$data = $_POST['formData'];
$json = json_decode($data, true);
$username = $json["username"];

$newUserame = $json["newUsername"];
$newPassword = $json["newPassword"];
$newType = $json["newType"];

// Check if there are NULL values among the three attributes
if($newUserame === NULL || $newPassword === NULL || $newType === NULL) {
    echo "Invalid input\n";
    CloseCon($conn);
    return;
} else {
    //Check if the updated username is already in database
    $sql = "SELECT * FROM users WHERE username = '$newUsername';";
    $newUsernameCheck = $conn->query($sql);
    if ($newUsernameCheck->num_rows != 0) {
        echo "Duplicate username\n"; //duplicate username
        CloseCon($conn);
        return;
    }

    $sqlUpdate = "UPDATE users u SET u.username = '$newUsername', u.password = '$newPassword', u.type = '$newType' WHERE u.username = '$username';";
    $updateRes = $conn->query($sqlUpdate);
    if (!$updateRes) {
        echo "Update Failed\n";
        CloseCon($conn);
        return;
    } else {
        echo "Update Success\n";
    }
}

CloseCon($conn);
// @codeCoverageIgnoreEnd
?>
