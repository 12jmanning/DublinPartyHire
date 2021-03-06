<?php
include('inc/detail.php');
include('inc/navbar.php');

// delivery pick / up schedule by date
// order check - JACK
// rental frequency DONE
// sales revenue DONE
// top grossing rentals
// top customers
// three other reports

// working hours - JACK



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
		                   echo "<td>".$row[Revenue]."</td>";
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