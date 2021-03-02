<?php
session_start();
include('inc/detail.php');
include('inc/navbar.php');


if($_SESSION['db_jobTitle']=="admin"){
    $employee_ID = $_SESSION['db_employeeID'];
    $employee_name = $_SESSION['db_employeeName'];
    $job_title = $_SESSION['db_jobTitle'];

    $product_query = "SELECT * FROM products";
    $product_results = $db->query($product_query);
    $num_product_results = mysqli_num_rows($product_results);
}

$productNameErr= "";
$productPriceErr="";
$quantityErr="";
$volumeSizeErr= "";
$setUpPriceErr="";
$imageLinkErr="";
$valid= true;
if ($_SERVER["REQUEST_METHOD"] == "POST"&& isset($_POST['submit'])) {
    if (empty($_POST["product_id"])) {
        $productErr = "Product is required";
        $valid=false;
    }
    if (empty($_POST["db_productPrice"])) {
        $priceErr = "Product Price is required";
        $valid=false;
    }
    if($valid)
    {
        if (!is_numeric($_POST["db_productPrice"])) {
            $priceErr = "Product Price must be numeric than 0";
            $valid=false;
        }
        else if ($_POST["db_productPrice"]<=0) {
            $priceErr = "Product Price must be greater than 0";
            $valid=false;
        }
    }
    #Problem is with this if statement
    if($valid!=false)
    {
        $db_productID =$_POST['product_id'];
        $db_productPrice=$_POST['db_productPrice'];
        $query = "UPDATE products SET db_productPrice = '$db_productPrice' WHERE db_productID = '$db_productID'";
        $edit_product = $db->query($query);
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
    <h2>Add New Products:</h2>
    <form class="dd" action="" method="post" >

    <table class="dd">
    <tr>
        <td><label for ="members">Name:</label></td>
        <td><input type="text" name="db_productName" id="db_productName" size = 20><span class='error'> <?php echo $productNameErr ?> <span></td>
    </tr>
    <tr>
        <td><label for ="members">Price:</label></td>
        <td><input type="text" name="db_productPrice" id="db_productPrice" size = 20><span class='error'> <?php echo $productPriceErr ?> <span></td>
    </tr>
    <tr>
        <td><label for ="members">Set-Up Price:</label></td>
        <td><input type="text" name="db_setUpPrice" id="db_setUpPrice" size = 20><span class='error'> <?php echo $setUpPriceErr ?> <span></td>
    </tr>
    <tr>
        <td><label for ="members">Quantity:</label></td>
        <td><input type="text" name="db_quantity" id="db_quantity" size = 20><span class='error'> <?php echo $quantityErr ?> <span></td>
    </tr>
    <tr>
        <td><label for ="members">Volume Size:</label></td>
        <td><input type="text" name="db_volumeSize" id="db_volumeSize" size = 20><span class='error'> <?php echo $volumeSizeErr ?> <span></td>
    </tr>
    <tr>
        <td><label for ="members">Image Link:</label></td>
        <td><input type="text" name="db_imageLink" id="db_imageLink" size = 20><span class='error'> <?php echo $imageLinkErr ?> <span></td>
    </tr>
    <tr>
      <td></td>
      <td><input class="btn btn-success" type="submit" value="Submit" name ="submit"><input style="margin-left: 4px;"class="btn btn-danger" type="reset" value="Reset"></td>
    </tr>
    </table>

    </form>
  </div>

</div>
