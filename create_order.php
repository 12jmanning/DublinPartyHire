<?PHP
include('inc/detail.php');
include('inc/navbar.php');
?>

<?php
$customer_ID_Err = "";
$delivery_date_Err = "";
$collection_date_Err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$customer_ID = $_POST['customer_ID'];
$delivery_date = $_POST['delivery_date'];
$collection_date = $_POST['collection_date'];



if($customer_ID_Err == "" && $delivery_date_Err == "" && $collection_date_Err == "" ){

$q  = "INSERT INTO orders (";
$q .= "db_customerID, db_deliveryDatetime, db_collectionDatetime";
$q .= ") VALUES (";
$q .= "'$customer_ID', '$delivery_date', '$collection_date')";

$result = $db->query($q);

// header("Location: member_home.php");
// exit;
}
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Create an Order</title>
  </head>
  <body>

    <!-- FORM -->
    <h2 class="form-heading">Make an Order Here!</h2>
    <form class="order_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="order_form" id="order_form">

    <table class="table-forms">
      <th>Details</th>
      <th>Input</th>
      <tr>
        <td><label for="customer_ID">Customer ID:</label></td>
        <td><input type="number" name="customer_ID" id="customer_ID" maxlength="30" required><br><br></td>
      </tr>

      <tr>
        <td><label for="delivery_date">Delivery Date:</label></td>
        <td><input type="date" name="delivery_date" id="delivery_date" required><br><br></td>
      </tr>

      <tr>
        <td><label for="collection_date">Collection Date:</label></td>
        <td><input type="date" name="collection_date" id="collection_date" required><br><br></td>
      </tr>

    <tr>
      <td></td>
      <td><input class="btn btn-success" type="submit" value="Submit"><input style="margin-left: 4px;"class="btn btn-danger" type="reset" value="Reset"></td>
    </tr>
    </table>

    </form>

      </body>
</html>
