<?php
function CreateUsersTable($conn)
{
    $sql = "CREATE TABLE users (
    username VARCHAR(255) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    type ENUM('parent', 'teacher') DEFAULT 'parent'
    )";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

function DropUsersTable($conn) 
{
    $sql = "DROP TABLE users";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return true;
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
        return false;
    }
}

function DropClassroomsTable($conn) 
{
    $sql = "DROP TABLE classrooms";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return true;
    }
}

function CreateRequestsTable($conn)
{
    $sql = "CREATE TABLE requests (
    username VARCHAR(255) NOT NULL,
    classroomname VARCHAR(255) NOT NULL,
    PRIMARY KEY (username, classroomname)
    )";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

function DropRequestsTable($conn) 
{
    $sql = "DROP TABLE requests";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return true;
    }
}
?>
