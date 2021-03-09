<?php
session_start();
include('inc/detail.php');




if($_SESSION['db_jobTitle']=="admin"){
    $no_job="";
    $admin ="admin";
    $employee = "employee";
    $employee_ID = $_SESSION['db_employeeID'];
    $employee_name = $_SESSION['db_employeeName'];
    $job_title = $_SESSION['db_jobTitle'];

    $employee_query = "SELECT * FROM employees WHERE db_jobTitle != '$admin' AND db_jobTitle != '$employee'";
    $employee_results = $db->query($employee_query);
    $num_employee_results = mysqli_num_rows($employee_results);

    $employee_query1 = "SELECT * FROM employees";
    $employee_results1 = $db->query($employee_query1);
    $num_employee_results1 = mysqli_num_rows($employee_results1);

    $employee_query2 = "SELECT * FROM employees WHERE db_jobTitle = '$admin' OR db_jobTitle = '$employee'";
    $employee_results2 = $db->query($employee_query2);
    $num_employee_results2 = mysqli_num_rows($employee_results2);
}

$employeeErr= "";
$priceErr="";
$quantityErr="";
$jobTitleErr="";
$valid= true;
if ($_SERVER["REQUEST_METHOD"] == "POST"&& isset($_POST['submit'])) {
    if (empty($_POST["db_employeeID"])) {
        $employeeErr = "Employee is required";
        $valid=false;
    }
    if (empty($_POST["db_jobTitle"])) {
        $jobTitleErr = "Job Title is required";
        $valid=false;
    }

    #Problem is with this if statement
    if($valid!=false)
    {
        $db_employeeID =$_POST['db_employeeID'];
        $db_jobTitle=$_POST['db_jobTitle'];
        $query = "UPDATE employees SET db_jobTitle = '$db_jobTitle' WHERE db_employeeID = '$db_employeeID'";
        $edit_employee = $db->query($query);
    }

}

if ($_SERVER["REQUEST_METHOD"] == "POST"&& isset($_POST['submit2'])) {
    if (empty($_POST["db_employeeID"])) {
        $employeeErr = "Employee is required";
        $valid=false;
    }

    #Problem is with this if statement
    if($valid!=false)
    {
        $db_employeeID =$_POST['db_employeeID'];
        $query1 = "DELETE FROM employees WHERE db_employeeID = '$db_employeeID'";
        $edit_product1 = $db->query($query1);
    }

}

