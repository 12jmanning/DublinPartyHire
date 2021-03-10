<?PHP
//This file controls the cart functionality for customers shopping. It creates session variables to hold the objects in the cart. It prints out in a nice format the products in the cart, shows the quantity, allows to remove items and then the cart must be updated then confirmed to place an order. There are many validations done on the cart page also. To restrict and manage user input. Validations are also done on the quantities available of each product to rent for the specified dates. There are also buttons to allow the user to move to the non_entered_dates.php page to amend their dates. They can also return to the products page to add more products to their cart. There is also a form to take in user input on whether or not they would like delivery and collection and if they would like the items to be set-up. This input is restricted to selecting Yes to set-up only if they select yes to delivery and collection. Once that form is submitted, they are moved to the bottom of the page where a summary of their order details are given including price of rental, delivery and set-up where applicable. If the user clicks ‘Confirm Order’ without being logged in, they will be redirected to the customer login page. If they are logged in they will confirm the order and be redirected to the customer dashboard. The user input will be validated and read into the orders, product_orders and transit tables. 

include('inc/detail.php');
if(isset($_SESSION['delivery_date'])&&isset($_SESSION['collection_date']))
{
    $delivery_date = $_SESSION['delivery_date'];
    $collection_date = $_SESSION['collection_date'];
}
else{
    header('location: non_entered_dates.php');
}



//comment
// If the user clicked the add to cart button on the product page we can check for the form data
if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {
    // Set the post variables so we easily identify them, also make sure they are integer
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    // Prepare the SQL statement, we basically are checking if the product exists in our databaser
    $stmt = $pdo->prepare('SELECT * FROM products WHERE db_productID = ?');
    $stmt->execute([$_POST['product_id']]);
    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the product exists (array is not empty)
    if ($product && $quantity > 0) {
        // Product exists in database, now we can create/update the session variable for the cart
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                // Product exists in cart so just update the quanity
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                // Product is not in cart so add it
                $_SESSION['cart'][$product_id] = $quantity;
            }
        } else {
            // There are no products in cart, this will add the first product to cart
            $_SESSION['cart'] = array($product_id => $quantity);
        }
    }
    // Prevent form resubmission...
    header('location: index.php?page=cart');
    exit;
}

// Remove product from cart, check for the URL param "remove", this is the product id, make sure it's a number and check if it's in the cart
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    // Remove the product from the shopping cart
    unset($_SESSION['cart'][$_GET['remove']]);
}

// Update product quantities in cart if the user clicks the "Update" button on the shopping cart page
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    // Loop through the post data so we can update the quantities for every product in cart
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            $quantity = (int)$v;
            // Always do checks and validation
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                // Update new quantity
                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }
    $deliveryErr=$setUpErr="";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // // ATtemping delivery costs:

        $valid=true;
        $_SESSION['setUpErr']= $_SESSION['deliveryErr'] = "";
        //$setUpErr=$deliveryErr="";
        if (empty($_POST["set_up"])) {
            $_SESSION['setUpErr'] = "Set Up is required";
            $valid=false;
        }
        if (empty($_POST["delivery_and_collection"])) {
            $_SESSION['deliveryErr'] = "Delivery Preference is required";
            $valid=false;
        }
        if($_POST["set_up"]=="Yes"&&$_POST["delivery_and_collection"]=="No")
        {
            $_SESSION['deliveryErr']=$_SESSION['setUpErr'] = "Set up can only be selected if delivery is chosen";
            $valid=false;
        }
        if($valid)
        {
            unset($_SESSION['setUpErr']);
            unset($_SESSION['deliveryErr']);
            $_SESSION['set_up_preference'] = $_POST['set_up'];
            $_SESSION['delivery_preference'] = $_POST['delivery_and_collection'];
            header('location: index.php?page=cart');
            exit;
        }
    //$_SESSION['set_up_preference'] = $_POST['set_up'];
    //$_SESSION['delivery_preference'] = $_POST['delivery_and_collection'];


    }

    // Prevent form resubmission...
    header('location: index.php?page=cart');
    exit;
}

// Send the user to the place order page if they click the Place Order button, also the cart should not be empty
if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    header('Location: index.php?page=placeorder');
    exit;
}

