<?php
require_once 'sql_connection.php';

/**
 * @codeCoverageIgnore
 */
function CreateUsersTable()
{
    $conn = OpenCon();
    $sql = "CREATE TABLE users (
    username VARCHAR(255) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    type ENUM('parent', 'teacher') NOT NULL DEFAULT 'parent'
    )";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "users table was not created<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function DropUsersTable() 
{
    $conn = OpenCon();
    $sql = "DROP TABLE users";

    if ($conn->query($sql)) {
        CloseCon($conn);
        return true;
    } else {
        echo "users table was not dropped<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function TruncateUsersTable() 
{
    $conn = OpenCon();
    $sql = "TRUNCATE TABLE users";

    if ($conn->query($sql)) {
        CloseCon($conn);
        return true;
    } else {
        echo "users table was not truncated<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function CreateClassroomsTable()
{
    $conn = OpenCon();
    $sql = "CREATE TABLE classrooms (
    classroomname VARCHAR(255) NOT NULL,
    classroomid INT PRIMARY KEY AUTO_INCREMENT,
    teachername VARCHAR(255) NOT NULL,
    joincode VARCHAR(255) NOT NULL,
    FOREIGN KEY (teachername) REFERENCES users(username) ON UPDATE CASCADE
    )";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "classrooms table was not created<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function DropClassroomsTable() 
{
    $conn = OpenCon();
    $sql = "DROP TABLE classrooms";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "classrooms table was not dropped<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function TruncateClassroomsTable() 
{
    $conn = OpenCon();
    $sql = "TRUNCATE TABLE classrooms";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "classrooms table was not truncated<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function CreateRequestsTable()
{
    $conn = OpenCon();
    $sql = "CREATE TABLE requests (
    username VARCHAR(255) NOT NULL,
    classroomid INT NOT NULL,
    PRIMARY KEY (username, classroomid),
    FOREIGN KEY (username) REFERENCES users(username) ON UPDATE CASCADE,
    FOREIGN KEY (classroomid) REFERENCES classrooms(classroomid)
    )";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "requests table was not created<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function DropRequestsTable()
{
    $conn = OpenCon();
    $sql = "DROP TABLE requests";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "requests table was not dropped<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function TruncateRequestsTable()
{
    $conn = OpenCon();
    $sql = "TRUNCATE TABLE requests";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "requests table was not truncated<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function CreateHomeworksTable()
{
    $conn = OpenCon();
    $sql = "CREATE TABLE homeworks (
    homeworkid INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    duedate DATE NOT NULL,
    points INT NOT NULL,
    classroomid INT NOT NULL,
    FOREIGN KEY (classroomid) REFERENCES classrooms(classroomid)
    )";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "homeworks table was not created<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function DropHomeworksTable() 
{
    $conn = OpenCon();
    $sql = "DROP TABLE homeworks";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "homeworks table was not dropped<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function TruncateHomeworksTable() 
{
    $conn = OpenCon();
    $sql = "TRUNCATE TABLE homeworks";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "homeworks table was not truncated<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function CreateTestsTable()
{
    $conn = OpenCon();
    $sql = "CREATE TABLE tests (
    testid INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    duedate DATE NOT NULL,
    points INT NOT NULL,
    timelimit INT NOT NULL,
    classroomid INT NOT NULL,
    FOREIGN KEY (classroomid) REFERENCES classrooms(classroomid)
    )";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "tests table was not created<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function DropTestsTable() 
{
    $conn = OpenCon();
    $sql = "DROP TABLE tests";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "tests table was not dropped<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function TruncateTestsTable() 
{
    $conn = OpenCon();
    $sql = "TRUNCATE TABLE tests";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "tests table was not truncated<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function CreateAnnouncementsTable()
{
    $conn = OpenCon();
    $sql = "CREATE TABLE announcements (
    announcementid INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    duedate DATE NOT NULL,
    classroomid INT NOT NULL,
    FOREIGN KEY (classroomid) REFERENCES classrooms(classroomid)
    )";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "announcements table was not created<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function DropAnnouncementsTable() 
{
    $conn = OpenCon();
    $sql = "DROP TABLE announcements";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "announcements table was not dropped<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function TruncateAnnouncementsTable() 
{
    $conn = OpenCon();
    $sql = "TRUNCATE TABLE announcements";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "announcements table was not truncated<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function CreateTeachersTable()
{
    $conn = OpenCon();
    $sql = "CREATE TABLE Teachers (
    teacherUserName VARCHAR(255) PRIMARY KEY,
    gender ENUM('male', 'female') NOT NULL,
    email VARCHAR(255) NOT NULL,
    mobile_no INT NOT NULL,
    school VARCHAR(255) NOT NULL,
    FOREIGN KEY (teacherUserName) REFERENCES users(username) ON UPDATE CASCADE 
    )";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "Teachers table was not created<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function DropTeachersTable() 
{
    $conn = OpenCon();
    $sql = "DROP TABLE Teachers";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "Teachers table was not dropped<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function TruncateTeachersTable() 
{
    $conn = OpenCon();
    $sql = "TRUNCATE TABLE Teachers";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "Teachers table was not truncated<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function ResetTables()
{
    DropAllTables();
    CreateAllTables();
}

/**
 * @codeCoverageIgnore
 */
function DropAllTables()
{
    DropRequestsTable();
    DropAnnouncementsTable();
    DropTestsTable();
    DropHomeworksTable();
    DropClassroomsTable();
    DropTeachersTable();
    DropUsersTable();
}

/**
 * @codeCoverageIgnore
 */
function CreateAllTables()
{
    CreateUsersTable();
    CreateClassroomsTable();
    CreateRequestsTable();
    CreateHomeworksTable();
    CreateTestsTable();
    CreateAnnouncementsTable();
    CreateTeachersTable();
}

?>
