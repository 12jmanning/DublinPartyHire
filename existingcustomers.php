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
    // This php code will run a query which gets all of the member_id rows from the members table and then loops through to find the user input member ID and returns an error string if not found. If it is found, it is stored as a super global session variable and they are passed to the main menu page
        session_start();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $valid=false;
            include("detail.php");
            $member_id=$_POST['db_customerID'];
            
            if(empty($_POST['db_customerID']))
            {
                echo 'You must enter a valid customer ID';
                exit;
            }
            $query ="select db_customerID from customers";
            $result = $db->query($query);
            $num_results = mysqli_num_rows($result);
            if($num_results==0)
            {
                $valid=false;
            }
            else
            {
                $i=0;
                while($i<$num_results&&$valid<>true)
                {
                    $row = mysqli_fetch_assoc($result); 
                    if($row['db_customerID']==$db_customerID)
                    {
                        $valid=true;
                    }
                    $i++;
                }
            }

            if($valid==true)
            {
                $_SESSION['customerID']=$db_customerID;
                header('Location: secondary_homepage.php');
            }
            else{
                echo 'Please enter a valid customer ID';
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
  <br> <br> <br> <br> 
<!-- This is the form which takes in the user input value for the member ID -->
    <div class="boxed">
    <h1>Customer Members:</h1>
    <form method="post" action=""> 
 
        <label for ="tickets">Customer ID:</label>
        <input type="text" name="db_customerID" size = 30> 
        <br> <br> 
        <input type="submit" value = "Submit">
        <input type="reset" value = "Reset"> 

    </form>
    </div>
    <br> <br> 

    <div class="center">
    <button onclick="window.location.href='index.php';" class="button button1">Homepage</button>
    </div>
    <div class="center2">
    <button onclick="window.location.href='newcustomers.php';" class="button button2">Create New Cusomer</button>
    </div>
    <br></br>
</body>
</html>