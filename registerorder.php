<?PHP
//This php script passes the values input by the user into the members table of the database
session_start();

include ("inc/detail.php");

$customer_ID = $_POST['customer_ID'];
$delivery_date = $_POST['delivery_date'];
$collection_date = $_POST['collection_date'];

$q  = "INSERT INTO orders (";
$q .= "db_customerID, db_deliveryDatetime, db_collectionDatetime";
$q .= ") VALUES (";
$q .= "'$customer_ID', '$delivery_date', '$collection_date')";

echo $q;
$result = $db->query($q);

?>