if ($_SERVER["REQUEST_METHOD"] == "POST"&& isset($_POST['submit3'])) {
    if (empty($_POST["db_employeeID"])) {
        $employeeErr = "Employee is required";
        $valid=false;
    }
    if (empty($_POST["db_jobTitle"])) {
        $jobTitleErr = "Job Title is required";
        $valid=false;
    }

    #Problem is with this if statement
    if($valid!=false)
    {
        $db_employeeID =$_POST['db_employeeID'];
        $query1 = "UPDATE employees SET db_jobTitle = '$db_jobTitle' WHERE db_employeeID = '$db_employeeID'";
        $edit_product1 = $db->query($query1);
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
                                    <h6 class="m-0 font-weight-bold text-primary">Verify Employees and Assign Title:</h6>
                                </div>
                                <div class="card-body">
                                  <form class="dd" action="" method="post" >

                                  <table class="dd">

                                  <tr>
                                    <td><label for="order_id" style="margin-right:20px;">Employee Name:</label></td>
                                    <td style="width: 399px; height: 38px;" class="auto-style2">
                                    <select name="db_employeeID" style="width: 399px" class="auto-style1" required>
                                    <option value= "select">--Select an Employee--</option>
                                    <?php
                                      for($i = 0;$i<$num_employee_results;$i++)
                                      {
                                        //Move query up top and iterate through results here with an if statement
                                        $row = mysqli_fetch_assoc($employee_results);
                                        echo '<option value = "'.$row['db_employeeID'].'"> Employee Name: '.$row['db_employeeName']." Employee ID: ".$row['db_employeeID'].' </option>';

                                      }
                                    ?>
                                  </tr>
                                  <tr>
                                      <td><label for ="members">Job Title:</label></td>
                                      <td><select name="db_jobTitle" id="db_jobTitle">
                                        <option value="admin">Admin</option>
                                        <option value="employee">Employee</option>
                                        </select><span class='error'> <?php echo $jobTitleErr ?> <span></td>
                                  </tr>
                                  <tr>
                                    <td></td>
                                    <td><input class="btn btn-success" style="margin-top: 20px;"type="submit" value="Submit" name ="submit"><input style="margin-left: 4px;margin-top: 20px;"class="btn btn-danger" type="reset" value="Reset"></td>
                                  </tr>
                                  </table>

                                  </form>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6 mb-4">
                          <div class="card shadow mb-4">
                              <div class="card-header py-3">
                                  <h6 class="m-0 font-weight-bold text-primary">Delete Employees:</h6>
                              </div>
                              <div class="card-body">
                                <form class="dd" action="" method="post" >

                                <table class="dd">

                                <tr>
                                  <td><label for="order_id" style="margin-right: 20px;">Employee Name:</label></td>
                                  <td style="width: 399px; height: 38px;" class="auto-style2">
                                  <select name="db_employeeID" style="width: 399px" class="auto-style1" required>
                                  <option value= "select">--Select an Employee--</option>
                                  <?php
                                    for($i = 0;$i<$num_employee_results1;$i++)
                                    {
                                      //Move query up top and iterate through results here with an if statement
                                      $row1 = mysqli_fetch_assoc($employee_results1);
                                      echo '<option value = "'.$row1['db_employeeID'].'"> Employee Name: '.$row1['db_employeeName']." Employee ID: ".$row1['db_employeeID'].' </option>';

                                    }
                                  ?>
                                </tr>
                                <tr>
                                  <td></td>
                                  <td><input class="btn btn-success" style="margin-top: 20px;"type="submit" value="Submit" name ="submit2"><input style="margin-left: 4px; margin-top: 20px;"class="btn btn-danger" type="reset" value="Reset"></td>
                                </tr>
                                </table>

                                </form>
                              </div>
                          </div>


                        </div>


                        <div class="col-lg-6 mb-4">
                          <div class="card shadow mb-4">
                              <div class="card-header py-3">
                                  <h6 class="m-0 font-weight-bold text-primary">Edit Employees:</h6>
                              </div>
                              <div class="card-body">
                                <form class="dd" action="" method="post" >

                                <table class="dd">

                                <tr>
                                  <td><label for="order_id" style="margin-right: 20px;">Employee Name:</label></td>
                                  <td style="width: 399px; height: 38px;" class="auto-style2">
                                  <select name="db_employeeID" style="width: 399px" class="auto-style1" required>
                                  <option value= "select">--Select an Employee--</option>
                                  <?php
                                    for($i = 0;$i<$num_employee_results2;$i++)
                                    {
                                      //Move query up top and iterate through results here with an if statement
                                      $row2 = mysqli_fetch_assoc($employee_results2);
                                      echo '<option value = "'.$row2['db_employeeID'].'"> Employee Name: '.$row2['db_employeeName']." Employee ID: ".$row2['db_employeeID'].' </option>';

                                    }
                                  ?>
                                </tr>
                                <tr>
                                    <td><label for ="members">Job Title:</label></td>
                                    <td><select name="db_jobTitle" id="db_jobTitle">
                                    <option value="admin">Admin</option>
                                    <option value="employee">Employee</option>
                                    </select><span class='error'> <?php echo $jobTitleErr ?> <span></td>
                                </tr>
                                <tr>
                                  <td></td>
                                  <td><input class="btn btn-success" style="margin-top: 20px;"type="submit" value="Submit" name ="submit3"><input style="margin-left: 4px; margin-top: 20px;"class="btn btn-danger" type="reset" value="Reset"></td>
                                </tr>
                                </table>

                                </form>
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
