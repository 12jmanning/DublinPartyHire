<?php
// Get the 4 most recently added products
$stmt = $pdo->prepare("SELECT * from products WHERE db_productID IN ('1', '10', '14', '40')");
$stmt->execute();
$recently_added_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$deliveryDateErr = $collectionDateErr ="";
$db_deliveryDatetime = $db_collectionDatetime = "";
$grand=true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST['delivery_date'])) {
    $deliveryDateErr = "Delivery Date is required";
    $grand=false;
  }
  if (empty($_POST['collection_date'])) {
    $deliveryDateErr = "Collection Date is required";
    $grand=false;
  }
  if($_POST['delivery_date']>$_POST['collection_date'])
  {
    $deliveryDateErr = $collectionDateErr = "Please Enter Valid Dates";
    $grand=false;
  }
  if($grand==true)
  {
    $_SESSION['delivery_date'] = $_POST['delivery_date'];
    $_SESSION['collection_date'] = $_POST['collection_date'];
  }
}

?>

<?=template_header('Home')?>

<!-- Primary Image -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">

      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="img/party.jpg" height="500"class="d-block w-100" alt="..." style="object-fit: cover; opacity: 0.8;">
          <div class="carousel-caption d-none d-md-block">
            <h1 style="color: #fff">Welcome to DublinPartyHire</h1>
              <p>Make your event special.</p>
          </div>
        </div>
      </div>
    </div>


<div class="recentlyadded content-wrapper">
    <h2>Recently Added Products</h2>
    <form method="post" action = ""  name="order_form" id="order_form">
      <tr>
        <td><label for="delivery_date">Delivery Date:</label></td>
        <td><input type="date" name="delivery_date" id="delivery_date" ><?php echo $deliveryDateErr ?> <span></td>
      </tr>

      <tr>
        <td><label for="collection_date">Collection Date:</label></td>
        <td><input type="date" name="collection_date" id="collection_date" ><?php echo $collectionDateErr ?> <span></td>
      </tr>
      <div class="buttons">
            <input type="submit" value="Update" name="update">
      </div>
    </form>
    <?php echo $_SESSION['collection_date']; echo $_SESSION['delivery_date']; ?>
    <div class="products">
        <?php foreach ($recently_added_products as $product): ?>
        <a href="index.php?page=product&db_productID=<?=$product['db_productID']?>" class="product">
            <img src="img/<?=$product['db_imageLink']?>" width="200" height="200" alt="<?=$product['db_productName']?>">
            <span class="name"><?=$product['db_productName']?></span>
            <span class="price">
                &euro;<?=$product['db_productPrice']?> per 48 hrs
                <?php if ($product['db_productPrice'] > 0): ?>
                <?php endif; ?>
            </span>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<div class="recentlyadded content-wrapper">
    <h2>Features:</h2>
</div>

<!-- Marketing messaging and featurettes
  ================================================== -->
<!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing" style="padding-top: 30px; padding-bottom:30px;">

      <!-- Three columns of text below the carousel -->
      <div class="row">
        <div class="col-lg-3">

          <img class="homepage-icons" src="img/laptop.png" alt="">
          <h2>Create your Account</h2>
          <p>And save your details for the future. View orders and print invoices.</p>
          <p><a class="btn btn-secondary" href="newcustomers.php" role="button">Register &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-3">
          <img class="homepage-icons" src="img/orders.png" alt="">
          <h2>Make your Orders Online</h2>
          <p>And have it delivered when it suits. Options to have it setup as well.</p>
          <p><a class="btn btn-secondary" href="index.php?page=products" role="button">Order Now &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-3">
          <img class="homepage-icons" src="img/balloon.png" alt="">

          <h2>Range of Party Essentials</h2>
          <p>Everything from marquees to tables to bouncy castles.</p>
          <p><a class="btn btn-secondary" href="index.php?page=products" role="button">View Products &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-3">
          <img class="homepage-icons" src="img/truck.png" alt="">
          <h2>Track your Delivery Online</h2>
          <p>See exactly what time your delivery is coming.</p>
          <p><a class="btn btn-secondary" href="customerdashboard.php" role="button">View Orders &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->




          <div class="recentlyadded content-wrapper" >
              <h2>Why Choose Us?</h2>
          </div>

      <!-- START THE FEATURETTES -->



      <div class="row featurette" style="padding-top: 20px;">
        <div class="col-md-7">
          <h2 class="featurette-heading">All the party essentials. <span class="text-muted">Furniture, glassware, cutlery, linen and gazebos.</span></h2>
          <p class="lead">The finest quality in the industry which will impress any guest.</p>
        </div>
        <div class="col-md-5">
          <img src="img/feature1.jpg" alt="" width="400px" height="400px">

          </svg>

        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7 order-md-2">
          <h2 class="featurette-heading">Delivered straight to your door. <span class="text-muted">with optional setup.</span></h2>
          <p class="lead">Not only will our dedicated delivery drivers provide a prompt delivery, they will set it up for you as well.</p>
        </div>
        <div class="col-md-5 order-md-1">
          <img src="img/feature2.jpg" alt="" width="400px" height="400px">
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">Letting you focus on the party. <span class="text-muted">and your outfit.</span></h2>
          <p class="lead">Don't get stressed over events, sign up today.</p>
        </div>
        <div class="col-md-5">
          <img src="img/feature3.jpg" alt="" width="500px" height="400px">
        </div>
      </div>

      <hr class="featurette-divider">

      <!-- /END THE FEATURETTES -->

    </div><!-- /.container -->

<?=template_footer()?>
