<?php
session_start();
include('inc/detail.php');
include('inc/navbar.php');

$employee_ID = $_SESSION['db_employeeID'];
$employee_name = $_SESSION['db_employeeName'];
$job_title = "Not Yet Verified";



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
    <form class="dd" action="" method="post" >

    <table class="dd">

    
    </table>
    <tr>
      <td></td>
      <td><p>Return To Homepage <a href="index.php">HERE</a></p></td>
    </tr>
    <tr>

    </form>
  </div>

</div>