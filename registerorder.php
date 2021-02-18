<?PHP
//This php script passes the values input by the user into the members table of the database
session_start();
if (isset($_SESSION['db_customerID'])) {
    include ("inc/detail.php");

    $customer_ID = $_SESSION['db_customerID'];
    $delivery_date = $_SESSION['delivery_date']
    $collection_date = $_SESSION['collection_date']
    $delivery_and_collection = $_SESSION['delivery_preference']
    $set_up = $_SESSION['set_up_preference']

    $q  = "INSERT INTO orders (";
    $q .= "db_customerID, db_deliveryDatetime, db_collectionDatetime, db_setUp, db_deliveryPreference";
    $q .= ") VALUES (";
    $q .= "'$customer_ID', '$delivery_date', '$collection_date', '$set_up', '$delivery_and_collection')";

    $result_1 = $db->query($q);

    if($delivery_and_collection == "Yes")
    {
        //$get_order_ID = ("SELECT db_orderID FROM orders WHERE db_customerID = $customer_ID AND db_deliveryDatetime = $delivery_date  AND db_collectionDatetime = $collection_date") ;
        $get_order_ID = "SELECT * FROM orders";
        $result = $db->query($get_order_ID);
        $num_results = mysqli_num_rows($result);

        $i=0;
        $found_order_id="";
        while($i<$num_results&&$found<>true)
        {
            $row = mysqli_fetch_assoc($result); 
            if($row['db_customerID']==$db_customerID&&$row['db_deliveryDatetime']==$delivery_date)
            {
                $found_order_id=$row['db_orderID'];
                $found=true;
            }
            $i++;
        }
        if($found==true)
        {
            $_SESSION['db_orderID']=$found_order_id;
        }


        //$order_ID = $row['db_orderID'];
        $order_ID=$_SESSION['db_orderID'];
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
