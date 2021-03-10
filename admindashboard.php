<?php
session_start();
include('inc/detail.php');

$db_employeeErr=$db_vanErr="";
$valid=true;

$now_today_date = date("Y-m-d H:i:s");
$start_today_date = date("Y-m-d");
$start_today_date = $start_today_date.''."T00:00:00.00";
$no_time = "0000-00-00T00:00:00.00";
$employee_title ="employee";

$employee_ID = $_SESSION['db_employeeID'];
$employee_name = $_SESSION['db_employeeName'];
$job_title = $_SESSION['db_jobTitle'];
$employee="employee";
$admin = "admin";
$yes = "Yes";
$transit_ID = $_SESSION['transit_ID'];

if($job_title!=$admin)
{
  header('location: employeedashboard.php');
}


$van_query = "SELECT * FROM vans";
$van_results = $db->query($van_query);
$num_van_results = mysqli_num_rows($van_results);

$employee_query = "SELECT employees.db_employeeID, employees.db_employeeName FROM employees, employee_timesheets WHERE employees.db_employeeID=employee_timesheets.db_employeeID AND employees.db_jobTitle='$employee_title' AND (employee_timesheets.db_StartDatetime BETWEEN '$start_today_date' AND '$now_today_date') AND employee_timesheets.db_endDatetime = '0'";
$employee_results = $db->query($employee_query);
$num_employee_results = mysqli_num_rows($employee_results);


$today_date = date("Y-m-d");
$admin_ID = $_SESSION['db_employeeID'];
$employee_name = $_SESSION['db_employeeName'];
$job_title = $_SESSION['db_jobTitle'];
$yes = "Yes";

$query1 = "select orders.db_orderID, transit.db_transitType, transit.db_transitID from orders,transit where orders.db_orderID = transit.db_orderID AND db_deliveryPreference = '$yes' AND ((orders.db_deliveryDatetime= '$today_date' AND orders.db_deliveryID = transit.db_transitID ) OR (orders.db_collectionDatetime= '$today_date' AND orders.db_collectionID = transit.db_transitID))";
$orders_today = $db->query($query1);
$num_results = mysqli_num_rows($orders_today);
$select="select";
$valid=true;
$db_employeeErr= $db_vanErr = $db_transitErr="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["employee_id"])||empty($_POST["van_id"])||empty($_POST['transit_id'])) {
        $db_employeeErr = "Both fields are required";
        $db_vanErr = "Both fields are required";
        $valid=false;
    }
    if ($_POST["employee_id"]==$select) {
        $db_employeeErr = "Employee is required";
        $valid=false;
    }
    if ($_POST["van_id"]==$select) {
        $db_vanErr = "Van is required";
        $valid=false;
    }
    if ($_POST["transit_id"]==$select) {
        $db_transitErr = "transit is required";
        $valid=false;
    }
    if($valid==true ){
        $employee_id = $_POST["employee_id"];
        $van_id = $_POST["van_id"];
        $transit_ID= $_POST['transit_id'];
        $insert_query = "INSERT INTO employee_work_records (";
        $insert_query .= "db_transitID, db_employeeID, db_vanID";
        $insert_query .= ") VALUES (";
        $insert_query .= "'$transit_ID','$employee_id','$van_id')";
        $result_insert = $db->query($insert_query);

        // echo '<table border="2">';
        // echo '<tr class="first-row-database">';
        //     echo "<td></td>";
        //     echo "<td><strong>Transit ID</strong></td>";
        //     echo "<td><strong>Employee ID</strong></td>";
        //     echo "<td><strong>Van ID</strong></td>";
        // echo "</tr>";
        // echo "<tr>";
        //     echo "<td></td>";
        //     echo "<td> $transit_ID </td>";
        //     echo "<td> $employee_id </td>";
        //     echo "<td> $van_id </td>";
        // echo "</tr>";


    }
}

