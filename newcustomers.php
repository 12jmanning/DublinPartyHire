<?PHP
include('inc/navbar.php');
?>
<script type="text/javascript">
$(document).ready(function() {
      $('#email').blur(function() {
          var email = $('#email').val();
          if (IsEmail(email) == false) {
              $('#sign-up').attr('disabled', true);
              $('#popover-email').removeClass('hide');
          } else {
              $('#popover-email').addClass('hide');
          }
      });
      $('#password').keyup(function() {
          var password = $('#password').val();
          if (checkStrength(password) == false) {
              $('#sign-up').attr('disabled', true);
          }
      });
      $('#confirm-password').blur(function() {
          if ($('#password').val() !== $('#confirm-password').val()) {
              $('#popover-cpassword').removeClass('hide');
              $('#sign-up').attr('disabled', true);
          } else {
              $('#popover-cpassword').addClass('hide');
          }
      });
      $('#contact-number').blur(function() {
          if ($('#contact-number').val().length != 10) {
              $('#popover-cnumber').removeClass('hide');
              $('#sign-up').attr('disabled', true);
          } else {
              $('#popover-cnumber').addClass('hide');
              $('#sign-up').attr('disabled', false);
          }
      });
      $('#sign-up').hover(function() {
          if ($('#sign-up').prop('disabled')) {
              $('#sign-up').popover({
                  html: true,
                  trigger: 'hover',
                  placement: 'below',
                  offset: 20,
                  content: function() {
                      return $('#sign-up-popover').html();
                  }
              });
          }
      });

      function IsEmail(email) {
          var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
          if (!regex.test(email)) {
              return false;
          } else {
              return true;
          }
      }

      function checkStrength(password) {
          var strength = 0;


          //If password contains both lower and uppercase characters, increase strength value.
          if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
              strength += 1;
              $('.low-upper-case').addClass('text-success');
              $('.low-upper-case i').removeClass('fa-file-text').addClass('fa-check');
              $('#popover-password-top').addClass('hide');


          } else {
              $('.low-upper-case').removeClass('text-success');
              $('.low-upper-case i').addClass('fa-file-text').removeClass('fa-check');
              $('#popover-password-top').removeClass('hide');
          }

          //If it has numbers and characters, increase strength value.
          if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) {
              strength += 1;
              $('.one-number').addClass('text-success');
              $('.one-number i').removeClass('fa-file-text').addClass('fa-check');
              $('#popover-password-top').addClass('hide');

          } else {
              $('.one-number').removeClass('text-success');
              $('.one-number i').addClass('fa-file-text').removeClass('fa-check');
              $('#popover-password-top').removeClass('hide');
          }

          //If it has one special character, increase strength value.
          if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
              strength += 1;
              $('.one-special-char').addClass('text-success');
              $('.one-special-char i').removeClass('fa-file-text').addClass('fa-check');
              $('#popover-password-top').addClass('hide');

          } else {
              $('.one-special-char').removeClass('text-success');
              $('.one-special-char i').addClass('fa-file-text').removeClass('fa-check');
              $('#popover-password-top').removeClass('hide');
          }

          if (password.length > 7) {
              strength += 1;
              $('.eight-character').addClass('text-success');
              $('.eight-character i').removeClass('fa-file-text').addClass('fa-check');
              $('#popover-password-top').addClass('hide');

          } else {
              $('.eight-character').removeClass('text-success');
              $('.eight-character i').addClass('fa-file-text').removeClass('fa-check');
              $('#popover-password-top').removeClass('hide');
          }




          // If value is less than 2

          if (strength < 2) {
              $('#result').removeClass()
              $('#password-strength').addClass('progress-bar-danger');

              $('#result').addClass('text-danger').text('Very Weak');
              $('#password-strength').css('width', '10%');
          } else if (strength == 2) {
              $('#result').addClass('good');
              $('#password-strength').removeClass('progress-bar-danger');
              $('#password-strength').addClass('progress-bar-warning');
              $('#result').addClass('text-warning').text('Week')
              $('#password-strength').css('width', '60%');
              return 'Weak'
          } else if (strength == 4) {
              $('#result').removeClass()
              $('#result').addClass('strong');
              $('#password-strength').removeClass('progress-bar-warning');
              $('#password-strength').addClass('progress-bar-success');
              $('#result').addClass('text-success').text('Strength');
              $('#password-strength').css('width', '100%');

              return 'Strong'
          }

      }

  });
</script>


<!DOCTYPE html>
<html lang="en">
<head>
<style media="screen">
body {
  font-family: 'Lato', sans-serif;
}

.progress {
  height: 5px;
}

.control-label {
  text-align: left !important;
  padding-bottom: 7px;
}

.form-horizontal {
  padding: 25px 20px;
  border: 1px solid #eee;
  border-radius: 5px;
}

select.form-control:focus {
  border-color: #e9ab66;
  box-shadow: none;
}

.block-help {
  font-weight: 300;
}

.terms {
  text-decoration: underline;
}

