<?php
//The order status page is called in the customer dashboard and allows them to select any of their past or future ordersitted, the status of that particular order is printed out to the customer below the form. 
session_start();
include('inc/detail.php');


if (!isset($_SESSION['db_customerID'])) {
    header('location: existingcustomers.php');
}

$customer_ID = $_SESSION['db_customerID'];
$query = "SELECT * FROM orders where db_customerID = $customer_ID";
$customer_orders = $db->query($query);
$num_results = mysqli_num_rows($customer_orders);


$details_query = "SELECT db_customerName, db_customerAddress, db_county, db_customerEircode, db_customerPhone FROM `customers`
                        WHERE db_customerID = '$customer_ID'";
$customer_details = $db->query($details_query);
$row = mysqli_fetch_assoc($customer_details);
$customer_name = $row['db_customerName'] ;
$customer_address = $row['db_customerAddress'] ;
$customer_county = $row['db_county'] ;
$customer_eircode = $row['db_customerEircode'] ;
$customer_phone = $row['db_customerPhone'] ;

$orderErr="";
$valid=true;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit3'])) {
    if (empty($_POST["order_id"])) {
        $orderErr = "Order is required";
        $valid=false;
    }
    else if ($_POST["order_id"]=='select') {
        $orderErr = "Order is required";
        $valid=false;
    }

    if($valid){

        $db_orderID = $_POST["order_id"];
        $query1 = "SELECT * FROM orders where db_orderID = $db_orderID";
        $customer_orders1 = $db->query($query1);
        $num_results1 = mysqli_num_rows($customer_orders1);
        $row2 = mysqli_fetch_assoc($customer_orders1);
        $delivery_date = $row2['db_deliveryDatetime'];
        $collection_date = $row2['db_collectionDatetime'];
        $deliveryPreference = $row2['db_deliveryPreference'];
        $Yes='Yes';
        $No='No';
        $nice_collection_date = date("D, d M Y", strtotime($collection_date));
        $nice_delivery_date = date("D, d M Y", strtotime($delivery_date));
        $during = "You currently have your rented items. They are due to be returned by $collection_date";
        $before = "Will be delivered on $nice_delivery_date";
        $after = "Was collected on $nice_collection_date";
        $before1 = "You are due to collect your order on $nice_delivery_date";
        $after1 = "You have returned your rented items $nice_collection_date";
        $deliver_today = "Your order is to be delivered today";
        $deliver_today1 = "You are due to collect your order today";
        $collect_today = "Your order is to be collected today" ;
        $collect_today1 = "You are due to return your order today";

        $dateFormat= 'Y-m-d';
        $date = trim($delivery_date);
        $time = strtotime($date);
        $date1 = trim($collection_date);
        $time1 = strtotime($date1);

        if(date($dateFormat, $time) == date('Y-m-d') && $deliveryPreference==$Yes)
        {
            $string_output = $deliver_today;
        }
        else if(date($dateFormat, $time) == date('Y-m-d') && $deliveryPreference==$No)
        {
            $string_output = $deliver_today1;
        }
        else if(date($dateFormat, $time1) > date('Y-m-d') && date($dateFormat, $time) < date('Y-m-d'))
        {
            $string_output = $during;
        }

        else if(date($dateFormat, $time1) == date('Y-m-d') && $deliveryPreference==$Yes)
        {
            $string_output = $collect_today;
        }
        else if(date($dateFormat, $time1) == date('Y-m-d') && $deliveryPreference==$No)
        {
            $string_output = $collect_today1;
        }

        else if(date($dateFormat, $time) > date('Y-m-d') && $deliveryPreference==$Yes)
        {
            $string_output = $before ;
        }
        else if(date($dateFormat, $time1) < date('Y-m-d') && $deliveryPreference==$Yes)
        {
            $string_output = $after;
        }
        else if(date($dateFormat, $time) > date('Y-m-d') && $deliveryPreference==$No)
        {
            $string_output = $before1 ;
        }
        else if(date($dateFormat, $time1) < date('Y-m-d') && $deliveryPreference==$No)
        {
            $string_output = $after1;
        }
    }
}
?>

  <h2 style="padding-top:25px;">Order Status:</h2>
  <form class="" action="" method="post" name="invoice" id="invoice">

  <table class="">

  <tr>
    <td><label for="order_id" style="width: 100px;">Select an Order ID:</label></td>
    <td style="width: 618px; height: 38px;" class="auto-style2">
    <select name="order_id" style="width: 300px" class="auto-style1" required>
    <option value= "select">--Select an Order--</option>
    <?php
      for($i = 0;$i<$num_results;$i++)
      {
        $row = mysqli_fetch_assoc($customer_orders);
        $q = 'select * from orders where '.$row['db_orderID'].'= orders.db_orderID';
        $result2 = $db->query($q);
        $row2 = mysqli_fetch_assoc($result2);
        
        echo '<<option value ="'.$row['db_orderID'].'">Order ID: '.$row['db_orderID']." Rented From ".date("D, d M Y", strtotime($row['db_deliveryDatetime'])) .'</option>';
      }
    ?>


  </tr>

  <tr>
    <td></td>
    <td><input class="btn btn-success" type="submit" name ="submit3" value="Submit"><input style="margin-left: 4px;"class="btn btn-danger" type="reset" value="Reset"></td>
  </tr>
  </table>

  </form>
  <?php
  if(isset($string_output))
  {
      echo "<div class='alert alert-success' role='alert'>", $string_output, "</div>";
  }
  ?>
