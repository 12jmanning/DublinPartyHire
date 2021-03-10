

<?php
//PHP script which helps with the URL flow of the website. For example, the home.php page is shown when a visitor goes to https://stu33001.scss.tcd.ie/group_6/. This means we do not need to reference home.php in the URL. It is also used for the product and products page.  
// Connecting to database.

session_start();
// Include functions and connect to the database using PDO MySQL
include 'functions.php';
$pdo = pdo_connect_mysql();

// Page is set to home (home.php) by default, so when the visitor visits that will be the page they see.
$page = isset($_GET['page']) && file_exists($_GET['page'] . '.php') ? $_GET['page'] : 'home';
// Include and show the requested page
include $page . '.php';
?>

<?php
// Get the 4 most recently added products
$stmt = $pdo->prepare('SELECT * FROM products DESC LIMIT 4');
$stmt->execute();
$recently_added_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
