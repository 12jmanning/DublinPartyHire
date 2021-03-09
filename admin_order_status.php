<?php
session_start();
include('inc/detail.php');



if($_SESSION['db_jobTitle']=="admin"){
    $employee_ID = $_SESSION['db_employeeID'];
    $employee_name = $_SESSION['db_employeeName'];
    $job_title = $_SESSION['db_jobTitle'];

    $delivery_query = "SELECT * FROM delivery_costs";
    $delivery_results = $db->query($delivery_query);
    $num_delivery_results = mysqli_num_rows($delivery_results);


}

$queryz = "SELECT * FROM orders";
$customer_ordersx = $db->query($queryz);
$num_resultsx = mysqli_num_rows($customer_ordersx);
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
        $queryx = "SELECT * FROM orders where db_orderID = $db_orderID";
        $customer_orders1 = $db->query($queryx);
        $num_results1 = mysqli_num_rows($customer_orders1);
        $rowx = mysqli_fetch_assoc($customer_orders1);
        $delivery_date = $rowx['db_deliveryDatetime'];
        $collection_date = $rowx['db_collectionDatetime'];
        $deliveryPreference = $rowx['db_deliveryPreference'];
        $Yes='Yes';
        $No='No';

        $nice_collection_date = date("D, d M Y", strtotime($collection_date));
        $nice_delivery_date = date("D, d M Y", strtotime($delivery_date));

        $during = "The customer currently has the rented items. They are due to be returned by" .  $nice_collection_date;
        $before = "The order will be delivered on " . $nice_delivery_date ;
        $after = "The order was collected on " . $nice_collection_date ;
        $before1 = "The customer is due to collect the order on " . $nice_delivery_date;
        $after1 = "The customer has returned the rented items " . $nice_collection_date;
        $deliver_today = "The order is to be delivered today";
        $deliver_today1 = "The customer is due to have their order collected today";
        $collect_today = "The customer is due to collect their order today" ;
        $collect_today1 = "The customer is due to return their rented items today";

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


            <form class="dd" action="" method="post" >
              <label for="order_id" >Select an Order ID:</label>
            <table class="dd">




              <tr>
                <td style="width: 618px; height: 38px;" class="auto-style2">
                <select name="order_id" style="width: 300px" class="auto-style1" required>
                <option value= "select">--Select an Order--</option>
                <?php
                for($i = 0;$i<$num_resultsx;$i++)
                {
                    $rowy = mysqli_fetch_assoc($customer_ordersx);
                    $q = 'select * from orders where '.$rowy['db_orderID'].'= orders.db_orderID';
                    $result2 = $db->query($q);
                    $row2 = mysqli_fetch_assoc($result2);

                    echo '<<option value ="'.$rowy['db_orderID'].'">Order ID: '.$rowy['db_orderID']." On ".$rowy['db_deliveryDatetime'].'</option>';
                }
                ?>


            </tr>

            <tr>
                <td><input class="btn btn-success" type="submit" name ="submit3" value="Submit"><input style="margin-left: 4px;"class="btn btn-danger" type="reset" value="Reset"></td>
            </tr>
            </table>

            </form>
            <br>

            <?php
            if(isset($string_output))
            {
              echo "<div class='alert alert-success' role='alert'>", $string_output, "</div>";
            }
            ?>
