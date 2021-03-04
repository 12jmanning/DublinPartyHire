<?php
include('inc/detail.php');
include('inc/navbar.php');

// delivery pick / up schedule by date
// order check - JACK
// rental frequency
// sales revenue
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

	include("detail.php");
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