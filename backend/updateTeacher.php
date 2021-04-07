<?php
// @codeCoverageIgnoreStart
 include "sql_connection.php";

// Create connection
$conn = OpenCon();

// Retrieve data from the frontend
$data = $_POST['formData'];
$json = json_decode($data, true);
$username = $json["username"]; // Primary Key

$gender = $json["gender"];
$subject = $json["subject"];
$address = $json["address"];
$telephone = $json["telephone"];

$sqlCheck = "SELECT * FROM Teachers WHERE teacherUserName = '$username';";
if($sqlCheck) { // Entry already exists
    $sqlUpdate = "UPDATE Teachers t SET t.gender = '$gender', t.subject = '$subject', t.address = '$address', t.telephone = '$telephone' WHERE t.teacherUserName = '$username';";
    $updateRes = $conn->query($sqlUpdate);
    if (!$updateRes) {
        echo "Update Failed\n";
        CloseCon($conn);
        return;
    } else {
        echo "Update Success\n";
    }
} else { // Entry doesn't exist
    $sqlInsert = "INSERT INTO Teachers (username, gender, subject, address, telephone) VALUES ('$username', '$gender', '$subject', '$address', '$telephone');";
    $insertRes = $conn->query($sqlInsert);
    if (!$insertRes) {
        echo "Insert Failed\n";
        CloseCon($conn);
        return;
    } else {
        echo "Insert Success\n";
    }
}

CloseCon($conn);
// @codeCoverageIgnoreEnd
?>


