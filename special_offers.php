<?php
session_start();
include('inc/detail.php');
include('inc/navbar.php');

$admin_ID = $_SESSION['db_employeeID'];
$employee_name = $_SESSION['db_employeeName'];
$job_title = $_SESSION['db_jobTitle'];
$admin="admin";

if($job_title==$admin){
    $product_query = "SELECT * FROM products";
    $product_results = $db->query($product_query);
    $product_results1 = $db->query($product_query);
    $product_results2 = $db->query($product_query);
    $product_results3 = $db->query($product_query);
    $num_product_results = mysqli_num_rows($product_results);

}
$productErr = $product1Err =$product2Err= $product3Err= "";
$valid=true;
if ($_SERVER["REQUEST_METHOD"] == "POST"&& isset($_POST['submit2'])) {
    if ($_POST["product_id"]=="select") {
        $productErr = "Product is required";
        $valid=false;
    }
    if ($_POST["product_id1"]=="select") {
        $product1Err = "Product is required";
        $valid=false;
    }
    if ($_POST["product_id2"]=="select") {
        $product2Err = "Product is required";
        $valid=false;
    }
    if ($_POST["product_id3"]=="select") {
        $product3Err = "Product is required";
        $valid=false;
    }
    if($valid)
    {
        if($_POST["product_id"]==$_POST["product_id1"]||$_POST["product_id"]==$_POST["product_id2"]||$_POST["product_id"]==$_POST["product_id3"])
        {
            $productErr = "Must Select Different Products";
            $product1Err = "Must Select Different Products";
            $product2Err = "Must Select Different Products";
            $product3Err = "Must Select Different Products";
            $valid=false;
        }
        else if($_POST["product_id1"]==$_POST["product_id"]||$_POST["product_id1"]==$_POST["product_id2"]||$_POST["product_id1"]==$_POST["product_id3"])
        {
            $productErr = "Must Select Different Products";
            $product1Err = "Must Select Different Products";
            $product2Err = "Must Select Different Products";
            $product3Err = "Must Select Different Products";
            $valid=false;
        }
        else if($_POST["product_id2"]==$_POST["product_id"]||$_POST["product_id2"]==$_POST["product_id1"]||$_POST["product_id2"]==$_POST["product_id3"])
        {
            $productErr = "Must Select Different Products";
            $product1Err = "Must Select Different Products";
            $product2Err = "Must Select Different Products";
            $product3Err = "Must Select Different Products";
            $valid=false;
        }
        else if($_POST["product_id3"]==$_POST["product_id"]||$_POST["product_id3"]==$_POST["product_id1"]||$_POST["product_id3"]==$_POST["product_id2"])
        {
            $productErr = "Must Select Different Products";
            $product1Err = "Must Select Different Products";
            $product2Err = "Must Select Different Products";
            $product3Err = "Must Select Different Products";
            $valid=false;
        }
    }


    
    #Problem is with this if statement
    if($valid!=false)
    {
        $db_productID =$_POST['product_id'];
        $db_productID1 =$_POST['product_id1'];
        $db_productID2 =$_POST['product_id2'];
        $db_productID3 =$_POST['product_id3'];

        $query1 = "UPDATE special_offers SET db_productID = '$db_productID' WHERE db_specialOfferID = 1";
        $edit_product1 = $db->query($query1);

        $query2 = "UPDATE special_offers SET db_productID = '$db_productID1' WHERE db_specialOfferID = 2";
        $edit_product2 = $db->query($query2);

        $query3 = "UPDATE special_offers SET db_productID = '$db_productID2' WHERE db_specialOfferID = 3";
        $edit_product3 = $db->query($query3);

        $query4 = "UPDATE special_offers SET db_productID = '$db_productID3' WHERE db_specialOfferID = 4";
        $edit_product4 = $db->query($query4);
        header('Location: admindashboard.php');

    }

}


?>

<div class="row" style="padding-top:25px;">

  <div class="col-lg-1">

  </div>
  <div class="col-lg-4">
    <h2>My Details:</h2>
    <?php
          echo "Employee ID  ", $employee_ID, "<br>";
          echo "Name: ", $employee_name, "<br>";
          echo "Job Title: ", $job_title, "<br>";
     ?>
  </div>


  <div class="col-lg-6" >
    <form class="dd" action="" method="post" >

    <table class="dd">

    <tr>
      <td><label for="order_id">Product 1:</label></td>
      <td style="width: 399px; height: 38px;" class="auto-style2">
      <span class='error'> <?php echo $productErr ?> <span>
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
      <td><label for="order_id">Product 2:</label></td>
      <td style="width: 399px; height: 38px;" class="auto-style2">
      <span class='error'> <?php echo $product1Err ?> <span>
      <select name="product_id1" style="width: 399px" class="auto-style1" required>
      <option value= "select">--Select a Product--</option>
      <?php
        for($i = 0;$i<$num_product_results;$i++)
        {
          //Move query up top and iterate through results here with an if statement
          $row1 = mysqli_fetch_assoc($product_results1);
          echo '<option value = "'.$row1['db_productID'].'"> Product Name: '.$row1['db_productName']." Current Quantity: ".$row1['db_quantity'].' </option>';

        }
      ?>
    </tr>
    <tr>
      <td><label for="order_id">Product 3:</label></td>
      <td style="width: 399px; height: 38px;" class="auto-style2">
      <span class='error'> <?php echo $product2Err ?> <span>
      <select name="product_id2" style="width: 399px" class="auto-style1" required>
      <option value= "select">--Select a Product--</option>
      <?php
        for($i = 0;$i<$num_product_results;$i++)
        {
          //Move query up top and iterate through results here with an if statement
          $row2 = mysqli_fetch_assoc($product_results2);
          echo '<option value = "'.$row2['db_productID'].'"> Product Name: '.$row2['db_productName']." Current Quantity: ".$row2['db_quantity'].' </option>';

        }
      ?>
    </tr>
    <tr>
      <td><label for="order_id">Product 4:</label></td>
      <td style="width: 399px; height: 38px;" class="auto-style2">
      <span class='error'> <?php echo $product3Err ?> <span>
      <select name="product_id3" style="width: 399px" class="auto-style1" required>
      <option value= "select">--Select a Product--</option>
      <?php
        for($i = 0;$i<$num_product_results;$i++)
        {
          //Move query up top and iterate through results here with an if statement
          $row3 = mysqli_fetch_assoc($product_results3);
          echo '<option value = "'.$row3['db_productID'].'"> Product Name: '.$row3['db_productName']." Current Quantity: ".$row3['db_quantity'].' </option>';

        }
      ?>
    </tr>
    <tr>
      <td></td>
      <td><input class="btn btn-success" type="submit" value="Submit" name ="submit2"><input style="margin-left: 4px;"class="btn btn-danger" type="reset" value="Reset"></td>
    </tr>

    
    </table>
    <tr>
      <td></td>
      <td><p>Return To Homepage <a href="index.php">HERE</a></p></td>
    </tr>
    <tr>

    </form>
  </div>

</div>