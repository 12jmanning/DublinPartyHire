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
        //$nameErr=$db_customerEmailErr="";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $valid=true;
          $valid1=false;

            /* if (empty($_POST["db_customerName"])) {
                $nameErr = "Name is required";
                $valid=false;
              }
            //This ensures the name only contsains valid characters
            else {
              $db_customerName = test_input($_POST["db_customerName"]);
              if (!preg_match("/^[a-zA-Z-' ]*$/",$db_customerName)) {
                $nameErr = "Only letters and white space allowed";
                $valid=false;
              }
            }

            if (empty($_POST["db_customerEmail"])) {
              $db_customerEmailErr = "db_customerEmail is required";
              $valid=false;
            }
            //This ensures the db_customerEmail is correctly formatted
            else {
              $db_customerEmail = test_input($_POST["db_customerEmail"]);
              if (!filter_var($db_customerEmail, FILTER_VALIDATE_EMAIL)) {
                $db_customerEmailErr = "Invalid email format";
                $valid=false;
              }
            }*/
            if($valid)
            {
              $db_customerName=$_POST['db_customerName'];
              $db_customerEmail=$_POST['db_customerEmail'];
              $query ="select * from customers";
              $result = $db->query($query);
              $num_results = mysqli_num_rows($result);
              if($num_results==0)
              {
                  $valid1=false;
              }
              else
              {
                  $i=0;
                  while($i<$num_results&&$valid1<>true)
                  {
                      $row = mysqli_fetch_assoc($result);
                      if($row['db_customerName']==$db_customerName&&$row['db_customerEmail']==$db_customerEmail)
                      {
                        $_SESSION['db_customerID']=$row['db_customerID'];
                        $valid1=true;
                        header('Location: index.php');
                      }
                      $i++;
                  }
              }
            }
        }
    ?>


<!-- This is the form which takes in the user input value for the member ID -->

    <h2 class="form-heading">Please Log In!</h2>


    <form class="table-forms" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <table class="table-forms">
      <tr>
        <td><label for ="members">Name:</label></td>
        <td><input type="text" name="db_customerName" size = 30><span class='error'> <?php echo $nameErr ?> <span></td>
      </tr>
      <tr>
        <td><label for ="members">Email:</label></td>
        <td><input type="text" name="db_customerEmail" id="db_customerEmail" size = 20>
        <span class='error'> <?php echo $db_customerEmailErr ?> <span></td>
      </tr>

      <tr>
        <td></td>
        <td><input class="btn btn-success" type="submit" name="submit" value="Submit"><input style="margin-left: 10px;"class="btn btn-danger" type="reset" value = "Reset"></td>
      </tr>

      <tr>
    		<td></td>
    		<td><p>Or create an account <a href="newcustomers.php">HERE</a></p></td>
    	</tr>
    </table>
    </form>

    <a class="btn" style="background-color: #373F51; color: #fff;     margin-left: auto; margin-right: auto; display: block; width: 30%; margin-top: 10%;" role="button" href="employeelogin.php">Staff Login</a>
</body>
</html>
