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
    // define variables and set to empty values
    $nameErr = $addressErr = $countyErr = $db_customerEmailErr = $eircodeErr = $phoneErr = $password_err = $confirm_password_err ="";
    $db_customerName = $db_customerAddress = $db_county = $db_customerEmail = $db_customerEircode = $db_customerPhone = $password = $confirm_password ="";
    $valid=true;
      //This if statement is executed after the form has been submitted and the contents of the statement execute the form data validation. Each of the inputs are checked if they are null and appropriate error messages are assigned
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty($_POST["db_customerName"])) {
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

      if (empty($_POST["db_customerAddress"])) {
        $addressErr = "Address is required";
        $valid=false;
      }

      if (empty($_POST["db_county"])) {
        $countyErr = "County is required";
        $valid=false;
      }
      //This ensures the student number input only contains numeric values
      else {
        $db_county = test_input($_POST["db_county"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/",$db_county)) {
          $countyErr = "Only letters and white space allowed";
          $valid=false;
        }
      }

      if (empty($_POST["db_customerEmail"])) {
        $db_customerEmailErr = "Email is required";
        $valid=false;
      }
      //This ensures the db_customerEmail is correctly formatted
      else {
        $db_customerEmail = test_input($_POST["db_customerEmail"]);
        if (!filter_var($db_customerEmail, FILTER_VALIDATE_EMAIL)) {
          $db_customerEmailErr = "Invalid email format";
          $valid=false;
        }
      }

      if (empty($_POST["db_customerPhone"])) {
        $phoneErr = "Student number is required";
        $valid=false;
      }
      //This ensures the student number input only contains numeric values
      else {
        $db_customerPhone = test_input($_POST["db_customerPhone"]);
        if (!is_numeric($db_customerPhone)) {
          $phoneErr = "Only numbers allowed";
          $valid=false;
        }
      }

      if (empty($_POST["db_customerEircode"])) {
        $eircodeErr = "Eircode is required";
        $valid=false;
      }
      //This ensures the course code only contsains valid characters
      else {
        $db_customerEircode = test_input($_POST["db_customerEircode"]);
        if (!preg_match("/([A-Za-z0-9])+/",$db_customerEircode)) {
        $eircodeErr = "Only numbers, letters and white space allowed";
        $valid=false;
        }
      }

      if(empty(trim($_POST["password"]))){
          $password_err = "Please enter a password.";
          $valid=false;
      } elseif(strlen(trim($_POST["password"])) < 6){
          $password_err = "Password must have atleast 6 characters.";
          $valid=false;
      } else{
          $password = trim($_POST["password"]);
      }

      // Validate confirm password
      if(empty(trim($_POST["confirm_password"]))){
          $confirm_password_err = "Please confirm password.";
          $valid=false;
      } else{
          $confirm_password = trim($_POST["confirm_password"]);
          if(empty($password_err) && ($password != $confirm_password)){
              $confirm_password_err = "Password did not match.";
              $valid=false;
          }
      }


    // If the validation is accepted then this if statement is executed which will firstly call the register_members php file
      if($valid<>false)
      {
        include 'registernewcustomer.php';
      //Here, a query is run to obtain the member_id of the newly added member and this will be stored as a session varibale which is a super global variable
        $found=false;
        $query ="select * from customers";
        $result = $db->query($query);
        $num_results = mysqli_num_rows($result);
        $i=0;
        $found_member_id="";
        while($i<$num_results&&$found<>true)
        {
            $row = mysqli_fetch_assoc($result);
            if($row['db_customerEmail']==$db_customerEmail&&$row['db_customerName']==$db_customerName)
            {
                $found_customer_id=$row['db_customerID'];
                $found=true;
            }
            $i++;
        }
        if($found==true)
        {
            $_SESSION['db_customerID']=$found_customer_id;
        }
        //This will then move the user to the mai menu where they have accesss to the member section and the admin section
        header('Location: index.php');
      }

    }
    //This function is called to test the input, trim the whitespace characters and return the formatted data
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }


?>

  <!-- This is the member form where they input their information and it calls itself in the action attribute in order to perform the validations -->
<div class="boxed">
<h2 class="form-heading">Become a customer!</h2>
<form class="table-forms" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

        <table class="table-forms">
          <tr>
            <td><label for ="members">Customer Name:</label></td>
            <td><input type="text" name="db_customerName" size = 30><span class='error'> <?php echo $nameErr ?> <span></td>
          </tr>

          <tr>
            <td><label for ="members">Address:</label></td>
            <td><input type="text" name="db_customerAddress" size = 30><span class='error'> <?php echo $addressErr ?> <span></td>
          </tr>

          <tr>
            <td><label for="members">County:</label><span class='error'> <?php echo $countyErr ?> <span></td>
            <td><select name="db_county" id="db_county">
                <option value="Dublin">Dublin</option>
                <option value="Cork">Cork</option>
                <option value="Carlow">Carlow</option>
                <option value="Cavan">Cavan</option>
                <option value="Clare">Clare</option>
                <option value="Donegal">Donegal</option>
                <option value="Galway">Galway</option>
                <option value="Kerry">Kerry</option>
                <option value="Kildare">Kildare</option>
                <option value="Kilkenny">Kilkenny</option>
                <option value="Laois">Laois</option>
                <option value="Leitrim">Leitrim</option>
                <option value="Limerick">Limerick</option>
                <option value="Longford">Longford</option>
                <option value="Louth">Louth</option>
                <option value="Mayo">Mayo</option>
                <option value="Meath">Meath</option>
                <option value="Monaghan">Monaghan</option>
                <option value="Offaly">Offaly</option>
                <option value="Roscommon">Roscommon</option>
                <option value="Sligo">Sligo</option>
                <option value="Tipperary">Tipperary</option>
                <option value="Waterford">Waterford</option>
                <option value="Westmeath">Westmeath</option>
                <option value="Wexford">Wexford</option>
                <option value="Wicklow">Wicklow</option><br>
              </select> </td>

          </tr>

          <tr>
            <td><label for ="members">Eircode:</label></td>
            <td><input type="text" name="db_customerEircode" id="db_customerEircode" size = 20><span class='error'> <?php echo $eircodeErr ?> <span></td>
          </tr>

          <tr>
            <td><label for ="members">Email:</label></td>
            <td><input type="text" name="db_customerEmail" id="db_customerEmail" size = 20><span class='error'> <?php echo $db_customerEmailErr ?> <span></td>
          </tr>

          <tr>
            <td><label for ="members">Phone Number:</label></td>
            <td><input type="text" name="db_customerPhone" id="db_customerPhone" size = 20><span class='error'> <?php echo $phoneErr ?> <span></td>
          </tr>

          <tr>
            <td><label for ="members">Password:</label></td>
            <td>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </td>
          </tr>

          <tr>
            <td><label for ="members">Confirm Password:</label></td>
            <td>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </td>
          </tr>
          <tr>
            <td></td>
            <td><input class="btn btn-success" type="submit" name="submit" value="Submit"><input style="margin-left: 10px;"class="btn btn-danger" type="reset" value = "Reset"></td>
          </tr>

          <tr>
            <td></td>
            <td><p>Already have an account? Log in <a href="existingcustomers.php">HERE</a></p></td>
          </tr>
        </table>

    </form>
    </div>

</body>
</html>
