<?PHP
//This php script passes the values input by the user into the members table of the database
session_start();
if (isset($_SESSION['db_customerID'])) {
    include ("inc/detail.php");

    $customer_ID = $_SESSION['db_customerID'];
    $delivery_date = $_POST['delivery_date'];
    $collection_date = $_POST['collection_date'];

    $q  = "INSERT INTO orders (";
    $q .= "db_customerID, db_deliveryDatetime, db_collectionDatetime";
    $q .= ") VALUES (";
    $q .= "'$customer_ID', '$delivery_date', '$collection_date')";

    echo $q;
    $result = $db->query($q);
    header('location: index.php');
}
else{
    header('location: existingcustomers.php');
}


?>
