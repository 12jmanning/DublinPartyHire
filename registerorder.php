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

    $result_1 = $db->query($q);

    if($delivery_and_collection == "Yes")
    {
        $get_order_ID = ("SELECT db_orderID FROM orders WHERE db_customerID = $customer_ID AND db_deliveryDatetime = $delivery_date  AND db_collectionDatetime = $collection_date") ;
        $result = $db->query($get_order_ID);
        $num_results = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);
        $order_ID = $row['db_orderID'];
        $collection= "collection";
        $delivery= "delivery";

        $q2  = "INSERT INTO transit (";
        $q2 .= "db_orderID, db_transitType";
        $q2 .= ") VALUES (";
        $q2 .= "'$order_ID', '$collection')";
        $result_collection = $db->query($q2);
        
        $q1  = "INSERT INTO transit (";
        $q1 .= "db_orderID, db_transitType";
        $q1 .= ") VALUES (";
        $q1 .= "'$order_ID', '$delivery')";
        $result_delivery = $db->query($q1);

        $_SESSION['db_orderID']= $order_ID;
    }
    echo $result;








}
else{
    header('location: existingcustomers.php');
}


?>