// Check the session variable for products in cart
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;
// If there are products in cart
if ($products_in_cart) {
    // There are products in the cart so we need to select those products from the database
    // Products in cart array to question mark string array, we need the SQL statement to include IN (?,?,?,...etc)
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT * FROM products WHERE db_productID IN (' . $array_to_question_marks . ')');
    // We only need the array keys, not the values, the keys are the id's of the products
    $stmt->execute(array_keys($products_in_cart));
    // Fetch the products from the database and return the result as an Array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Calculate the subtotal
    foreach ($products as $product) {
        $subtotal += (float)$product['db_productPrice'] * (int)$products_in_cart[$product['db_productID']];
        $setup2 += (float)$product['db_setUpPrice'] * (int)$products_in_cart[$product['db_productID']];
        $_SESSION['subtotal']=$subtotal;
    }

  }


  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // // ATtemping delivery costs:
    /*$set_up_preference = $_POST['set_up'];
    $delivery_preference = $_POST['delivery_and_collection'];
    $customer_ID = $_SESSION['db_customerID'];
    $delivery_date = $_SESSION['delivery_date'];
    $collection_date = $_SESSION['collection_date'];*/

    $sql_v = "SELECT delivery_costs.db_countyPrice FROM delivery_costs, customers WHERE db_customerID = $customer_ID AND customers.db_county = delivery_costs.db_county";
    $res_v = $db ->query($sql_v);
    $row = mysqli_fetch_assoc($res_v);
    $delivery_price = $row['db_countyPrice'];


}
/*$set_up_preference = $_POST['set_up'];
$delivery_preference = $_POST['delivery_and_collection'];
$customer_ID = $_SESSION['db_customerID'];
$delivery_date = $_SESSION['delivery_date'];
$collection_date = $_SESSION['collection_date'];*/

// Function to find the difference
// between two dates.
function dateDiffInDays($date1, $date2)
{
    // Calculating the difference in timestamps
    $diff = strtotime($date2) - strtotime($date1);

    // 1 day = 24 hours
    // 24 * 60 * 60 = 86400 seconds
    return abs(round($diff / 86400));
}



?>

<?=template_header('Cart')?>

<div class="cart content-wrapper">
    <h1>Shopping Cart</h1>

    <div class="row">
      <div class="col-lg-2">
        <a class="btn" style="color: #fff; background-color: #373F51; margin:auto;margin-left: 6px;" role="button" href="index.php?page=products">Go Back to Products</a>

      </div>

      <div class="col-lg-8">

      </div>

      <div class="col-lg-2">
        <a class="btn" style="color: #fff; background-color: #373F51; margin:auto;margin-left: 6px;" role="button" href="non_entered_dates.php">Change Dates</a>

      </div>
    </div>
    <form method="post" action = "index.php?page=cart#bottomOfPage"  name="order_form" id="order_form">
        <table>
            <thead>
                <tr>
                    <td colspan="2">Product</td>
                    <td>Price Per 48 Hrs</td>
                    <td>Quantity</td>
                    <td>Total</td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">You have no products added in your Shopping Cart</td>
                </tr>
                <?php else: ?>
                <?php foreach ($products as $product):
                    $start= new DateTime($_SESSION['delivery_date']);
                    $end = new DateTime($_SESSION['collection_date']);
                    $product_ID = $product['db_productID'];
                    $max_quantity =$product['db_quantity'];
                    $min_quantity = $max_quantity;

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

                        }
                        $Q=$max_quantity-$sum_quantity_ordered;
                        if($Q<$min_quantity)
                        {
                            $min_quantity=$Q;
                        }

                    }
                    $product_quantity = $min_quantity;

                    ?>
                <tr>
                    <td class="img">
                        <a href="index.php?page=product&id=<?=$product['db_productID']?>">
                            <img src="img/<?=$product['db_imageLink']?>" width="50" height="50" alt="<?=$product['db_productName']?>">
                        </a>
                    </td>
                    <td>
                        <a href="index.php?page=product&id=<?=$product['db_productID']?>"><?=$product['db_productName']?></a>
                        <br>
                        <a href="index.php?page=cart&remove=<?=$product['db_productID']?>" class="remove">Remove</a>
                    </td>
                    <td class="price">&euro;<?=$product['db_productPrice']?> per 48 hrs</td>
                    <td class="quantity">
                        <input type="number" name="quantity-<?=$product['db_productID']?>" value="<?=$products_in_cart[$product['db_productID']]?>" min="1" max="<?=$product_quantity?>" placeholder="Quantity" required>
                    </td>
                    <td class="price">&euro;<?=$product['db_productPrice'] * $products_in_cart[$product['db_productID']]?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
                <tr>
                  <td><label for="delivery_date">Start Date:</label></td>
                  <td><label for="delivery_date"><?= $delivery_date ?></label><br><br></td>
                </tr>

                <tr>
                  <td><label for="collection_date">End Date:</label></td>
                  <td><label for="delivery_date"><?= $collection_date ?></label><br><br></td>
                </tr>

                <tr>
                  <td><label>Do you want your order to be delivered and collected?</label></td>
                  <td><select name="delivery_and_collection" id = "delivery_and_collection">
                    <option value = "Yes">Yes</option>
                    <option value = "No">No</option>
                </select><span class='error'> <?php echo $_SESSION['deliveryErr'] ?> <span><br><br></td>
                </tr>

                <tr>
                  <td><label>Do you want your delivery items to be set up?</label></td>
                  <td><select name = "set_up" id = "set_up">
                    <option value = "Yes">Yes</option>
                    <option value = "No">No</option>
                </select><span class='error'> <?php echo $_SESSION['setUpErr'] ?> <span><br><br></td>
                </tr>

            </tbody>
        </table>
        <div class="buttons">
            <input type="submit" value="Update" name="update">
        </div>
    </form>
