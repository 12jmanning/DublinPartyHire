<?PHP
//The new customers php page allows new customers to register with their name,	address, eircode, county email, phone number and password. Extensive validations are done on this form through the registernewcustomers.php to ensure user input is valid and the passwords entered are strong. Once validated, they are redirected to the cart or the customer dashboard depending on where they were redirected from. 
//This php script passes the values input by the user into the members table of the database
session_start();

include ("inc/detail.php");

$db_customerName = $_POST['db_customerName'];
$db_customerAddress = $_POST['db_customerAddress'];
$db_county = $_POST['db_county'];
$db_customerEircode = $_POST['db_customerEircode'];
$db_customerEmail = $_POST['db_customerEmail'];
$db_customerPhone = $_POST['db_customerPhone'];

$password = $_POST['password'];
$db_customerPW = password_hash($password, PASSWORD_DEFAULT);

$q  = "INSERT INTO customers (";
$q .= "db_customerName, db_customerAddress, db_county, db_customerEircode, db_customerEmail, db_customerPhone, db_customerPW";
$q .= ") VALUES (";
$q .= "'$db_customerName', '$db_customerAddress', '$db_county', '$db_customerEircode','$db_customerEmail','$db_customerPhone', '$db_customerPW')";

$result = $db->query($q);

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
    if(isset($_SESSION['link']))
    {
        header($_SESSION['link']);
    }

    header('Location: index.php');
    }
//This will then move the user to the mai menu where they have accesss to the member section and the admin section


?>

