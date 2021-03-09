<?php
session_start();
include('inc/detail.php');

// delivery pick / up schedule by date
// order check - JACK
// rental frequency DONE
// sales revenue DONE
// top grossing rentals
// top customers DONE
// three other reports

// working hours - JACK

$requestedDateErr = $startDateErr = $endDateErr = "";
$db_deliveryDatetime = $db_collectionDatetime = "";
$grand=true;
$todayDate = date("Y/m/d");
$yes = 'yes';
$startDate = $endDate = "";



if ($_SERVER["REQUEST_METHOD"] == "POST"&& isset($_POST['update'])) {
  if (empty($_POST['requested_date'])) {
    $requestedDateErr = "Date is required";
    $grand=false;
  }

  if($grand = true)
  {
    $requested_date = $_POST['requested_date'];
  }
}



?>



<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dublin Party Hire Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Charts.js/2.7.2/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/Chart.min.js"></script>
<script type="text/javascript" src="js/app.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/group_6/">
                <div class="sidebar-brand-icon">
                  <img src="img/logo.png" width="55" height="55" alt="" style="margin-top: auto; margin-bottom: auto;">
                </div>
                <div class="sidebar-brand-text mx-3">Dublin Party Hire</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="admindashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                ADMIN TASKS
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-shopping-basket"></i>
                    <span>Products</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Manage Products:</h6>
                        <a class="collapse-item" href="alter_products.php">Manage Prices/Quantities</a>
                        <a class="collapse-item" href="add_new_products.php">Add Products</a>
                        <a class="collapse-item" href="special_offers.php">Manage Special Offers</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-user-friends"></i>
                    <span>Employees</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Manage Employees:</h6>
                        <a class="collapse-item" href="verify_delete_employees.php">Verify Employees</a>
                        <a class="collapse-item" href="employee_hours.php">View Timesheets</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                EXTRAS
            </div>

            <!-- Nav Item - Pages Collapse Menu -->

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="reports.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Reports</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="breakages.php">
                    <i class="fas fa-fw fa-unlink"></i>
                    <span>Manage Breakages</span></a>
            </li>
            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="alter_rates.php">
                    <i class="fas fa-fw fa-truck"></i>
                    <span>Manage VAT & Delivery</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow" style="background: #cfebff;">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw" style="color: #fff;"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>


                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-white-600 small" style="color: white;font-size: larger;"> <?php echo $employee_name ?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="log-out.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

                    </div>
                    <!-- Content Row -->



                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-6 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Delivery Pickup/Schedule:</h6>
                                </div>
                                  <div class="card-body">

                                    <form method="post" action = ""  name="order_form" id="order_form" style="text-align: -webkit-center;">
                                          <tr>
                                            <td><label for="requested_date" style="padding-right: 20px; margin-bottom:20px;">Date:</label></td>
                                            <td ><input type="date" name="requested_date" id="requested_date" style="width: 150px;"><?php echo $requestedDateErr ?> <span></td>
                                            <td><input class="btn" type="submit" value="Select Date" name="update" style="background-color: #C46BAE; color: #fff; margin:auto; margin-left: 20px; margin-bottom:15px;"></td>
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



                                </div>
                            </div>


                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Sales Revenue by Product:</h6>
                                </div>
                                  <div class="card-body">

                                    <table id="table">
                                        <tr>
                                            <th class="auto-style1"><strong>Product Name</strong></th>
                                            <th class="auto-style1"><strong>Revenue</strong></th>
                                        </tr>
                                        <?php
                                        include('inc/detail.php');
                                        $sql = "SELECT db_productName AS 'Product', db_productPrice * sum(db_quantityOrdered) AS 'Revenue'
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



                                </div>
                            </div>



                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Most Ordered Products by Quantity:</h6>
                                </div>
                                  <div class="card-body">


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



                                </div>
                            </div>

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Breakages</h6>
                                </div>
                                  <div class="card-body">
                                  <table id="table">
                                    	<tr>
                                    		<th class="auto-style1"><strong>Breakage ID</strong></th>
                                    		<th class="auto-style1"><strong>Customer ID</strong></th>
                                            <th class="auto-style1"><strong>Customer Name</strong></th>
                                            <th class="auto-style1"><strong>Order ID</strong></th>
                                    		<th class="auto-style1"><strong>Collection Date</strong></th>
                                            <th class="auto-style1"><strong>Product Name</strong></th>
                                            <th class="auto-style1"><strong>Quantity</strong></th>
                                    	</tr>
                                    	<?php
                                    	include('inc/detail.php');
                                    	$sql = "Select breakages.db_breakageID AS 'Breakage ID', breakages.db_customerID AS 'Customer ID', customers.db_customerName AS 'Customer Name', breakages.db_orderID AS 'Order ID', cast(orders.db_collectionDatetime as date) AS 'Date', products.db_productName AS 'Product Name', breakages.db_quantity AS 'Quantity'
                                        From breakages, customers, products, orders
                                        Where breakages.db_customerID = customers.db_customerID AND breakages.db_productID = products.db_productID AND breakages.db_orderID = orders.db_orderID";
                                    		$result = $db->query($sql);

                                    		$num_results = mysqli_num_rows($result);
                                    		for($i=0; $i < $num_results; $i++)
                                    		{
                                    			$row = mysqli_fetch_assoc($result);
                                    			echo "<tr>";
                                    		                   echo "<td>".$row['Breakage ID']."</td>";
                                    		                   echo "<td>".$row['Customer ID']."</td>";
                                                               echo "<td>".$row['Customer Name']."</td>";
                                                               echo "<td>".$row['Order ID']."</td>";
                                    		                   echo "<td>".$row['Date']."</td>";
                                                               echo "<td>".$row['Product Name']."</td>";
                                                               echo "<td>".$row['Quantity']."</td>";
                                    		                   echo "</tr>";
                                    		}
                                    		mysqli_close($db);
                                    ?>

                                    </table>


                                </div>
                            </div>

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Revenue By County:</h6>
                                </div>
                                  <div class="card-body">
                                  <?php
                                  include('inc/detail.php');
                                   $queryX = "SELECT customers.db_county AS 'County', (sum(orders.db_rentalPrice)+sum(orders.db_setUpPrice)+sum(db_deliveryPrice)) AS 'Revenue'
                                   FROM customers,orders 
                                   WHERE orders.db_customerID = customers.db_customerID
                                   GROUP BY customers.db_county
                                   ORDER BY (sum(orders.db_rentalPrice)+sum(orders.db_setUpPrice)+sum(db_deliveryPrice)) DESC";
                                   $resultX = $db->query($queryX);
                                   $num_resultsX = mysqli_num_rows($resultX);
                                  ?>
                                  <table id="table">
                                	<tr>
                                		<th class="auto-style1"><strong>County</strong></th>
                                		<th class="auto-style1"><strong>Revenue per County</strong></th>
                                	</tr>
                                	<?php
                                    for($i=0; $i < $num_resultsX; $i++)
                                    {
                                        $rowX = mysqli_fetch_assoc($resultX);
                                        $Y = round($rowX['Revenue'],2);
                                        echo "<tr>";
                                        echo "<td>".$rowX['County']."</td>";
                                        echo "<td> €".$Y."</td>";
                                        echo "</tr>";
                                    }
                                    mysqli_close($db);
                                     ?>

                                </table>
                                </div>
                            </div>


                        </div>

                        <div class="col-lg-6 mb-4">
                          <div class="card shadow mb-4">
                              <div class="card-header py-3">
                                  <h6 class="m-0 font-weight-bold text-primary">Rental Frequency:</h6>
                              </div>
                              <div class="card-body">

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
                            </div>
                          </div>

                          <div class="card shadow mb-4">
                              <div class="card-header py-3">
                                  <h6 class="m-0 font-weight-bold text-primary">Best Customers:</h6>
                              </div>
                              <div class="card-body">


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
                                		                   echo "<td> €".round($row['Total Spent'])."</td>";
                                		                   echo "</tr>";
                                		}
                                		mysqli_close($db);
                                ?>

                                </table>
                            </div>
                          </div>


                          <div class="card shadow mb-4">
                              <div class="card-header py-3">
                                  <h6 class="m-0 font-weight-bold text-primary">Location of Customers:</h6>
                              </div>
                              <div class="card-body">


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
                            </div>
                          </div>

                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Dublin Party Hire 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="/group_6/">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>