.modal {
  text-align: center;
  padding: 0!important;
}

.modal:before {
  content: '';
  display: inline-block;
  height: 100%;
  vertical-align: middle;
  margin-right: -4px;
}

.modal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
}

.divider {
  position: absolute;
  height: 2px;
  border: 1px solid #eee;
  width: 100%;
  top: 10px;
  z-index: -5;
}

.ex-account {
  position: relative;
}

.ex-account p {
  background-color: rgba(255, 255, 255, 0.41);
}

select:hover {
  color: #444645;
  background: #ddd;
}

.fa-file-text {
  color: #edda39;
}

.mar-top-bot-50 {
  margin-top: 50px;
  margin-bottom: 50px;
}
</style>
</head>
<body>

<?php
    session_start();
    include('inc/detail.php');
    $delivery_query = "SELECT * FROM delivery_costs";
    $delivery_results = $db->query($delivery_query);
    $num_delivery_results = mysqli_num_rows($delivery_results);

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

      if ($_POST["db_county"] == "select") {
        $countyErr = "County is required";
        $valid=false;
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
        $phoneErr = "Phone number is required";
        $valid=false;
      }
      else
      {
          if (!is_numeric($_POST["db_customerPhone"])) {
              $phoneErr = "Phone Number must be numeric";
              $valid=false;
          }
          else if ($_POST["db_customerPhone"]<=0) {
              $phoneErr = "Phone Number must be greater than 0";
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
      } elseif(strlen(trim($_POST["password"])) < 8){
          $password_err = "Password must have atleast 8 characters.";
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
        include('registernewcustomer.php');
      //Here, a query is run to obtain the member_id of the newly added member and this will be stored as a session varibale which is a super global variable
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
<form class="table-forms" method="post" action="">

        <table class="table-forms">
          <tr>
            <td><label for ="members">Customer Name:</label></td>
            <td><input type="text" name="db_customerName" size = 30><span class='error'> <?php echo $nameErr ?> </span></td>
          </tr>

          <tr>
            <td><label for ="members">Address:</label></td>
            <td><input type="text" name="db_customerAddress" size = 30><br><span class="error"> <?php echo $addressErr ?> </span></td>
          </tr>

          <tr>
            <td><label for="members">County:</label></td>
            <td><select name="db_county" id="db_county">
              <option value= "select">--Select a County--</option>
              <?php
                for($i = 0;$i<$num_delivery_results;$i++)
                {
                  //Move query up top and iterate through results here with an if statement
                  $row = mysqli_fetch_assoc($delivery_results);
                  echo '<option value = "'.$row['db_county'].'">'.$row['db_county'].' </option>';

                }
              ?><br>
            </select><br><span class='error'><?php echo $countyErr ?> </span> </td>

          </tr>

          <tr>
            <td><label for ="members">Eircode:</label></td>
            <td><input type="text" name="db_customerEircode" id="db_customerEircode" size = 20><br><span class='error'> <?php echo $eircodeErr ?> <span/></td>
          </tr>

          <tr>
            <td><label for ="members">Email:</label></td>
            <td><input type="text" name="db_customerEmail" id="db_customerEmail" size = 20><br><span class='error'> <?php echo $db_customerEmailErr ?> <span/></td>
          </tr>

          <tr>
            <td><label for ="members">Phone Number:</label></td>
            <td><input type="text" name="db_customerPhone" id="db_customerPhone" size = 20><br><span class='error'> <?php echo $phoneErr ?> <span></td>
          </tr>

          <tr>
            <td style="position: absolute;"><label for ="members">Password:</label></td>
            <td>
                <input id="password" type="password" name="password" value="<?php echo $password; ?>" placeholder="" class="" data-placement="bottom" data-toggle="popover" data-container="body" type="button" data-html="true">
                <br><span class="error"><?php echo $password_err; ?></span>
                <div id="popover-password">
                    <p>Password Strength: <span id="result"> </span></p>
                    <div class="progress">
                        <div id="password-strength" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                        </div>
                    </div>
                    <ul class="list-unstyled">
                        <li class=""><span class="low-upper-case"><i class="fa fa-file-text" aria-hidden="true"></i></span>&nbsp; 1 lowercase &amp; 1 uppercase</li>
                        <li class=""><span class="one-number"><i class="fa fa-file-text" aria-hidden="true"></i></span> &nbsp;1 number (0-9)</li>
                        <li class=""><span class="one-special-char"><i class="fa fa-file-text" aria-hidden="true"></i></span> &nbsp;1 Special Character (!@#$%^&*).</li>
                        <li class=""><span class="eight-character"><i class="fa fa-file-text" aria-hidden="true"></i></span>&nbsp; Atleast 8 Character</li>
                    </ul>
                </div>
            </td>
          </tr>

          <tr>
            <td><label for ="members">Confirm Password:</label></td>
            <td>
                <input type="password" name="confirm_password" value="<?php echo $confirm_password; ?>">
                <br><span class="error"><?php echo $confirm_password_err; ?></span>
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
