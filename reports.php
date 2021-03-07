<?php

// delivery pick / up schedule by date
// order check - JACK
// rental frequency DONE
// sales revenue DONE
// top grossing rentals
// top customers DONE
// three other reports

// working hours - JACK

session_start();
include('inc/detail.php');
include('inc/navbar.php');

$requestedDateErr ="";
$db_deliveryDatetime = $db_collectionDatetime = "";
$grand=true;
$todayDate = date("Y/m/d");
$requested_date = $_SESSION['requested_date'];

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
  if (empty($_POST['requested_date'])) {
    $requestedDateErr = "Date is required";
    $grand=false;
  }
  else if (isValidDate($_POST['requested_date'],'Y-m-d')) 
  {
    $requestedDateErr =  "Please Enter Valid Future Dates";
    $grand=false;    
  }  
  if($grand==true)
  {
    $_SESSION['requested_date'] = $_POST['requested_date'];
  }
}

?>

<h2 class="auto-style1">Delivery/Pickup Schedule</h2>

<form method="post" action = ""  name="order_form" id="order_form" style="text-align: -webkit-center;">
      <tr>
        <td><label for="requested_date" style="padding-right: 20px;">Date:</label></td>
        <td ><input type="date" name="requested_date" id="requested_date" style="width: 150px;"><?php echo $requestedDateErr ?> <span></td>
          <td><input class="btn" type="submit" value="Select Date" name="update" style="background-color: #C46BAE; color: #fff; margin:auto; margin-left: 20px;"></td>
      </tr>
</form>

<?php
	include('inc/detail.php');
	$requested_date_orders_query = "select orders.db_orderID, transit.db_transitID, transit.db_transitType, customers.db_customerName, customers.db_customerAddress, customers.db_county, customers.db_customerEircode, customers.db_customerPhone from orders,transit,customers where orders.db_customerID = customers.db_customerID AND orders.db_orderID = transit.db_orderID AND db_deliveryPreference = '$yes' AND ((orders.db_deliveryDatetime= '$requested_date' AND orders.db_deliveryID = transit.db_transitID ) OR (orders.db_collectionDatetime= '$requested_date' AND orders.db_collectionID = transit.db_transitID))";
	$orders_details = $db->query($requested_date_orders_query);
	$num_orders_requested_date = mysqli_num_rows($orders_details);

	echo '<table border="2" style="width: -webkit-fill-available;">';
	echo '<tr class="first-row-database">';
		echo "<td>Order ID</td>";
		echo "<td>Transit ID</td>";
		echo "<td>Type</td>";
		echo "<td>Customer Name</td>";
		echo "<td>Customer Address</td>";
		echo "<td>Customer County</td>";
		echo "<td>Customer Eircode</td>";
		echo "<td>Customer Phone</td>";
		echo "</tr>";
	while($row_orders = mysqli_fetch_row($orders_details))
	{
		echo "<tr>";
		echo "<td>$row_orders[0]</td>";
		echo "<td>$row_orders[1]</td>";
		echo "<td>$row_orders[2]</td>";
		echo "<td>$row_orders[3]</td>";
		echo "<td>$row_orders[4]</td>";
		echo "<td>$row_orders[5]</td>";
		echo "<td>$row_orders[6]</td>";
		echo "<td>$row_orders[7]</td>";
		echo "</tr>";
	}
		echo '</table>';
?>

<h2 class="auto-style1">Rental Frequency</h2>
<p>List of products and the number of times they have been rented.</p>

<table id="table">
	<tr>
		<th class="auto-style1"><strong>Product Name</strong></th>
		<th class="auto-style1"><strong>Rental Frequency</strong></th>
	</tr>
	<?php
	include('inc/detail.php');
	$sql = "SELECT db_productName AS 'Product', count(*) AS 'Count'
	FROM product_orders, products
	WHERE product_orders.db_productID = products.db_productID
	GROUP BY db_productName
	ORDER BY products.db_productID"; 
		$result = $db->query($sql);
	
		$num_results = mysqli_num_rows($result);
		for($i=0; $i < $num_results; $i++)
		{
			$row = mysqli_fetch_assoc($result);
			echo "<tr>";
		                   echo "<td>".$row[Product]."</td>";
		                   echo "<td>".$row[Count]."</td>";
		                   echo "</tr>";
		}
		mysqli_close($db);
?>	

</table>

<h2 class="auto-style1">Sales Revenue by Product</h2>
<p>Breakdown of the revenue earned from each rental product</p>

