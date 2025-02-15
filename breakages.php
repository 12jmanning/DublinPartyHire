<?php
//This script helps admins record products which have been collected by DPH staff or dropped back by customers which have been damaged. It gives an option to select an order from the past (removing any future orders). Using javascript, it automatically reloads the particular products from that order. The admin can then select the quantity from that order which is broken. The admin cannot enter a quantity which is greater than the quantity ordered by the customer. These are all then displayed in the breakage details table. It records a breakage in the breakages table in the database.  

session_start();
include('inc/detail.php');

$now_today_date = date("Y-m-d H:i:s");
$start_today_date = date("Y-m-d");
$start_today_date = $start_today_date.''."T00:00:00.00";
$no_time = "0000-00-00T00:00:00.00";
$employee_title ="employee";
$employee_query = "SELECT employees.db_employeeID, employees.db_employeeName FROM employees, employee_timesheets WHERE employees.db_employeeID=employee_timesheets.db_employeeID AND employees.db_jobTitle='$employee_title' AND (employee_timesheets.db_StartDatetime BETWEEN '$start_today_date' AND '$now_today_date') AND employee_timesheets.db_endDatetime = '0'";

$employee_results1 = $db->query($employee_query);
$num_employee_results1 = mysqli_num_rows($employee_results1);

$employee_ID = $_SESSION['db_employeeID'];
$employee_name = $_SESSION['db_employeeName'];
$job_title = "Not Yet Verified";
$today = date("Y/m/d");


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
  var val=form.db_orderID.options[form.db_orderID.options.selectedIndex].value;
  var val2=form.db_productID.options[form.db_productID.options.selectedIndex].value;

  self.location='breakages.php?db_orderID=' + val + '&db_productID=' + val2 ;
}

