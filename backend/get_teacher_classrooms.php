<?php
include 'sql_connection.php';

$data = $_POST['formData'];
$json = json_decode($data, true);
$username = $json["username"];
$conn = OpenCon();

$sql = "SELECT * FROM classrooms WHERE teachername='$username'";

$json = '[';

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        //TODO finish this
  }
}

CloseCon($conn);
?>
