<?PHP
//This php script passes the values input by the user into the members table of the database
session_start();
if (isset($_SESSION['db_customerID'])) {
    include ("inc/detail.php");

    $customer_ID = $_SESSION['db_customerID'];
    $delivery_date = $_POST['delivery_date'];
    $collection_date = $_POST['collection_date'];
    $delivery_and_collection = $_POST['delivery_and_collection'];
    $set_up = $_POST['set_up'];

    $q  = "INSERT INTO orders (";
    $q .= "db_customerID, db_deliveryDatetime, db_collectionDatetime";
    $q .= ") VALUES (";
    $q .= "'$customer_ID', '$delivery_date', '$collection_date')";

    echo $q;
    $result = $db->query($q);

    if($delivery_and_collection == "Yes")
    {
        $get_order_ID = "SELECT db_orderID FROM orders WHERE db_customerID == $customer_ID AND db_deliveryDatetime = $delivery_date  AND db_collectionDatetime = $collection_date" ;
        
    }


}
else{
    header('location: existingcustomers.php');
}


?>
