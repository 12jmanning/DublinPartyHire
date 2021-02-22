<?PHP
//This php script passes the values input by the user into the members table of the database
session_start();
if (isset($_SESSION['db_customerID'])) {
    include ("inc/detail.php");

    $customer_ID = $_SESSION['db_customerID'];
    $delivery_date = $_SESSION['delivery_date'];
    $collection_date = $_SESSION['collection_date'];
    $delivery_and_collection = $_SESSION['delivery_preference'];
    $set_up = $_SESSION['set_up_preference'];
    $set_up_price =  $_SESSION['set_up_cost'];
    $rental_price = $_SESSION['rental_price'];
    $delivery_price = $_SESSION['delivery_price'];
    $time_created = date("Y-m-d H:i:s");
    $comment = $_POST['db_orderComment'];

    $q  = "INSERT INTO orders (";
    $q .= "db_customerID, db_deliveryDatetime, db_collectionDatetime, db_setUpPreference, db_deliveryPreference,db_setUpPrice, db_rentalPrice, db_deliveryPrice, db_orderCreatedAt, db_orderComment";
    $q .= ") VALUES (";
    $q .= "'$customer_ID', '$delivery_date', '$collection_date', '$set_up', '$delivery_and_collection','$set_up_price', '$rental_price','$delivery_price', '$time_created', '$comment')";

    $result_1 = $db->query($q);

    if($delivery_and_collection == "Yes")
    {
        $get_order_ID = ("SELECT orders.db_orderID FROM orders WHERE orders.db_customerID = $customer_ID AND db_deliveryDatetime = '$delivery_date'") ;
        $result = $db->query($get_order_ID);
        $num_results = mysqli_num_rows($result);
        $i=0;
        $found_order_id="";
        while($i<$num_results)
        {
            $row = mysqli_fetch_assoc($result);
            $found_order_id=$row['db_orderID'];
            $i=$i+1;
        }
        $order_ID=$found_order_id;
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

        $transit_record1 = "UPDATE orders, transit SET orders.db_deliveryID = transit.db_transitID WHERE orders.db_orderID = '$order_ID' AND orders.db_orderID = transit.db_orderID AND transit.db_transitType = '$delivery'";
        $update_order1 = $db->query($transit_record1);

        $transit_record2 = "UPDATE orders, transit SET orders.db_collectionID = transit.db_transitID WHERE orders.db_orderID = '$order_ID' AND orders.db_orderID = transit.db_orderID AND transit.db_transitType = '$collection'";
        $update_order2 = $db->query($transit_record2);

    }

    function pdo_connect_mysql() {
        // Update the details below with your MySQL details
        $DATABASE_HOST = 'localhost';
        $DATABASE_USER = 'group_6';
        $DATABASE_PASS = 'zu5ahLie';
        $DATABASE_NAME = 'stu33001_2021_group_6_db';
        try {
            return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
        } catch (PDOException $exception) {
            // If there is an error with the connection, stop the script and display the error.
            exit('Failed to connect to database!');
        }
    }
    //Here the product order table is going to be populated
    $pdo = pdo_connect_mysql();
    $products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
    $products = array();
    // If there are products in cart
    if ($products_in_cart) {
        // There are products in the cart so we need to select those products from the database
        // Products in cart array to question mark string array, we need the SQL statement to include IN (?,?,?,...etc)
        $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
        #ERROR IN THIS NEXT LINE
        $stmt = $pdo->prepare('SELECT * FROM products WHERE db_productID IN (' . $array_to_question_marks . ')');
        // We only need the array keys, not the values, the keys are the id's of the products
        $stmt->execute(array_keys($products_in_cart));
        // Fetch the products from the database and return the result as an Array
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($products as $product) {

            $product_order_product_ID = (int)$product['db_productID'];
            $product_order_product_quantity= (int)$products_in_cart[$product['db_productID']];
            $orderID_product_table = $_SESSION['db_orderID'];

            /*$product_order_product_ID = 1;
            $product_order_product_quantity= 1;
            $orderID_product_table = 1;*/

            $product_order_query = "INSERT INTO product_orders (";
            $product_order_query .= "db_orderID, db_productID, db_quantityOrdered";
            $product_order_query .= ") VALUES (";
            $product_order_query .= "'$orderID_product_table', '$product_order_product_ID', '$product_order_product_quantity')";

            $result_collection = $db->query($product_order_query);
        }

    }
//Change the location of page to an invoice
//Session variables are not deleted here
    header('location: customerdashboard.php');
}
else{
    header('location: existingcustomers.php');
}

?>
