<?PHP
include('inc/navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>

</head>
<body>

<?php
    session_start();

    include ("inc/detail.php");
    // define variables and set to empty values
    $employeeNameErr = $jobTitleErr ="";
    $db_employeeName = $db_jobTitle = "";
    $grand=true;
    
      //This if statement is executed after the form has been submitted and the contents of the statement execute the form data grandation. Each of the inputs are checked if they are null and appropriate error messages are assigned
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty($_POST["db_employeeName"])) {
           $employeeNameErr = "Name is required";
           $grand=false;
        }
        //This ensures the name only contsains valid characters
        /*else {
          $db_employeeName = test_input($_POST["db_employeeName"]);
          if (!preg_match("/^[a-zA-Z-' ]*$/",$db_employeeName)) {
            $employeeNameErr = "Only letters and white space allowed";
            $grand=false;
          }
        }*/

      if (empty($_POST["db_jobTitle"])) {
        $jobTitleErr = "Job Title is required";
        $grand=false;
      }
      /*else {
        $db_jobTitle = test_input($_POST["db_jobTitle"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/",$db_customerName)) {
          $jobTitleErr = "Only letters and white space allowed";
          $grand=false;
        }
      } */

    // If the validation is accepted then this if statement is executed which will firstly call the register_members php file
      if($grand<>false)
      {
        $db_employeeName = $_POST['db_employeeName'];
        $db_jobTitle = $_POST['db_jobTitle'];
        $q  = "INSERT INTO employees (";
        $q .= "db_employeeName, db_jobTitle";
        $q .= ") VALUES (";
        $q .= "'$db_employeeName', '$db_jobTitle')";
        $result = $db->query($q);

        $query="SELECT db_employeeID from employees WHERE db_employeeName = '$db_employeeName' AND db_jobTitle = '$db_jobTitle'";
        $result1 = $db->query($query);
        $row = mysqli_fetch_assoc($result1);
        $db_employeeID = $row['db_employeeID'];


        header('Location: index.php');
      }

    }

?>

  <!-- This is the member form where they input their information and it calls itself in the action attribute in order to perform the validations -->
<div class="boxed">
<h2 class="form-heading">New Employee Form</h2>

<form class="table-forms" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <table class="table-forms">
    <tr>
      <td><label for ="members">Employee Name:</label></td>
      <td><input type="text" name="db_employeeName" size = 30><span class='error'> <?php echo $employeeNameErr ?> <span></td>
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
      <td><input class="btn btn-success" type="submit" name="submit" value="Submit"><input style="margin-left: 10px;"class="btn btn-danger" type="reset" value = "Reset"></td>
    </tr>

    <tr>
      <td></td>
      <td><p>If you already have an employee account login <a href="employeelogin.php">HERE</a></p></td>
    </tr>
  </table>

    </form>
    </div>

</body>
</html>