</script>

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
                                <span class="badge badge-danger badge-counter"><?php echo $num_employee_results1 ?></span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <?php
                                for($i = 0;$i<$num_employee_results1;$i++)
                                {
                                //Move query up top and iterate through results here with an if statement
                                $row_employee1 = mysqli_fetch_assoc($employee_results1);

                                echo '<a class="dropdown-item d-flex align-items-center" href="#">';
                                echo '<div class="mr-3">';
                                echo '<div class="icon-circle bg-primary">';
                                echo '<i class="fas fa-file-alt text-white"></i>';
                                echo '</div>';
                                echo '</div>';
                                echo '<div>';
                                echo '<div class="small text-gray-500">Employee ID:'.$row_employee1["db_employeeID"].' </div>';
                                echo '<span class="font-weight-bold">Employee Name: '.$row_employee1["db_employeeName"].'</span>';
                                echo '</div>';
                                echo '</a>';

                                }
                                ?>
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
                                    <h6 class="m-0 font-weight-bold text-primary">Record a Breakage in an Order:</h6>
                                </div>
                                  <div class="card-body">


                                    <?php
                                    $quer2="SELECT db_orderID FROM orders WHERE db_collectionDatetime<='$today'";

                                    $db_orderID=$_GET['db_orderID']; 
                                    if(isset($db_orderID) and strlen($db_orderID) > 0){
                                    $quer="SELECT product_orders.db_productID, products.db_productName, product_orders.db_productOrderID, product_orders.db_quantityOrdered FROM product_orders,products where product_orders.db_orderID = '$db_orderID' AND product_orders.db_productID = products.db_productID";
                                    }else{$quer="SELECT * FROM product_orders"; }

                                    $db_productID=$_GET['db_productID']; 
                                    if(isset($db_productID) and strlen($db_productID) > 0){
                                    $quer3="SELECT product_orders.db_quantityOrdered FROM product_orders,products where product_orders.db_orderID = '$db_orderID' AND product_orders.db_productID = '$db_productID'";
                                    }else{$quer3="SELECT * FROM products"; }

                                    $orderErr="";
                                    $productErr = "";
                                    $quantityErr = "";
                                    $valid=true;
                                    if ($_SERVER["REQUEST_METHOD"] == "POST"&& isset($_POST['submit'])) {
                                      if (empty($_POST["db_orderID"])) {
                                          $orderErr = "Order is required";
                                          $valid=false;
                                      }
                                      if (empty($_POST["db_productID"])) {
                                          $productErr = "Product Name is required";
                                          $valid=false;
                                      }
                                      if (empty($_POST["db_quantityOrdered"])) {
                                        $quantityErr = "Quantity is required";
                                        $valid=false;
                                    }


                                      if($valid!=false)
                                      {
                                          $db_orderID =$_POST['db_orderID'];
                                          $db_productID=$_POST['db_productID'];
                                          $db_quantity=$_POST['db_quantityOrdered'];
                                          $query1 = "SELECT db_customerID FROM orders WHERE db_orderID ='$db_orderID'";
                                          $customer_query = $db->query($query1);
                                          $row = mysqli_fetch_assoc($customer_query);
                                          $db_customerID = $row['db_customerID'];

                                          $query2 = "INSERT INTO breakages (db_customerID, db_orderID, db_productID, db_quantity) VALUES ('$db_customerID','$db_orderID','$db_productID','$db_quantity')";
                                          $add_breakages = $db->query($query2);

                                          $query3 = "SELECT db_quantity FROM products WHERE db_productID ='$db_productID'";
                                          $get_product = $db->query($query3);
                                          $row1 = mysqli_fetch_assoc($get_product);
                                          $db_quantityProduct = $row1['db_quantity'];
                                          $db_quantityProduct =$db_quantityProduct-$db_quantity;

                                          $query4 = "UPDATE products SET db_quantity = '$db_quantityProduct' WHERE db_productID = '$db_productID'";
                                          $reduce = $db->query($query4);
                                          header('Location: admindashboard.php');

                                          $success_message = "You have successfully recorded the breakage";
                                      }

                                    }


                                    echo "<form method=post name=f1 action=''>";
                            
                                    echo "<label style='margin-right: 20px;'>Select an Order:</label>";
                                    echo "<select name='db_orderID' onchange=\"reload(this.form)\"><option value=''>Select one</option>";
                                    foreach ($db->query($quer2) as $noticia2) {
                                    if($noticia2['db_orderID']==@$db_orderID){echo "<option selected value='$noticia2[db_orderID]'>$noticia2[db_orderID]</option>";}
                                    else{echo  "<option value='$noticia2[db_orderID]'>$noticia2[db_orderID]</option>";}
                                    }
                                    echo "</select> <span class='error'>$orderErr<span>";
                                    echo "<br>";

                                    echo "<label style='margin-right: 20px;'>Select an Item from The Order:</label>";
                                    echo "<select name='db_productID' onchange=\"reload3(this.form)\"><option value=''>Select one</option>";
                                    foreach ($db->query($quer) as $noticia) {
                                    if($noticia['db_productID']==@$db_productID){echo "<option selected value='$noticia[db_productID]'>$noticia[db_productName]</option>";}
                                    else{echo  "<option value='$noticia[db_productID]'>$noticia[db_productName]</option>";}
                                    }
                                    echo "</select>";
                                    echo "<br>";

                                    echo "<label style='margin-right: 20px;'>Select The Quantity Broken:</label>";
                                    foreach ($db->query($quer3) as $noticia) {
                                      $max_q = $noticia['db_quantityOrdered'];
                                    }
                                    echo  "<input type='number' name='db_quantityOrdered' value='1' min='1' max='$max_q' placeholder='Quantity Ordered' required>";

                                    echo "<br><input class='btn btn-success' style='margin-top:20px; margin-bottom:20px' type=submit name = 'submit' value='Submit the form data'></form>";
                                    echo "<br>" , "$success_message";


                                    ?>




                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">
                          <div class="card shadow mb-4">
                              <div class="card-header py-3">
                                  <h6 class="m-0 font-weight-bold text-primary">Breakage Details:</h6>
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
