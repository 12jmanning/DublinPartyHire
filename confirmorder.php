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
    $customer_cart = $_SESSION['cart'];


    echo $subtotal;
    echo $setup2;
    echo $customer_ID;
    echo $delivery_date;
    echo $collection_date;
    echo $delivery_and_collection;
    echo $set_up;
    echo $customer_cart;
    echo '<pre>'; print_r($customer_cart); echo '</pre>';

}
else{
    header('location: existingcustomers.php');
}


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

  </body>
</html>
