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
    $employeeNameErr = $jobTitleErr = $password_err = $confirm_password_err = "";
    $db_employeeName = $db_jobTitle = $password = $confirm_password = "";
    $grand=true;

      //This if statement is executed after the form has been submitted and the contents of the statement execute the form data grandation. Each of the inputs are checked if they are null and appropriate error messages are assigned
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty($_POST["db_employeeName"])) {
           $employeeNameErr = "Name is required";
           $grand=false;
        }
        //This ensures the name only contsains valid characters
        // else {
        //   $db_employeeName = test_input($_POST["db_employeeName"]);
        //   if (!preg_match("/^[a-zA-Z-' ]*$/",$db_employeeName)) {
        //     $employeeNameErr = "Only letters and white space allowed";
        //     $grand=false;
        //   }

      //
      // if (empty($_POST["db_jobTitle"])) {
      //   $jobTitleErr = "Job Title is required";
      //   $grand=false;
      // }
      /*else {
        $db_jobTitle = test_input($_POST["db_jobTitle"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/",$db_customerName)) {
          $jobTitleErr = "Only letters and white space allowed";
          $grand=false;
        }
      } */
      if(empty(trim($_POST["password"]))){
          $password_err = "Please enter a password.";
          $grand=false;
      } elseif(strlen(trim($_POST["password"])) < 6){
          $password_err = "Password must have atleast 6 characters.";
          $grand=false;
      } else{
          $password = trim($_POST["password"]);
      }

      // Validate confirm password
      if(empty(trim($_POST["confirm_password"]))){
          $confirm_password_err = "Please confirm password.";
          $grand=false;
      } else{
          $confirm_password = trim($_POST["confirm_password"]);
          if(empty($password_err) && ($password != $confirm_password)){
              $confirm_password_err = "Password did not match.";
              $grand=false;
          }
      }

    // If the validation is accepted then this if statement is executed
      if($grand<>false)
      {
        $db_employeeName = $_POST['db_employeeName'];
        $password = $_POST['password'];
        $db_employeePW = password_hash($password, PASSWORD_DEFAULT);

        $q  = "INSERT INTO employees (";
        $q .= "db_employeeName, db_employeePW";
        $q .= ") VALUES (";
        $q .= "'$db_employeeName','$db_employeePW')";
        $result = $db->query($q);

        $query="SELECT db_employeeID from employees WHERE db_employeeName = '$db_employeeName' AND db_jobTitle = '$db_jobTitle'";
        $result1 = $db->query($query);
        $row = mysqli_fetch_assoc($result1);
        $db_employeeID = $row['db_employeeID'];
        $_SESSION['db_employeeID'] = $db_employeeID;
        $_SESSION['db_employeeName'] = $db_employeeName;
        $_SESSION['db_jobTitle'] = $db_jobTitle;


        header('Location: new_employee_info.php');
      }

    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
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
      <td><label for ="members">Password:</label></td>
      <td>
          <input type="password" name="password" class="" value="<?php echo $password; ?>">
          <span class="help-block"><?php echo $password_err; ?></span>
      </td>
    </tr>

    <tr>
      <td><label for ="members">Confirm Password:</label></td>
      <td>
          <input type="password" name="confirm_password" class="" value="<?php echo $confirm_password; ?>">
          <span class="help-block"><?php echo $confirm_password_err; ?></span>
      </td>
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
