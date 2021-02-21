
<?php
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
            <input type="number" name="quantity" value="1" min="1" max="<?=$product['db_quantity']?>" placeholder="Quantity" required>
            <input type="hidden" name="product_id" value="<?=$product['db_productID']?>">
            <input type="submit" value="Add To Cart">
        </form>
    </div>
</div>

<?=template_footer()?>
