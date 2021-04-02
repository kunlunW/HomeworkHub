<?php
include 'sql_connection.php';

function CreateUsersTable($conn)
{
    $sql = "CREATE TABLE users (
    username VARCHAR(255) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    type ENUM('parent', 'teacher') NOT NULL DEFAULT 'parent'
    )";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        echo "users table was not created<br>";
        return false;
    }
}

function DropUsersTable($conn) 
{
    $sql = "DROP TABLE users";

    if ($conn->query($sql)) {
        return true;
    } else {
        echo "users table was not dropped<br>";
        return false;
    }
}

function CreateClassroomsTable($conn)
{
    $sql = "CREATE TABLE classrooms (
    classroomname VARCHAR(255) NOT NULL,
    classroomid INT PRIMARY KEY AUTO_INCREMENT,
    teachername VARCHAR(255) NOT NULL,
    FOREIGN KEY (teachername) REFERENCES users(username)
    )";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        echo "classrooms table was not created<br>";
        return false;
    }
}

function DropClassroomsTable($conn) 
{
    $sql = "DROP TABLE classrooms";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        echo "classrooms table was not dropped<br>";
        return false;
    }
}

function CreateRequestsTable($conn)
{
    $sql = "CREATE TABLE requests (
    username VARCHAR(255) NOT NULL,
    classroomid INT NOT NULL,
    status ENUM('pending', 'accepted') NOT NULL DEFAULT 'pending',
    PRIMARY KEY (username, classroomid),
    FOREIGN KEY (username) REFERENCES users(username),
    FOREIGN KEY (classroomid) REFERENCES classrooms(classroomid)
    )";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        echo "requests table was not created<br>";
        return false;
    }
}

function DropRequestsTable($conn) 
{
    $sql = "DROP TABLE requests";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        echo "requests table was not dropped<br>";
        return false;
    }
}

function CreateEventsTable($conn)
{
    $sql = "CREATE TABLE events (
    eventid INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    duedate DATETIME NOT NULL,
    classroomid INT NOT NULL,
    type ENUM('homework', 'test', 'announcement') NOT NULL,
    FOREIGN KEY (classroomid) REFERENCES classrooms(classroomid)
    )";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        echo "events table was not created<br>";
        return false;
    }
}

function DropEventsTable($conn) 
{
    $sql = "DROP TABLE events";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        echo "events table was not dropped<br>";
        return false;
    }
}

function ResetTables()
{
$conn = OpenCon();

DropRequestsTable($conn);
DropEventsTable($conn);
DropClassroomsTable($conn);
DropUsersTable($conn);

CreateUsersTable($conn);
CreateClassroomsTable($conn);
CreateRequestsTable($conn);
CreateEventsTable($conn);

CloseCon($conn);
}
?>
