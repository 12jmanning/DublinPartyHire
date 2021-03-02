<?PHP
include('inc/navbar.php');
?>


<!DOCTYPE html>
<html lang="en">
<body>

    <?php
    // This php code will run a query which gets all of the member_id rows from the members table and then loops through to find the user input member ID and returns an error string if not found. If it is found, it is stored as a super global session variable and they are passed to the main menu page
        session_start();
        include("inc/detail.php");

        $db_employeeID = $password = "";
        $db_employeeIDErr = $password_err = "";


        if ($_SERVER["REQUEST_METHOD"] == "POST") {



                      if(empty(trim($_POST["db_employeeID"]))){
                          $db_employeeIDErr = "Please enter employee ID.";
                      } else{
                          $db_employeeID = trim($_POST["db_employeeID"]);
                      }


                      // Check if password is empty
                      if(empty(trim($_POST["password"]))){
                          $password_err = "Please enter your password.";
                      } else{
                          $password = trim($_POST["password"]);
                      }

                      // Validate credentials
                      if(empty($db_employeeIDErr) && empty($password_err)){
                          // Prepare a select statement
                          $sql = "SELECT db_employeeID, db_employeeName, db_jobTitle, db_employeePW FROM employees WHERE db_employeeID = ?";

                          if($stmt = mysqli_prepare($link, $sql)){

                              // Bind variables to the prepared statement as parameters
                              mysqli_stmt_bind_param($stmt, "s", $param_id);

                              // Set parameters
                              $param_id = $db_employeeID;

                              // Attempt to execute the prepared statement
                              if(mysqli_stmt_execute($stmt)){
                                  // Store result
                                  mysqli_stmt_store_result($stmt);

                                  // Check if username exists, if yes then verify password
                                  if(mysqli_stmt_num_rows($stmt) == 1){
                                      // Bind result variables
                                      mysqli_stmt_bind_result($stmt, $id, $name, $jobtitle, $hashed_password);
                                      if(mysqli_stmt_fetch($stmt)){
                                          if(password_verify($password, $hashed_password)){
                                              // Password is correct, so start a new session
                                              session_start();

                                              // Store data in session variables

                                              $_SESSION['db_employeeID'] = $id;
                                              $_SESSION['db_jobTitle']= $jobtitle;
                                              $_SESSION['db_employeeName'] = $name;


                                              // Redirect user to welcome page
                                              if($_SESSION['db_jobTitle']==$admin){
                                                header('Location: admindashboard.php');
                                              }
                                              else{
                                                header('Location: employeedashboard.php');
                                              }
                                          } else{
                                              // Display an error message if password is not valid
                                              $password_err = "The password you entered was not valid.";
                                          }
                                      }
                                  } else{
                                      // Display an error message if username doesn't exist
                                      $db_employeeIDErr = "No employee account found with that ID.";
                                  }
                              } else{
                                  echo "Oops! Something went wrong. Please try again later.";
                              }

                              // Close statement
                              mysqli_stmt_close($stmt);
                          }
                      }

                      // Close connection
                      mysqli_close($link);

        }
    ?>


<!-- This is the form which takes in the user input value for the member ID -->

    <h2 class="form-heading">Staff Log In!</h2>


    <form class="table-forms" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <table class="table-forms">
      <tr>
        <td><label for ="members">Employee ID:</label></td>
        <td><input type="text" name="db_employeeID" size = 30><span class='error'> <?php echo $db_employeeIDErr ?> <span></td>
      </tr>

      <tr>
        <td><label>Password</label></td>
        <td><div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div></td>
      </tr>

      <tr>
        <td></td>
        <td><input class="btn btn-success" type="submit" name="submit" value="Login"><input style="margin-left: 10px;"class="btn btn-danger" type="reset" value = "Reset"></td>
      </tr>

      <tr>
        <td></td>
        <td><p>Get your employee account <a href="registeremployees.php">HERE</a></p></td>
      </tr>
    </table>




    </form>

</body>
</html>
