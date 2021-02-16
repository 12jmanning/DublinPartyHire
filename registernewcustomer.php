<?PHP
//This php script passes the values input by the user into the members table of the database
session_start();

include ("detail.php"); 

$student_id = $_POST['student_number'];
$first_name = $_POST['first_name'];
$last_name = $_POST['second_name'];
$student_email = $_POST['student_email'];
$student_course = $_POST['student_course'];

$q  = "INSERT INTO customers (";
$q .= "db_customerName, db_customerAddress, db_county, db_customerEircode, db_customerEmail, db_customerPhone";
$q .= ") VALUES (";
$q .= "'$db_customerName', '$db_customerAddress', '$db_county', '$db_customerEircode','$db_customerEmail','$db_customerPhone')";

echo $q;
$result = $db->query($q);  

?>