// FOR EARNINGS CALCULATIONS


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
    <script type="text/javascript" src="vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="vendor/chart.js/Chart.min.js"></script>


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
                        <a href="reports.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Earnings (Total)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"> € <?php $earnings_query = "SELECT SUM(db_rentalPrice) FROM `orders`;";

                                            $earnings_results = $db->query($earnings_query);
                                            $row = mysqli_fetch_row($earnings_results);
                                            $x = $row[0];
                                            $x= round($x,2);
                                            echo "$x" ; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Earnings (Weekly)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"> € <?php
                                            $last_week = date("Y-m-d H:i:s", strtotime("-1 week"));
                                            $earnings_query = "SELECT SUM(db_rentalPrice) FROM `orders` WHERE db_orderCreatedAt >= '$last_week';";
                                            $earnings_weekly_results = $db->query($earnings_query);
                                            $row1 = mysqli_fetch_row($earnings_weekly_results);
                                            echo round($row1[0],2) ; ?> </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                      <div class="col mr-2">
                                          <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                              Transits Scheduled Today</div>
                                          <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php
                                          $orders_today_query = "select orders.db_orderID, transit.db_transitType, transit.db_transitID from orders,transit where orders.db_orderID = transit.db_orderID AND db_deliveryPreference = '$yes' AND ((orders.db_deliveryDatetime= '$today_date' AND orders.db_deliveryID = transit.db_transitID ) OR (orders.db_collectionDatetime= '$today_date' AND orders.db_collectionID = transit.db_transitID))";
                                          $orders_today_details = $db->query($orders_today_query);
                                          $num_orders_today = mysqli_num_rows($orders_today_details);

                                          echo "$num_orders_today" ; ?> </div>
                                      </div>
                                      <div class="col-auto">
                                          <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Employees Clocked In</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo "$num_employee_results"; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                          <div class="card shadow mb-4">
                              <div class="card-header py-3">
                                  <h6 class="m-0 font-weight-bold text-primary">Transits Today:</h6>
                              </div>
                              <div class="card-body">
                                <?php

                                  include('inc/detail.php');
                                  $yes = "yes";
                                  $today_date = date("Y-m-d");

                                  $my_transits_query = "select orders.db_orderID, transit.db_transitID, transit.db_transitType, customers.db_customerName, customers.db_customerAddress, customers.db_county, customers.db_customerEircode, customers.db_customerPhone, employees.db_employeeName, employee_work_records.db_vanID from orders,transit,customers, employee_work_records, employees where orders.db_customerID = customers.db_customerID AND orders.db_orderID = transit.db_orderID AND transit.db_transitID = employee_work_records.db_transitID AND employees.db_employeeID = employee_work_records.db_employeeID AND db_deliveryPreference = 'yes' AND ((orders.db_deliveryDatetime= '$today_date' AND orders.db_deliveryID = transit.db_transitID ) OR (orders.db_collectionDatetime= '$today_date' AND orders.db_collectionID = transit.db_transitID))";
                                  $transit_details = $db->query($my_transits_query);
                                  $num_transits_today = mysqli_num_rows($transit_details);

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
                                    echo "<td>Employee Name</td>";
                                    echo "<td>Van</td>";
                                    echo "</tr>";
                                  while($row_orders = mysqli_fetch_row($transit_details))
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
                                    echo "<td>$row_orders[8]</td>";
                                    echo "<td>$row_orders[9]</td>";
                                    echo "</tr>";
                                  }
                                    echo '</table>';
                                ?>



                              </div>
                          </div>

                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Order Status</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                  <?php include('admin_order_status.php'); ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-6 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Assign Employees and Vans to Transit Orders:</h6>
                                </div>
                                <div class="card-body">
                                  <form class="dd" action="" method="post" >

                                  <table class="dd">

                                  <tr>
                                    <td><label for="order_id">Order ID:</label></td>
                                    <td style="width: 399px; height: 38px;" class="auto-style2">
                                    <select name="transit_id" style="width: 300px" class="auto-style1" required>
                                    <option value= "select">--Select an Order--</option>
                                    <?php
                                      for($i = 0;$i<$num_results;$i++)
                                      {
                                        //Move query up top and iterate through results here with an if statement
                                        $row = mysqli_fetch_assoc($orders_today);
                                        echo '<option value = "'.$row['db_transitID'].'"> Order ID: '.$row['db_orderID']." Type: ".$row['db_transitType'].' </option>';

                                      }
                                    ?><span class='error'> <?php echo $db_transitErr ?> <span>
                                  </tr>
                                  <tr>
                                    <td><label for="order_id">Van ID:</label></td>
                                    <td style="width: 399px; height: 38px;" class="auto-style2">
                                    <select name="van_id" style="width: 300px" class="auto-style1" required>
                                    <option value= "select">--Select a Van--</option>
                                    <?php
                                      for($i = 0;$i<$num_van_results;$i++)
                                      {
                                        //Move query up top and iterate through results here with an if statement
                                        $row_van = mysqli_fetch_assoc($van_results);
                                        echo '<option value = "'.$row_van['db_vanID'].'"> Van ID: '.$row_van['db_vanID']." Van Name: ".$row_van['db_vanName'].' </option>';

                                      }
                                    ?>
                                    <span class='error'> <?php echo $db_vanErr ?> <span></td>
                                  </tr>
                                  <tr>
                                    <td><label for="order_id">Employee ID:</label></td>
                                    <td style="width: 399px; height: 38px;" class="auto-style2">
                                    <select name="employee_id" style="width: 300px" class="auto-style1" required>
                                    <option value= "select">--Select an Employee--</option>
                                    <?php
                                      for($i = 0;$i<$num_employee_results;$i++)
                                      {
                                        //Move query up top and iterate through results here with an if statement
                                        $row_employee = mysqli_fetch_assoc($employee_results);
                                        echo '<option value = "'.$row_employee['db_employeeID'].'"> Employee ID: '.$row_employee['db_employeeID']." Name: ".$row_employee['db_employeeName'].' </option>';

                                      }
                                    ?>
                                    <span class='error'> <?php echo $db_employeeErr ?> <span></td>
                                  </tr>

                                  <tr>
                                    <td></td>
                                    <td><input class="btn btn-success" type="submit" name = "submit" value="Submit"><input style="margin-left: 4px;"class="btn btn-danger" type="reset" value="Reset"></td>
                                  </tr>
                                  </table>
                                  <span class='error'> <?php echo $db_vanErr ?> <span></td>

                                  </form>



                                </div>
                            </div>

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Your Details:</h6>
                                </div>
                                <div class="card-body">
                                  <?php
                                  echo "Employee ID: ", $admin_ID, "<br>";
                                  echo "Name: ", $employee_name, "<br>";
                                  echo "Job Title: ", $job_title, "<br>";
                                  ?>



                                </div>
                            </div>

                            

                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Customers Collecting Orders Today</h6>
                                    <?php 
                                    include('inc/detail.php');
                                    $query_new = "SELECT orders.db_orderID,customers.db_customerName,orders.db_rentalPrice,orders.db_setUpPrice ,customers.db_customerPhone FROM orders,customers WHERE orders.db_customerID=customers.db_customerID AND orders.db_deliveryPreference = 'No' AND orders.db_deliveryDatetime='$today_date'";
                                    $result_new = $db->query($query_new);
                                    $num_new_results = mysqli_num_rows($result_new);


                                    echo '<table border="2" style="width: -webkit-fill-available;">';
                                  	echo '<tr class="first-row-database">';
                                  		echo "<td>Order ID</td>";
                                  		echo "<td>Customer Name</td>";
                                  		echo "<td>Rental Price</td>";
                                          echo "<td>Set Up price</td>";
                                          echo "<td>Phone Number</td>";
                                        echo "</tr>";

                                        while($row_ordersZ = mysqli_fetch_row($result_new))
                                        {
                                            echo "<tr>";
                                            echo "<td>$row_ordersZ[0]</td>";
                                            echo "<td>$row_ordersZ[1]</td>";
                                            echo "<td>€$row_ordersZ[2]</td>";
                                            echo "<td>€$row_ordersZ[3]</td>";
                                            echo "<td>$row_ordersZ[4]</td>";
                                            echo "</tr>";
                                        }
                                            echo '</table>';
                                          
                                    ?>
                                    

                                    
                                        
                                </div>
                            </div>

                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Customers Returning Orders Today</h6>
                                    <?php 
                                    include('inc/detail.php');
                                    $query_new1 = "SELECT orders.db_orderID,customers.db_customerName,orders.db_rentalPrice,orders.db_setUpPrice FROM orders,customers, customers.db_customerPhone WHERE orders.db_customerID=customers.db_customerID AND orders.db_deliveryPreference = 'No' AND orders.db_collectionDatetime='$today_date'";
                                    $result_new1 = $db->query($query_new1);
                                    $num_new_results1 = mysqli_num_rows($result_new1);


                                    echo '<table border="2" style="width: -webkit-fill-available;">';
                                  	echo '<tr class="first-row-database">';
                                  		echo "<td>Order ID</td>";
                                  		echo "<td>Customer Name</td>";
                                  		echo "<td>Rental Price</td>";
                                          echo "<td>Set Up price</td>";
                                          echo "<td>Phone Number</td>";
                                        echo "</tr>";

                                        while($row_ordersZ1 = mysqli_fetch_row($result_new1))
                                        {
                                            echo "<tr>";
                                            echo "<td>$row_ordersZ1[0]</td>";
                                            echo "<td>$row_ordersZ1[1]</td>";
                                            echo "<td>€$row_ordersZ1[2]</td>";
                                            echo "<td>€$row_ordersZ1[3]</td>";
                                            echo "<td>$row_ordersZ1[4]</td>";
                                            echo "</tr>";
                                        }
                                            echo '</table>';
                                          
                                    ?>
                                    

                                    
                                        
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6 mb-4">
                          <div class="row">
                              <div class="col-lg-6 mb-4">
                                  <a class="btn card bg-primary text-white shadow" href="alter_products.php">
                                      <div class="card-body">
                                          Alter or Delete Products 
                                          <div class="text-white-50 small">Edit</div>
                                      </div>
                                  </a>
                              </div>
                              <div class="col-lg-6 mb-4">
                                  <a class="btn card bg-primary text-white shadow" href="add_new_products.php">
                                      <div class="card-body">
                                          Manage Products
                                          <div class="text-white-50 small">Edit</div>
                                      </div>
                                  </a>
                              </div>
                              <div class="col-lg-6 mb-4">
                                  <a class="btn card bg-primary text-white shadow" href="verify_delete_employees.php">
                                      <div class="card-body">
                                          Manage Employees
                                          <div class="text-white-50 small">Edit</div>
                                      </div>
                                  </a>
                              </div>
                              <div class="col-lg-6 mb-4">
                                  <a class="btn card bg-primary text-white shadow" href="alter_rates.php">
                                      <div class="card-body">
                                          Manage VAT & Delivery
                                          <div class="text-white-50 small">Edit</div>
                                      </div>
                                  </a>
                              </div>
                              <div class="col-lg-6 mb-4">
                                  <a class="btn card bg-primary text-white shadow" href="reports.php">
                                      <div class="card-body">
                                          Access Reports
                                          <div class="text-white-50 small">View</div>
                                      </div>
                                  </a>
                              </div>
                              <div class="col-lg-6 mb-4">
                                  <a class="btn card bg-primary text-white shadow" href="breakages.php">
                                      <div class="card-body">
                                          Manage Breakages
                                          <div class="text-white-50 small">Edit</div>
                                      </div>
                                  </a>
                              </div>
                              <div class="col-lg-6 mb-4">
                                  <a class="btn card bg-primary text-white shadow" href="employee_hours.php">
                                      <div class="card-body">
                                          View Employee Timesheets
                                          <div class="text-white-50 small">Edit</div>
                                      </div>
                                  </a>
                              </div>
                              <div class="col-lg-6 mb-4">
                                  <a class="btn card bg-primary text-white shadow" href="special_offers.php">
                                      <div class="card-body">
                                          Manage Special Offers
                                          <div class="text-white-50 small">Edit</div>
                                      </div>
                                  </a>
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
                    <a class="btn btn-primary" href="log-out.php">Logout</a>
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
