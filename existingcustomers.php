<?PHP
//This page allows existing customers to login with their existing credentials, their email and password. Once these are validated, they are moved either to the cart or the customer dashboard depending on where they were redirected onto this page from. This page also contains a link to the newcustomers.php page. 
include('inc/navbar.php');
?>



<?php
    // This php code will run a query which gets all of the member_id rows from the members table and then loops through to find the user input member ID and returns an error string if not found. If it is found, it is stored as a super global session variable and they are passed to the main menu page
session_start();
include("inc/detail.php");

$db_customerEmail = $password = "";
$db_customerEmailErr = $password_err = "";


      if ($_SERVER["REQUEST_METHOD"] == "POST") {


            if(empty(trim($_POST["db_customerEmail"]))){
                $db_customerEmailErr = "Please enter username.";
            } else{
                $db_customerEmail = trim($_POST["db_customerEmail"]);
            }


            // Check if password is empty
            if(empty(trim($_POST["password"]))){
                $password_err = "Please enter your password.";
            } else{
                $password = trim($_POST["password"]);
            }

            // Validate credentials
            if(empty($db_customerEmailErr) && empty($password_err)){
                // Prepare a select statement
                $sql = "SELECT db_customerID, db_customerEmail, db_customerPW FROM customers WHERE db_customerEmail = ?";

                if($stmt = mysqli_prepare($link, $sql)){

                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "s", $param_email);

                    // Set parameters
                    $param_email = $db_customerEmail;

                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                        // Store result
                        mysqli_stmt_store_result($stmt);

                        // Check if username exists, if yes then verify password
                        if(mysqli_stmt_num_rows($stmt) == 1){
                            // Bind result variables
                            mysqli_stmt_bind_result($stmt, $id, $db_customerEmail, $hashed_password);
                            if(mysqli_stmt_fetch($stmt)){
                                if(password_verify($password, $hashed_password)&&isset($_SESSION['link'])){
                                    // Password is correct, so start a new session
                                    session_start();

                                    // Store data in session variables

                                    $_SESSION["db_customerID"] = $id;


                                    // Redirect user to welcome page
                                    header($_SESSION['link']);
                                } 
                                else if(password_verify($password, $hashed_password)&&!isset($_SESSION['link']))
                                {
                                    // Password is correct, so start a new session
                                    session_start();

                                    // Store data in session variables

                                    $_SESSION["db_customerID"] = $id;


                                    // Redirect user to welcome page
                                    header("location: customerdashboard.php");
                                }
                                else{
                                    // Display an error message if password is not valid
                                    $password_err = "The password you entered was not valid.";
                                }
                            }
                        } else{
                            // Display an error message if username doesn't exist
                            $db_customerEmailErr = "No account found with that email.";
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

    <h2 class="form-heading">Please Log In!</h2>


    <form class="table-forms" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <table class="table-forms">
      <tr>
        <td><label for ="members">Email:</label></td>
        <td><input type="text" name="db_customerEmail" id="db_customerEmail" size = 20>
        <br><span class='error'> <?php echo $db_customerEmailErr ?> <span/></td>
      </tr>

      <tr>
        <td><label>Password:</label></td>
        <td><div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input type="password" name="password" >
                <br><span class="error"><?php echo $password_err; ?></span>
            </div></td>
      </tr>

      <tr>
        <td></td>
        <td><input class="btn btn-success" type="submit" name="submit" value="Login"><input style="margin-left: 10px;"class="btn btn-danger" type="reset" value = "Reset"></td>
      </tr>

      <tr>
    		<td></td>
    		<td><p>Or create an account <a href="newcustomers.php">HERE</a></p></td>
    	</tr>
    </table>
    </form>

    <a class="btn" style="background-color: #373F51; color: #fff;     margin-left: auto; margin-right: auto; display: block; width: 30%; margin-top: 10%;" role="button" href="employeelogin.php">Staff Login</a>
