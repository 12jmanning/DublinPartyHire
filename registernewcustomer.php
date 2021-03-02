<?PHP
//This php script passes the values input by the user into the members table of the database
session_start();

include ("inc/detail.php");

$db_customerName = $_POST['db_customerName'];
$db_customerAddress = $_POST['db_customerAddress'];
$db_county = $_POST['db_county'];
$db_customerEircode = $_POST['db_customerEircode'];
$db_customerEmail = $_POST['db_customerEmail'];
$db_customerPhone = $_POST['db_customerPhone'];

$password = $_POST['password'];
$db_customerPW = password_hash($password, PASSWORD_DEFAULT);

$q  = "INSERT INTO customers (";
$q .= "db_customerName, db_customerAddress, db_county, db_customerEircode, db_customerEmail, db_customerPhone, db_customerPW";
$q .= ") VALUES (";
$q .= "'$db_customerName', '$db_customerAddress', '$db_county', '$db_customerEircode','$db_customerEmail','$db_customerPhone', '$db_customerPW')";

echo $q;
$result = $db->query($q);

?>
