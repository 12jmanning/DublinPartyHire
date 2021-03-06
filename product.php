
<?php
session_start();
include('inc/detail.php');
// Check to make sure the id parameter is specified in the URL
if (isset($_GET['db_productID'])) {
    // Prepare statement and execute, prevents SQL injection
    $stmt = $pdo->prepare('SELECT * FROM products WHERE db_productID = ?');
    $stmt->execute([$_GET['db_productID']]);
    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the product exists (array is not empty)
    if (!$product) {
        // Simple error to display if the id for the product doesn't exists (array is empty)
        exit('Product does not exist!');
    }
} else {
    // Simple error to display if the id wasn't specified
    exit('Product does not exist!');
}

$start= new DateTime($_SESSION['delivery_date']);
$end = new DateTime($_SESSION['collection_date']);
$product_ID = $product['db_productID'];
$max_quantity =$product['db_quantity'];
$min_quantity = $max_quantity;
<<<<<<< HEAD
$query = $pdo->prepare('SELECT product_orders.db_quantityOrdered, orders.db_deliveryDatetime, orders.db_collectionDatetime FROM product_orders, orders
WHERE product_orders.db_productID= ? AND product_orders.db_orderID =orders.db_orderID');
$query-> execute([$_GET['db_productID']]);
$result = $query->fetch(PDO::FETCH_ASSOC);
=======
>>>>>>> 8c6abf52cd779e9777521df2ec5b23bd3197b0f1

$i= new DateTime();
for($i = $start; $i <= $end; $i->modify('+1 day')){

    $sum_quantity_ordered=0;
    $query = "SELECT product_orders.db_quantityOrdered, orders.db_deliveryDatetime, orders.db_collectionDatetime FROM product_orders, orders WHERE product_orders.db_productID= '$product_ID' AND product_orders.db_orderID =orders.db_orderID";
    $result_query = $db->query($query);
    $num_results = mysqli_num_rows($result_query);

    for($j= 0;$j<$num_results;$j++)
    {
        $row = mysqli_fetch_assoc($result_query);
        $delivery= new DateTime($row['db_deliveryDatetime']);
        $collection = new DateTime($row['db_collectionDatetime']);  
        if($i>=$delivery && $i <=$collection )
        {
            $sum_quantity_ordered=$sum_quantity_ordered+$row['db_quantityOrdered'];
        }
<<<<<<< HEAD

    }*/

    for ($j = 0; $j < count($result); $j++) {
        $delivery = new DateTime($result[$j]['db_deliveryDatetime']);
        $collection = new DateTime($result[$j]['db_collectionDatetime']);
        //Error Lies within this if statement
        if($i>=$delivery)// && $i <= $collection)
        {
            $sum_quantity_ordered=$sum_quantity_ordered+$result[$j]['db_quantityOrdered'];
        }
    }

=======
        
    }
>>>>>>> 8c6abf52cd779e9777521df2ec5b23bd3197b0f1
    $Q=$max_quantity-$sum_quantity_ordered;
    if($Q<$min_quantity)
    {
        $min_quantity=$Q;
    }

}
$product_quantity = $min_quantity;


?>

<?=template_header('Product')?>

<div class="product content-wrapper">
    <img src="img/<?=$product['db_imageLink']?>" width="500" height="500" alt="<?=$product['db_productName']?>">
    <div>
        <h1 class="name"><?=$product['db_productName']?></h1>
        <span class="price">
            &euro;<?=$product['db_productPrice']?> per 48 hrs
        </span>
        <form action="index.php?page=cart" method="post">
            <input type="number" name="quantity" value="1" min="1" max="<?=$product_quantity?>" placeholder="Quantity" required>
            <input type="hidden" name="product_id" value="<?=$product['db_productID']?>">
            <input type="submit" value="Add To Cart">
        </form>
        <?php echo print_r($row['db_quantityOrdered']); echo "test"; ?>
    </div>
</div>

<?=template_footer()?>
