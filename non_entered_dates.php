
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
    $deliveryDateErr = "Collection Date is required";
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
    header('location: products.php');
  }
}

?>


<div class="row" style="padding-top:25px;">

  <div class="col-lg-1">

  </div>
  <div class="col-lg-4">
    <h2>Details:</h2>
    <?php
        if(isset($_SESSION['delivery_date'])&&isset($_SESSION['collection_date'])){
            echo "Order Start Date: ", $_SESSION['delivery_date'], "<br>";
            echo "Order End Date: ", $_SESSION['collection_date'], "<br>";
        }
        else{
            echo "Please enter valid dates for your before proceeding to the products page.<br>This will allow you to see the products and quantities available for your event!";
        }
     ?>
  </div>


  <div class="col-lg-6" >
  <form method="post" action = ""  name="order_form" id="order_form" style="text-align: -webkit-center;">
    <br><br>
      <tr>
        <td><label for="delivery_date" style="padding-right: 20px;">Delivery Date:</label></td>
        <td ><input type="date" name="delivery_date" id="delivery_date" style="width: 150px;"><?php echo $deliveryDateErr ?> <span></td>
          <td><label for="collection_date" style="padding-right: 20px; padding-left: 20px;">Collection Date:</label></td>
          <td><input type="date" name="collection_date" id="collection_date" style="width:150px;" ><?php echo $collectionDateErr ?> <span></td>
          <td><input class="btn" type="submit" value="Filter Products" name="update" style="background-color: #C46BAE; color: #fff; margin:auto; margin-left: 20px;"></td>
      </tr>
      <tr>
      <td></td>
      <td><p>Return To Homepage <a href="index.php">HERE</a></p></td>
    </tr>
    </form>
  </div>

</div>