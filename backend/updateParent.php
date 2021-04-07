<?php
// @codeCoverageIgnoreStart
 include "sql_connection.php";

// Create connection
$conn = OpenCon();

// Retrieve data from the frontend
$data = $_POST['formData'];
$json = json_decode($data, true);
$username = $json["username"]; // Primary Key

$studentID = $json["studentID"];
$studentName = $json["studentName"];
$studentGender = $json["studentGender"];
$grade = $json["grade"];
$gpa = $json["gpa"];
$address = $json["address"];
$telephone = $json["telephone"];

$sqlCheck = "SELECT * FROM Parents WHERE parentUserName = '$username';";
if($sqlCheck) { // Entry already exists
    $sqlUpdate = "UPDATE Parents p SET p.studentID = '$studentID', p.studentName = '$studentName', p.studentGender = '$studentGender', p.grade = '$grade', p.gpa = '$gpa', p.address = '$address', p.telephone = '$telephone' WHERE p.parentUserName = '$username';";
    $updateRes = $conn->query($sqlUpdate);
    if (!$updateRes) {
        echo "Update Failed\n";
        CloseCon($conn);
        return;
    } else {
        echo "Update Success\n";
    }
} else { // Entry doesn't exist
    $sqlInsert = "INSERT INTO Parents (username, studentID, studentName, studentGender, grade, gpa, address, telephone) VALUES ('$username', '$studentID', '$studentName', '$studentGender', '$grade', '$gpa', '$address', '$telephone');";
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



