<?php

/**
 * @codeCoverageIgnore
 */
function OpenCon()
{
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $db = "homework hub";
    $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
 
    return $conn;
}

/**
 * @codeCoverageIgnore
 */
function CloseCon($conn)
{
    $conn -> close();
}
?>
