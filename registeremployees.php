<!DOCTYPE html>
<html lang="en">
<head>
  <style> 
    .boxed
    {
      width: 500px;
      border: 10px solid grey;
      padding: 50px;
      max-width: 500px;
      margin: auto;
    }
    .button {
        border: none;
        color: white;
        padding: 16px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        
        transition-duration: 0.4s;
        cursor: pointer;
        max-width: 500px;
        margin: auto;
        }

        .button1 {
        background-color: white;
        color: black;
        border: 2px solid #4CAF50;
        }

        .button1:hover {
        background-color: #4CAF50;
        color: white;
        }

        .button2 {
        background-color: white;
        color: black;
        border: 2px solid #008CBA;
        }

        .button2:hover {
        background-color: #008CBA;
        color: white;
        }
        .content {
          max-width: 500px;
          margin: auto;
        }
        .center {
          margin: 0;
          position: absolute;
          left: 40%;
          
        }
        .center2 {
          margin: 0;
          position: absolute;
          left: 50%;
        
        }

  </style>
    <!-- Here, Bootstrap is being intsalled and imported along with importing Bootstrap's JavaScript, Styles
     CSS, Sass. This allows access to resources and elements to aid in web development -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="master.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
    session_start();
    
    include ("inc/detail.php");         
    // define variables and set to empty values
    $employeeNameErr = $jobTitleErr ="";
    $db_employeeName = $db_jobTitle = "";
    $valid=true;
      //This if statement is executed after the form has been submitted and the contents of the statement execute the form data validation. Each of the inputs are checked if they are null and appropriate error messages are assigned
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        /*if (empty($_POST["db_employeeName"])) {
           $employeeNameErr = "Name is required";
           $valid=false;
        } 
        //This ensures the name only contsains valid characters
        else {
          $db_employeeName = test_input($_POST["db_employeeName"]);
          if (!preg_match("/^[a-zA-Z-' ]*$/",$db_employeeName)) {
            $employeeNameErr = "Only letters and white space allowed";
            $valid=false;
          }
        }

      if (empty($_POST["db_jobTitle"])) {
        $jobTitleErr = "Job Title is required";
        $valid=false;
      }
      else {
        $db_jobTitle = test_input($_POST["db_jobTitle"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/",$db_customerName)) {
          $jobTitleErr = "Only letters and white space allowed";
          $valid=false;
        }
      }*/   

    // If the validation is accepted then this if statement is executed which will firstly call the register_members php file 
      if($valid<>false)
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
<!-- Here, a navigation bar is being created for the homepage which will have links to the Homepage, the new members page which allows new users to sign up and the existing members page which allows present members to log in with their Member ID's-->
<nav class="navbar navbar-dark bg-dark">
    <a class="navbar-brand" href="homepage.html">DUMMS Society</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="true" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse show" id="navbarNav" style="">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="homepage.html">Homepage <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="members.php">New Members</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="existing_members.php">Existing Members</a>
        </li>

      </ul>
    </div>
  </nav>
  <br> <br>
  <!-- This is the member form where they input their information and it calls itself in the action attribute in order to perform the validations -->
<div class="boxed">
<h1>New Employee:</h1>
<form method="post" action=""> 
        <label for ="members">Employee Name:</label>
        <input type="text" name="db_employeeName" size = 30>  
        <span class='error'> <?php echo $employeeNameErr ?> <span>
        <br> <br> 

        <label for ="members">Job Title:</label>
        <select name="db_jobTitle" id="db_jobTitle">
            <option value="admin">Admin</option>
            <option value="employee">Employee</option>
        </select>
        <span class='error'> <?php echo $jobTitleErr ?> <span>
        <br> <br> 

        <input type="submit" value = "Submit">
        <input type="reset" value = "Reset">
    </form>
    </div>
    <br> <br>
    <br> <br>
  

    <div class="center">
    <button onclick="window.location.href='admindashboard.php';" class="button button1">Admin Dashboard</button>
    </div>
    <br></br>
</body>
</html>  