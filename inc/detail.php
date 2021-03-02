<?php

$host = "localhost";

$database = "stu33001_2021_group_6_db";

$user = "group_6";

$password = "zu5ahLie";

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'group_6');
define('DB_PASSWORD', 'zu5ahLie');
define('DB_NAME', 'stu33001_2021_group_6_db');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);


@ $db = mysqli_connect($host, $user, $password, $database);


$db->select_db($database);


if (mysqli_connect_errno())
{
echo 'Error connecting to the db.';
exit;
}


?>
