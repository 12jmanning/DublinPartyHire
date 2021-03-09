
<?php
session_start();
include('inc/detail.php');
include('inc/navbar.php');

$deliveryDateErr = $collectionDateErr ="";
$db_deliveryDatetime = $db_collectionDatetime = "";
$grand=true;
$todayDate = date("Y/m/d");

function isValidDate($date,$dateFormat){

    $date = trim($date);
    $time = strtotime($date);

    if(date($dateFormat, $time) < date('Y-m-d')){
        return true;
    }
    else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST"&& isset($_POST['update'])) {
  if (empty($_POST['delivery_date'])) {
    $deliveryDateErr = "Delivery Date is required";
    $grand=false;
  }
  else if (empty($_POST['collection_date'])) {
    $collectionDateErr = "Collection Date is required";
    $grand=false;
  }
  else if($_POST['delivery_date']>$_POST['collection_date'])
  {
    $deliveryDateErr = $collectionDateErr = "Please Enter Valid Dates";
    $grand=false;
  }
  /*else if($_POST['delivery_date']>$todayDate)
  {
    $deliveryDateErr =  "Please Enter Valid Future Dates";
    $grand=false;
  }*/
  else if (isValidDate($_POST['delivery_date'],'Y-m-d'))
  {
    $deliveryDateErr =  "Please Enter Valid Future Dates";
    $grand=false;
  }
  if($grand==true)
  {

    if(isset($_SESSION['cart']))
    {
        unset($_SESSION['cart']);
    }
    $_SESSION['delivery_date'] = $_POST['delivery_date'];
    $_SESSION['collection_date'] = $_POST['collection_date'];
    header('location: index.php?page=products');
  }
}

?>


<div class="row" style="padding-top:10%;">

  <div class="col-lg-2">

  </div>
  <div class="col-lg-8" style="background-color: #e8e8e8;">
    <h2 style="text-align: -webkit-center; margin-top:20px;">Enter Delivery and Collection Dates:</h2>
    <?php
        if(isset($_SESSION['delivery_date'])&&isset($_SESSION['collection_date'])){
          echo "<p style='text-align: -webkit-center;'>
            Changing dates from the dates below will delete all items in your cart!
          </p>";
            echo "<p style='text-align: -webkit-center;'> Order Start Date: ", $_SESSION['delivery_date'], "</p>";
            echo "<p style='text-align: -webkit-center;'> Order End Date: ", $_SESSION['collection_date'], "</p>";
        }
        else{
            echo "<p style='text-align: -webkit-center;'>
            Please enter valid dates for your order before proceeding to the products page.<br>This will allow you to see the products and quantities available for your event!
            </p>";
        }
     ?>

     <form method="post" action = ""  name="order_form" id="order_form" style="text-align: -webkit-center;">
       <br><br>
       <table>


         <tr>
           <td><label for="delivery_date" style="padding-right: 20px;">Start Date:</label></td>
           <td><input type="date" name="delivery_date" id="delivery_date" style="width: 150px;"></td>
             <td><label for="collection_date" style=" padding-left: 20px;">End Date:</label></td>
             <td><input type="date" name="collection_date" id="collection_date" style="width:150px;" ></td>
             <td><input class="btn" type="submit" value="Filter Products" name="update" style="background-color: #C46BAE; color: #fff; margin:auto; margin-left: 20px;"></td>
         </tr>

         <tr>
           <td></td>
           <td><?php echo "<p class='my-error'>", $deliveryDateErr, "</p>" ?></td>
           <td></td>
           <td><?php echo "<p class='my-error'>", $collectionDateErr, "</p>" ?></td>
           <td></td>
         </tr>

        </table>
        <p style="text-align: -webkit-center;">Return To Homepage <a href="index.php">HERE</a></p>
       </form>
  </div>


  <div class="col-lg-2" >
  </div>

</div>