<table id="table">
	<tr>
		<th class="auto-style1"><strong>Product Name</strong></th>
		<th class="auto-style1"><strong>Revenue</strong></th>
	</tr>
	<?php
	include('inc/detail.php');
	$sql = "SELECT db_productName AS 'Product', db_productPrice * sum(db_quantityOrdered) * count(*) AS 'Revenue'
	FROM product_orders, products
	WHERE product_orders.db_productID = products.db_productID
	GROUP BY db_productName
	ORDER BY products.db_productID"; 
		$result = $db->query($sql);
	
		$num_results = mysqli_num_rows($result);
		for($i=0; $i < $num_results; $i++)
		{
			$row = mysqli_fetch_assoc($result);
			echo "<tr>";
		                   echo "<td>".$row[Product]."</td>";
		                   echo "<td> €".$row[Revenue]."</td>";
		                   echo "</tr>";
		}
		mysqli_close($db);
?>	

</table>

<h2 class="auto-style1">Best Customers</h2>
<p>List of all the customers and how much each has spent on rentals</p>

<table id="table">
	<tr>
		<th class="auto-style1"><strong>Last Name</strong></th>
		<th class="auto-style1"><strong>First Name</strong></th>
		<th class="auto-style1"><strong>Email</strong></th>
		<th class="auto-style1"><strong>Total Spent</strong></th>
	</tr>
	<?php
	include('inc/detail.php');
	$sql = "SELECT substring_index(db_customerName, ' ', -1) AS 'Last Name', substring_index(db_customerName, ' ', 1) AS 'First Name', db_customerEmail AS 'Email', sum(db_rentalPrice) AS 'Total Spent' 
	FROM orders, customers
	WHERE orders.db_customerID = customers.db_customerID
	GROUP BY orders.db_customerID
	ORDER BY sum(db_rentalPrice) DESC"; 

		$result = $db->query($sql);
	
		$num_results = mysqli_num_rows($result);
		for($i=0; $i < $num_results; $i++)
		{
			$row = mysqli_fetch_assoc($result);
			echo "<tr>";
		                   echo "<td>".$row['Last Name']."</td>";
		                   echo "<td>".$row['First Name']."</td>";
						   echo "<td>".$row['Email']."</td>";
		                   echo "<td> €".$row['Total Spent']."</td>";
		                   echo "</tr>";
		}
		mysqli_close($db);
?>	

</table>


<h2 class="auto-style1">Extra Reports</h2>

<h2 class="auto-style1">Most Ordered Products by Quantity</h2>
<p>List of products and the total quantity that has been ordered for each.</p>

<table id="table">
	<tr>
		<th class="auto-style1"><strong>Product Name</strong></th>
		<th class="auto-style1"><strong>Total Quantity</strong></th>
	</tr>
	<?php
	include('inc/detail.php');
	$sql = "SELECT db_productName AS 'Product', sum(db_quantityOrdered) AS 'Quantity'
	FROM product_orders, products
	WHERE product_orders.db_productID = products.db_productID
	GROUP BY db_productName
	ORDER BY sum(db_quantityOrdered) DESC"; 
		$result = $db->query($sql);
	
		$num_results = mysqli_num_rows($result);
		for($i=0; $i < $num_results; $i++)
		{
			$row = mysqli_fetch_assoc($result);
			echo "<tr>";
		                   echo "<td>".$row[Product]."</td>";
		                   echo "<td>".$row[Quantity]."</td>";
		                   echo "</tr>";
		}
		mysqli_close($db);
?>	

</table>

<h2 class="auto-style1">Location of Customers</h2>
<p>Breakdown of customers by location.</p>

<table id="table">
	<tr>
		<th class="auto-style1"><strong>County</strong></th>
		<th class="auto-style1"><strong>Number of Customers</strong></th>
	</tr>
	<?php
	include('inc/detail.php');
	$sql = "SELECT db_county AS 'County', count(*) AS 'Number of Customers'
	FROM customers
	GROUP BY db_county
	ORDER BY count(*) DESC"; 
		$result = $db->query($sql);
	
		$num_results = mysqli_num_rows($result);
		for($i=0; $i < $num_results; $i++)
		{
			$row = mysqli_fetch_assoc($result);
			echo "<tr>";
		                   echo "<td>".$row['County']."</td>";
		                   echo "<td>".$row['Number of Customers']."</td>";
		                   echo "</tr>";
		}
		mysqli_close($db);
?>	

</table>