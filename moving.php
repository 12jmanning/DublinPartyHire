<?php
session_start();
include('inc/detail.php');

$employee = "employee";

$employeeID = $_SESSION['db_employeeID'];



    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if(isset($_SESSION['db_employeeID']) && $_SESSION['db_jobTitle'] = $employee ){

          if(isset($_POST['ClockIn'])){

              $employeeID = $_SESSION['db_employeeID'];
              $clock_in_time = date("Y-m-d H:i:s");

              $q  = "INSERT INTO employee_timesheets (";
              $q .= "db_employeeID, db_startDatetime";
              $q .= ") VALUES (";
              $q .= "'$employeeID', '$clock_in_time')";

              $result = $db->query($q);
              $clocked_in_successful = "You have clocked in";
          }

          if(isset($_POST['ClockOut'])){

              $employeeID = $_SESSION['db_employeeID'];
              $clock_out_time = date("Y-m-d H:i:s");

              $query = "SELECT db_timesheetID FROM employee_timesheets WHERE db_employeeID = '$employeeID' ORDER  BY db_startDatetime DESC LIMIT  1";

              $result1 = $db->query($query);
              $row = mysqli_fetch_assoc($result1);
              $timesheetID = $row['db_timesheetID'];

              $query1 = "UPDATE employee_timesheets SET db_endDatetime = '$clock_out_time' WHERE db_timesheetID = '$timesheetID'";
              $result = $db->query($query1);
              echo "You have clocked out";

          }

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
                        <a class="collapse-item" href="alter_products.php">Manage Prices</a>
                        <a class="collapse-item" href="add_new_products.php">Manage Quantities</a>
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
                                    <h6 class="m-0 font-weight-bold text-primary">Clock In/Clock Out:</h6>
                                </div>
                                  <div class="card-body">
                                    <form method="post" action="">

                                            <input class="btn btn-success"type="submit" value = "Clock In" name="ClockIn">
                                            <input class="btn btn-danger"type="submit" name="ClockOut" value="Clock Out">
                                            <?php echo "$clocked_in_successful"; ?>
                                    </form>



                                </div>
                            </div>

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Current Status:</h6>
                                </div>
                                  <div class="card-body">

                                        <?php
                                          $status_query = "SELECT db_timesheetID, db_startDatetime, db_endDatetime FROM employee_timesheets WHERE db_employeeID = '$employeeID' ORDER  BY db_timesheetID DESC LIMIT  1";

                                          $employee_status = $db->query($status_query);
                                          $row1 = mysqli_fetch_assoc($employee_status);
                                          $start_time = $row1['db_startDatetime'];
                                          $end_time = $row1['db_endDatetime'];


                                          if ($end_time == "0000-00-00 00:00:00") {
                                            echo "You are clocked in since : ", $start_time;
                                          }
                                          else if ($end_time !== "0000-00-00 00:00:00") {
                                            echo "You are clocked out";
                                          }
                                         ?>
                                         <?php
                                         $details_query = "SELECT db_employeeID, db_employeeName, db_jobTitle FROM `employees`
                                                                 WHERE db_employeeID = '$employeeID'";
                                         $employee_details = $db->query($details_query);
                                         $row2 = mysqli_fetch_assoc($employee_details);
                                         $employee_id = $row2['db_employeeID'] ;
                                         $employee_name = $row2['db_employeeName'] ;
                                         $employee_job_title = $row2['db_jobTitle'] ;



                                          ?>



                                </div>
                            </div>

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Current Status:</h6>
                                </div>
                                  <div class="card-body">

                                    <?php
                                    $time_query = "SELECT db_timesheetID, db_startDatetime, db_endDatetime
                                                          FROM `employee_timesheets`
                                                          WHERE db_employeeID = '$employeeID'";
                                    $time_details = $db->query($time_query);
                                    echo '<table border="2">';
                                    echo '<tr class="first-row-database">';
                                        echo "<td>Timesheet ID</td>";
                                        echo "<td>Start Time</td>";
                                        echo "<td>End Time</td>";
                                        echo "<td>Hours Worked</td>";
                                      echo "</tr>";
                                    $total_hours_worked = 0;
                                    while($row3 = mysqli_fetch_row($time_details))
                                    {
                                        echo "<tr>";
                                        echo "<td>$row3[0]</td>";
                                        echo "<td>$row3[1]</td>"; $timestamp_start = strtotime($row3[1]);
                                        echo "<td>$row3[2]</td>"; $timestamp_end = strtotime($row3[2]);
                                        echo "<td>", round(abs($timestamp_end - $timestamp_start) / (60*60), 2) ,"</td>";
                                        echo "</tr>";
                                        $total_hours_worked += round(abs($timestamp_end - $timestamp_start) / (60*60), 2);
                                    }
                                    echo "<tr>";
                                    echo "<td> </td>";
                                    echo "<td> </td>";
                                    echo "<td><strong>TOTAL HOURS</strong></td>";
                                    echo "<td>$total_hours_worked </td>";
                                    echo "</tr>";

                                    echo '</table>';

                                    ?>



                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">
                          <div class="card shadow mb-4">
                              <div class="card-header py-3">
                                  <h6 class="m-0 font-weight-bold text-primary">Details:</h6>
                              </div>
                              <div class="card-body">

                                <?php
                                echo "Employee ID: ", $employee_id, "<br>";
                                      echo "Name: ", $employee_name, "<br>";
                                      echo "Job Title: ", $employee_job_title, "<br>";

                                 ?>
                            </div>
                          </div>

                          <div class="card shadow mb-4">
                              <div class="card-header py-3">
                                  <h6 class="m-0 font-weight-bold text-primary">Print Delivery Dockets:</h6>
                              </div>
                              <div class="card-body">

                                <?php
                                $current_time = date("Y-m-d H:i:s");
                                $orders_in_future_query = "SELECT * FROM orders where db_deliveryDatetime >= '$current_time' ORDER BY db_deliveryDatetime ASC";
                                $orders_in_future = $db->query($orders_in_future_query);
                                $num_results = mysqli_num_rows($orders_in_future);

                                 ?>
                                 <form class="" action="print_docket.php" method="post" name="docket" id="docket">

                                 <table class="">

                                 <tr>
                                   <td><label for="order_id" style="width: 100px;">Select an Order ID:</label></td>
                                   <td style="width: 618px; height: 38px;" class="auto-style2">
                                   <select name="order_id" style="width: 399px" class="auto-style1" required>
                                   <option value= "select">--Select an Order--</option>
                                   <?php
                                     for($i = 0;$i<$num_results;$i++)
                                     {
                                       $row = mysqli_fetch_assoc($orders_in_future);
                                       $q = 'select * from orders where '.$row['db_orderID'].'= orders.db_orderID';
                                       $result2 = $db->query($q);
                                       $row2 = mysqli_fetch_assoc($result2);

                                       echo '<<option value ="'.$row['db_orderID'].'">Order ID: '.$row['db_orderID']." On ".$row['db_deliveryDatetime'].'</option>';
                                     }
                                   ?>


                                 </tr>

                                 <tr>
                                   <td></td>
                                   <td><input class="btn btn-success" type="submit" value="Submit"><input style="margin-left: 4px;"class="btn btn-danger" type="reset" value="Reset"></td>
                                 </tr>
                                 </table>

                                 </form>
                            </div>
                          </div>

                          <div class="card shadow mb-4">
                              <div class="card-header py-3">
                                  <h6 class="m-0 font-weight-bold text-primary">My Transits Today:</h6>
                              </div>
                              <div class="card-body">


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
