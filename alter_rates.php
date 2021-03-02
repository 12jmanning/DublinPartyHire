<?php
session_start();
include('inc/detail.php');
include('inc/navbar.php');


if($_SESSION['db_jobTitle']=="admin"){
    $employee_ID = $_SESSION['db_employeeID'];
    $employee_name = $_SESSION['db_employeeName'];
    $job_title = $_SESSION['db_jobTitle'];

    $delivery_query = "SELECT * FROM delivery_costs";
    $delivery_results = $db->query($delivery_query);
    $num_delivery_results = mysqli_num_rows($deliver_results);

    $product_results1 = $db->query($product_query);
    $num_product_results1 = mysqli_num_rows($product_results1);
}

$countyErr= "";
$priceErr="";
$quantityErr="";
$valid= true;
if ($_SERVER["REQUEST_METHOD"] == "POST"&& isset($_POST['submit'])) {
    if (empty($_POST["db_countyID"])) {
        $countyErr = "County is required";
        $valid=false;
    }
    if (empty($_POST["db_countyPrice"])) {
        $priceErr = "County Price is required";
        $valid=false;
    }
    if($valid)
    {
        if (!is_numeric($_POST["db_countyPrice"])) {
            $priceErr = "county Price must be numeric";
            $valid=false;
        }
        else if ($_POST["db_countyPrice"]<=0) {
            $priceErr = "County Price must be greater than 0";
            $valid=false;
        }
    }
    #Problem is with this if statement
    if($valid!=false)
    {
        $db_countyID =$_POST['db_countyID'];
        $db_countyPrice=$_POST['db_countyPrice'];
        $query = "UPDATE delivery_costs SET db_countyPrice = '$db_countyPrice' WHERE db_countyID = '$db_countyID'";
        $edit_county = $db->query($query);
    }

}

if ($_SERVER["REQUEST_METHOD"] == "POST"&& isset($_POST['submit2'])) {
    if (empty($_POST["product_id"])) {
        $productErr = "Product is required";
        $valid=false;
    }
    if (empty($_POST["db_quantity"])) {
        $priceErr = "Product quantity is required";
        $valid=false;
    }
    if($valid)
    {
        if (!is_numeric($_POST["db_quantity"])) {
            $quantityErr = "Product quantity must be numeric";
            $valid=false;
        }
        else if ($_POST["db_quantity"]<=0) {
            $quantityErr = "Product quantity must be greater than 0";
            $valid=false;
        }
    }
    #Problem is with this if statement
    if($valid!=false)
    {
        $db_productID =$_POST['product_id'];
        $db_quantity=$_POST['db_quantity'];
        $query1 = "UPDATE products SET db_quantity = '$db_quantity' WHERE db_productID = '$db_productID'";
        $edit_product1 = $db->query($query1);
    }

}

?>



<div class="row" style="padding-top:25px;">

  <div class="col-lg-1">

  </div>
  <div class="col-lg-4">
    <h2>My Details:</h2>
    <?php
          echo "Employee ID: ", $employee_ID, "<br>";
          echo "Name: ", $employee_name, "<br>";
          echo "Job Title: ", $job_title, "<br>";
     ?>
  </div>


  <div class="col-lg-6" >
    <h2>Alter The Price of Delivery:</h2>
    <form class="dd" action="" method="post" >

    <table class="dd">

    <tr>
      <td><label for="order_id">County:</label></td>
      <td style="width: 399px; height: 38px;" class="auto-style2">
      <select name="db_countyID" style="width: 399px" class="auto-style1" required>
      <option value= "select">--Select a County--</option>
      <?php
        for($i = 0;$i<$num_county_results;$i++)
        {
          //Move query up top and iterate through results here with an if statement
          $row = mysqli_fetch_assoc($county_results);
          echo '<option value = "'.$row['db_countyID'].'"> County Name: '.$row['db_countyName']." Delivery Price: ".$row['db_countyPrice'].' </option>';

        }
      ?>
    </tr>
    <tr>
        <td><label for ="members">New Price:</label></td>
        <td><input type="text" name="db_countyPrice" id="db_countyPrice" size = 20><span class='error'> <?php echo $priceErr ?> <span></td>
    </tr>
    <tr>
      <td></td>
      <td><input class="btn btn-success" type="submit" value="Submit" name ="submit"><input style="margin-left: 4px;"class="btn btn-danger" type="reset" value="Reset"></td>
    </tr>
    </table>

    </form>
  </div>


  <div class="col-lg-6" >
    <h2>Alter The Quantity of Products:</h2>
    <form class="dd" action="" method="post" >

    <table class="dd">

    <tr>
      <td><label for="order_id">Product Name:</label></td>
      <td style="width: 399px; height: 38px;" class="auto-style2">
      <select name="product_id" style="width: 399px" class="auto-style1" required>
      <option value= "select">--Select a Product--</option>
      <?php
        for($i = 0;$i<$num_product_results;$i++)
        {
          //Move query up top and iterate through results here with an if statement
          $row = mysqli_fetch_assoc($product_results);
          echo '<option value = "'.$row['db_productID'].'"> Product Name: '.$row['db_productName']." Current Quantity: ".$row['db_quantity'].' </option>';

        }
      ?>
    </tr>
    <tr>
        <td><label for ="members">New Quantity:</label></td>
        <td><input type="text" name="db_quantity" id="db_quantity" size = 20><span class='error'> <?php echo $quantityErr ?> <span></td>
    </tr>
    <tr>
      <td></td>
      <td><input class="btn btn-success" type="submit" value="Submit" name ="submit2"><input style="margin-left: 4px;"class="btn btn-danger" type="reset" value="Reset"></td>
    </tr>
    </table>

    </form>

  </div>

</div>
