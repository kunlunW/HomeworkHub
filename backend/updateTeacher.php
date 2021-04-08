<?php
// @codeCoverageIgnoreStart
 include "sql_connection.php";

// Create connection
$conn = OpenCon();

// Retrieve data from the frontend
$data = $_POST['formData'];
$json = json_decode($data, true);
$username = $json["name"]; // Primary Key

$gender = $json["gender"];
$email = $json["email"];
$mobile_no = $json["mobile_no"];
$school = $json["school"];

$sqlCheck = "SELECT * FROM Teachers WHERE teacherUserName = '$username';";
if($sqlCheck) { // Entry already exists
    $sqlUpdate = "UPDATE Teachers t SET t.gender = '$gender', t.email = '$email', t.mobile_no = '$mobile_no', t.school = '$school' WHERE t.teacherUserName = '$username';";
    $updateRes = $conn->query($sqlUpdate);
    if (!$updateRes) {
        echo "Update Failed\n";
        CloseCon($conn);
        return;
    } else {
        echo "Update Success\n";
    }
} else { // Entry doesn't exist
    $sqlInsert = "INSERT INTO Teachers (username, gender, email, mobile_no, school) VALUES ('$username', '$gender', '$email', '$mobile_no', '$school');";
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


