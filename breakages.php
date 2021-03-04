<!DOCTYPE html>
<html lang="en">
<head>
  <title>Demo of Three Multiple drop down list box from plus2net</title>
  <meta name="GENERATOR" content="Arachnophilia 4.0">
  <meta name="FORMATTER" content="Arachnophilia 4.0">
  <SCRIPT language=JavaScript>
  function reload(form)
  {
    var val=form.db_orderID.options[form.db_orderID.options.selectedIndex].value; 
    self.location='breakages.php?db_orderID=' + val ;
  }
  function reload3(form)
  {
    var val=form.cat.options[form.cat.options.selectedIndex].value; 
    var val2=form.subcat.options[form.subcat.options.selectedIndex].value; 

    self.location='dd3.php?cat=' + val + '&cat3=' + val2 ;
  }

  </script>
</head>
<body>
  
</body>
</html>
<?php
session_start();
include('inc/detail.php');
include('inc/navbar.php');

$employee_ID = $_SESSION['db_employeeID'];
$employee_name = $_SESSION['db_employeeName'];
$job_title = "Not Yet Verified";
$today = date("Y/m/d");



///////// Getting the data from Mysql table for first list box//////////
$quer2="SELECT db_orderID FROM orders WHERE db_collectionDatetime<='$today'"; 
///////////// End of query for first list box////////////

/////// for second drop down list we will check if category is selected else we will display all the subcategory///// 
$db_orderID=$_GET['db_orderID']; // This line is added to take care if your global variable is off
if(isset($db_orderID) and strlen($db_orderID) > 0){
$quer="SELECT product_orders.db_productID, products.db_productName, product_orders.db_productOrderID, product_orders.db_quantityOrdered FROM product_orders,products where product_orders.db_orderID = '$db_orderID' AND product_orders.db_productID = products.db_productID"; 
}else{$quer="SELECT * FROM product_orders"; } 
////////// end of query for second subcategory drop down list box ///////////////////////////


/////// for Third drop down list we will check if sub category is selected else we will display all the subcategory3///// 
$db_productID=$_GET['db_productID']; // This line is added to take care if your global variable is off
if(isset($db_productID) and strlen($db_productID) > 0){
$quer3="SELECT product_orders.db_quantityOrdered FROM product_orders,products where product_orders.db_orderID = '$db_orderID' AND product_orders.db_productID = '$db_productID'"; 
}else{$quer3="SELECT * FROM products"; } 
////////// end of query for third subcategory drop down list box ///////////////////////////


echo "<form method=post name=f1 action=''>";
//////////        Starting of first drop downlist /////////
echo "<select name='db_orderID' onchange=\"reload(this.form)\"><option value=''>Select one</option>";
foreach ($db->query($quer2) as $noticia2) {
if($noticia2['db_orderID']==@$db_orderID){echo "<option selected value='$noticia2[db_orderID]'>$noticia2[db_orderID]</option>";}
else{echo  "<option value='$noticia2[db_orderID]'>$noticia2[db_orderID]</option>";}
}
echo "</select>";
//////////////////  This will end the first drop down list ///////////

//////////        Starting of second drop downlist /////////
echo "<select name='db_productID' onchange=\"reload3(this.form)\"><option value=''>Select one</option>";
foreach ($db->query($quer) as $noticia) {
if($noticia['db_productID']==@$db_productID){echo "<option selected value='$noticia[db_productID]'>$noticia[db_productName]</option>";}
else{echo  "<option value='$noticia[db_productID]'>$noticia[db_productName]</option>";}
}
echo "</select>";
//////////////////  This will end the second drop down list ///////////

/*
//////////        Starting of third drop downlist /////////
foreach ($db->query($quer3) as $noticia) {
echo  "<input type='number' name='db_quantityOrdered' value='1' min='1' max='$noticia['db_quantityOrdered']' placeholder='Quantity Ordered' required>";
}
//////////////////  This will end the third drop down list ///////////
*/

echo "<input type=submit value='Submit the form data'></form>";



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
          echo  " x ",$db_orderID;


     ?>
  </div>


  <div class="col-lg-6" >
    <form class="dd" action="" method="post" >

    <table class="dd">

    
    </table>
    <tr>
      <td></td>
      <td><p>Return To Homepage <a href="index.php">HERE</a></p></td>
    </tr>
    <tr>

    </form>
  </div>

</div>