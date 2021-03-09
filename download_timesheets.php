<?php
include('inc/detail.php');
     //export.php
if(isset($_POST["export"]))
{
     header('Content-Type: text/csv; charset=utf-8');
     header('Content-Disposition: attachment; filename=data.csv');
     $output = fopen("php://output", "w");
     fputcsv($output, array('Timesheet ID', 'Start Time', 'End Time', 'Employee Name'));

     $query = "SELECT employee_timesheets.db_timesheetID, employee_timesheets.db_startDatetime, employee_timesheets.db_endDatetime, employees.db_employeeName
                           FROM `employee_timesheets` , `employees` WHERE employee_timesheets.db_employeeID = employees.db_employeeID";
     $result = $db->query($query);
     while($row = mysqli_fetch_assoc($result)){
      fputcsv($output, $row);
    }

    fclose($output);
}
?>
