<?php
include 'sql_connection.php';
include 'create_tables.php';

$conn = OpenCon();

DropUsersTable($conn);
DropClassroomsTable($conn);
DropRequestsTable($conn);
DropEventsTable($conn);

CreateUsersTable($conn);
CreateClassroomsTable($conn);
CreateRequestsTable($conn);
CreateEventsTable($conn);

CloseCon($conn);
?>
