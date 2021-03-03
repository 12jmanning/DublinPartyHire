<?php
session_start();
include('inc/detail.php');
include('inc/navbar.php');


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
     ?>
  </div>


  <div class="col-lg-6" >
    <h2>Verify Employees and Assign Title:</h2>
    <form class="dd" action="" method="post" >

    <table class="dd">

    <tr>
      <td><label for="order_id">Employee Name:</label></td>
      <td style="width: 399px; height: 38px;" class="auto-style2">
      <select name="product_id" style="width: 399px" class="auto-style1" required>
      <option value= "select">--Select an Employee--</option>
      <?php
        for($i = 0;$i<$num_employee_results;$i++)
        {
          //Move query up top and iterate through results here with an if statement
          $row = mysqli_fetch_assoc($employee_results1);
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
      <td><input class="btn btn-success" type="submit" value="Submit" name ="submit"><input style="margin-left: 4px;"class="btn btn-danger" type="reset" value="Reset"></td>
    </tr>
    </table>

    </form>
  </div>


  <div class="col-lg-6" >
    <h2>Delete Employees:</h2>
    <form class="dd" action="" method="post" >

    <table class="dd">

    <tr>
      <td><label for="order_id">Employee Name:</label></td>
      <td style="width: 399px; height: 38px;" class="auto-style2">
      <select name="employee_id" style="width: 399px" class="auto-style1" required>
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
      <td><input class="btn btn-success" type="submit" value="Submit" name ="submit2"><input style="margin-left: 4px;"class="btn btn-danger" type="reset" value="Reset"></td>
    </tr>
    </table>

    </form>

  </div>

</div>