</div>

<div class="cart content-wrapper">
    <form method="post" action = "registerorder.php"  name="order_form" id="order_form">

        <div style="position: absolute;">
          <h2>Order Confirmation:</h2>
          <h5>Start Date:</h5> <?php echo $_SESSION['delivery_date'] ?>
          <h5>End Date:</h5> <?php echo $_SESSION['collection_date'] ?>
          <h5>Delivery:</h5> <?php echo $_SESSION['delivery_preference'] ?>
          <span class='error'> <?php echo $_SESSION['deliveryErr'] ?> </span>
          <h5>Setup Preference:</h5> <?php echo $_SESSION['set_up_preference'] ?>
          <span class='error'> <?php echo $_SESSION['setUpErr'] ?> </span>
          <br>
          
        <label for ="register-order"><h5>Comment or Special Instructions:</h5></label><br>
        <input type="text" name="db_orderComment" size = 80>

        </div>



        <div class="subtotal">
            <span class="text">Rent Subtotal</span>
            <span class="price">&euro;<?php $dateDiff = ceil(dateDiffInDays($_SESSION['delivery_date'], $_SESSION['collection_date'])/2)*$_SESSION['subtotal']; $_SESSION['rental_price']=$dateDiff;
 echo $dateDiff;?></span>
        </div>
        <div class="subtotal">
            <span class="text">Set Up Cost</span>
            <span class="price">&euro;<?php
            if($_SESSION['set_up_preference']=="Yes" && $_SESSION['delivery_preference']=="Yes")
            {
                $set_up_cost = $setup2;
                echo $set_up_cost;
            }
            else
            {
                $set_up_cost=0;
                echo $set_up_cost;
            }
            $_SESSION['set_up_cost']=$set_up_cost;
            ?></span>
        </div>
        <div class="subtotal">
            <span class="text">Delivery Price</span>
            <span class="price">&euro;<?php
            if($_SESSION['delivery_preference']=="Yes")
            {
                $customer_ID = $_SESSION['db_customerID']; $sql_v = "SELECT delivery_costs.db_countyPrice FROM delivery_costs, customers WHERE db_customerID = $customer_ID AND customers.db_county = delivery_costs.db_county";
                $res_v = $db ->query($sql_v);
                $row = mysqli_fetch_assoc($res_v);
                $delivery_price = $row['db_countyPrice']; echo $delivery_price;
            }
            else
            {
                $delivery_price=0; echo $delivery_price;
            }
            $_SESSION['delivery_price']=$delivery_price;
            ?>
        </span>
        </div>
        <div class="subtotal">
            <span class="text">Overall Order Price</span>
            <span class="price">&euro;<?php
            $overall_total = $dateDiff+ $delivery_price +$set_up_cost;
            $_SESSION['order_total']=$overall_total;
            echo $overall_total;
            ?>
        </span>
        </div>
        <a name="bottomOfPage"></a>

        <div class="buttons">
            <input type="submit" value="Confirm Order" name="placeorder" >
        </div>
    </form>
</div>

<?=template_footer()?>
