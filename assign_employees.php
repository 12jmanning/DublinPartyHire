<?php
session_start();
include('inc/detail.php');
include('inc/navbar.php');
$db_employeeErr=$db_vanErr="";
$valid=true;

$now_today_date = date("Y-m-d H:i:s");
$start_today_date = date("Y-m-d");
$start_today_date = $end_today_date+"T00:00:00.00";
$no_time = "0000-00-00T00:00:00.00";
$employee_title ="employee";

$employee_ID = $_SESSION['db_employeeID'];
$employee_name = $_SESSION['db_employeeName'];
$job_title = $_SESSION['db_jobTitle'];
$yes = "Yes";
$order_ID = $_POST['order_id'];

$van_query = "SELECT * FROM vans";
$van_results = $db->query($van_query);
$num_van_results = mysqli_num_rows($van_results);

$employee_query = "SELECT employees.db_employeeID, employees.db_employeeName FROM employees, employee_timesheets WHERE employees.db_employeeID=employee_timesheets.db_employeeID AND employees.db_jobTitle='$employee_title' AND (employee_timesheets.db_StartDatetime BETWEEN '$start_today_date' AND '$now_today_date') AND employee_timesheets.db_endDatetime = '0'";
$employee_results = $db->query($employee_query);
$num_employee_results = mysqli_num_rows($employee_results);


//SELECT employees.db_employeeID, employees.db_employeeName FROM employees, employee_timesheets WHERE employees.db_employeeID=employee_timesheets.db_employeeID AND (employee_timesheets.db_StartDatetime BETWEEN '$start_today_date' AND '$now_today_date') AND employee_timesheets.db_endDatetime = '0'
?>

<div class="row" style="margin-top: 3%;">

  <div class="col-lg-6">
    <h2 style="text-align: center;">My Details:</h2>
    <?php echo $customer_ID ?>
    <table border="2">
      <tr>
        <td> Employee ID </td>
        <td> <?php echo $employee_ID; ?> </td>
      </tr>
      <tr>
        <td> Employee Name </td>
        <td> <?php echo $employee_name; ?> </td>
      </tr>
      <tr>
        <td> Job Title </td>
        <td> <?php echo $job_title; ?> </td>
      </tr>
    </table>
  </div>


  <div class="col-lg-6" >
    <h2 style="text-align: center;">Assign Employees and Vans to Transit Orders:</h2>
    <form class="" action="" method="post" name="invoice" id="invoice">

    <table class="">

    <tr>
      <td><label for="order_id">Van ID:</label></td>
      <td style="width: 618px; height: 38px;" class="auto-style2">
      <select name="van_id" style="width: 399px" class="auto-style1" required>
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
      <td style="width: 618px; height: 38px;" class="auto-style2">
      <select name="employee_id" style="width: 399px" class="auto-style1" required>
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
      <td><input class="btn btn-success" type="submit" value="Submit"><input style="margin-left: 4px;"class="btn btn-danger" type="reset" value="Reset"></td>
    </tr>
    </table>

    </form>

  </div>
  <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["employee_id"])||empty($_POST["van_id"])) {
            $db_employeeErr = "Both fields ar required";
            $db_vanErr = "Both fields ar required";
            $valid=false;
        }
        if($valid==true ){
            $employee_id = $_POST["employee_id"];
            $van_id = $_POST["van_id"];

        }

    }

   ?>


</div>


