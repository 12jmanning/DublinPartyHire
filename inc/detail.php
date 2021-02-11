<?php

$host = "localhost";

$database = "stu33001_2021_group_6_db";

$user = "group_6";

$password = "zu5ahLie";




@ $db = mysqli_connect($host, $user, $password, $database);

$db->select_db($database);


if (mysqli_connect_errno())
{
echo 'Error connecting to the db.';
exit;
}


?>
