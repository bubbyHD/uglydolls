<!doctype html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>uglyshop</title>
    <link rel="icon" href="uglydolls/icon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- animate CSS -->
    <link rel="stylesheet" href="css/animate.css">
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="css/all.css">
    <!-- flaticon CSS -->
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="css/magnific-popup.css">
    <!-- swiper CSS -->
    <link rel="stylesheet" href="css/slick.css">
    <!-- style CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<?php
session_start();

// Connect to your database
$con=mysqli_connect("localhost","root","","uglydolls");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Check if the user is logged in
$loggedIn = isset($_SESSION['user_id']);
if(!$loggedIn) {
    // User is not logged in. Redirect them to the login page
    header('Location: login.php');
    exit;
}

$id = $_SESSION['user_id'];
// Fetch the user's data from the database
$user_result = $con->query("SELECT * FROM usuario WHERE usernum = $id");
$user = $user_result->fetch_assoc();

// Fetch the number of items in the cart
if($loggedIn) {
  $id = $_SESSION['user_id'];
  $result = $con->query("SELECT SUM(quantity) as count FROM carrito WHERE usernum = $id");
  $row = $result->fetch_assoc();
  $cartCount = $row['count'];
} else {
  $cartCount = 0; // or whatever you want the default to be
}

// Fetch the items in the cart from the database
$result = $con->query("SELECT carrito.productonum, carrito.quantity, producto.nombre, producto.precio FROM carrito JOIN producto ON carrito.productonum = producto.productonum WHERE carrito.usernum = $id");

// Calculate the total cost of the items in the cart
$total = 0;
while ($row = $result->fetch_assoc()) {
    $product_id = $row['productonum'];
    $quantity = $row['quantity'];

    // Fetch the product details from the database
    $product_result = $con->query("SELECT * FROM producto WHERE productonum = $product_id");
    $product_row = $product_result->fetch_assoc();
    $product_price = $product_row['precio'];

    $total += $product_price * $quantity;
}

// Fetch the items in the cart from the database again for displaying in the order
$result = $con->query("SELECT carrito.productonum, carrito.quantity, producto.nombre, producto.precio FROM carrito JOIN producto ON carrito.productonum = producto.productonum WHERE carrito.usernum = $id");

// Check if the form to checkout was submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $address = $_POST['address'];
  $card_number = $_POST['card_number'];

  // Check if address or card number is empty
  if(empty($address) || empty($card_number)) {
      $message = "Address and card number must not be empty.";
  } else {
      // Fetch the items in the cart from the database
$cart_items = $con->query("SELECT productonum, quantity FROM carrito WHERE usernum = $id");

while ($item = $cart_items->fetch_assoc()) {
    $productonum = $item['productonum'];
    $quantity = $item['quantity'];

    // Create a new row in the pedido table for each item in the cart
    $query = "INSERT INTO pedido (usernum, productonum, quantity, pedidototal, direccion, tarjeta) VALUES ($id, $productonum, $quantity, $total, '$address', '$card_number')";
    $result = mysqli_query($con, $query);

    // Check if the query was successful
    if(!$result) {
        // Unsuccessful query
        $message = "There was an error processing your order. Please try again.";
        break;
    }
}

if($result) {
    // Delete the items from the carrito table
    $query = "DELETE FROM carrito WHERE usernum = $id";
    $query = "UPDATE producto SET stock = stock - $quantity WHERE productonum = $productonum";
    $result = mysqli_query($con, $query);

    // Redirect to the confirmation page
    header('Location: confirmation.php');
    exit;
}
  }
}
?>

<body>
  <!--::header part start::-->
  <header class="main_menu home_menu">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="index.php"> <img src="uglydolls/indexlogo.png" alt="logo"> </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="menu_icon"><i class="fas fa-bars"></i></span>
                        </button>

                        <div class="collapse navbar-collapse main-menu-item" id="navbarSupportedContent">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="index.php">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="category.php">Buy Uglydoll</a>
                                </li>
                                <?php if ($loggedIn) : ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="profile.php">Profile</a>
                                </li>
                                <?php else : ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="login.php">Login</a>
                                </li>
                                <?php endif; ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="about.php">About</a>
                                </li>
                            </ul>
                        </div>
                        <div class="hearer_icon d-flex">
                            <a href="<?php echo $loggedIn ? 'profile.php' : 'login.php'; ?>"><i class="ti-user"></i></a>
                                <a href="cart.php" id="navbarDropdown3" role="button">
                                    <i class="fas fa-cart-plus"></i>
                                    <?php if ($loggedIn && $cartCount > 0): ?>
                                    <span class="badge badge-light"><?php echo $cartCount; ?></span>
                                    <?php endif; ?>
                                </a>
                        </div>                           
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- Header part end-->

  <!--================Home Banner Area =================-->
  <!-- breadcrumb start-->
  <section class="breadcrumb breadcrumb_bg">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="breadcrumb_iner">
            <div class="breadcrumb_iner_item">
              <h2>Checkout</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- breadcrumb start-->

<!--================Checkout Area =================-->
<form method="post" action="">
<section class="checkout_area padding_top">
    <div class="container">
        <div class="billing_details">
            <div class="row">
                <div class="col-lg-8">
                <h3>Order Details</h3>
    <?php if(isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
                    <div class="col-md-12 form-group">
                        <input type="text" class="form-control" id="company" name="name" value="<?php echo $user['nombre']; ?>" readonly />
                    </div>
                    <div class="col-md-12 form-group">
                        <input type="text" class="form-control" id="company" name="email" value="<?php echo $user['correo']; ?>" readonly />
                    </div>
                    <div class="col-md-12 form-group">
                        <div class="creat_account">
                            <h3>Shipping Details</h3>
                            <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="address" name="address" placeholder="Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Address'" />
                            </div>
                        </div>
                        <div class="creat_account">
                            <h3>Payment Details</h3>
                            <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="number" name="card_number" placeholder="Credit card number" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Credit card number'" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="order_box">
                        <h2>Your Order</h2>
                        <ul class="list">
    <li>
        <a href="#" style="pointer-events: none;">Product
            <span>Total</span>
        </a>
    </li>
    <?php while ($row = $result->fetch_assoc()): ?>
    <li>
        <a href="#" style="pointer-events: none;"><?php echo $row['nombre']; ?>
            <span class="middle">x <?php echo $row['quantity']; ?></span>
            <span class="last">$<?php echo $row['precio'] * $row['quantity']; ?></span>
        </a>
    </li>
    <?php endwhile; ?>
</ul>
                        <ul class="list list_2">
                            <li>
                                <a href="#" style="pointer-events: none;">Subtotal
                                    <span>$<?php echo $total; ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="#" style="pointer-events: none;">Shipping
                                    <span>Flat rate: Free!</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" style="pointer-events: none;">Total
                                    <span>$<?php echo $total; ?></span>
                                </a>
                            </li>
                        </ul>
                        <div class="creat_account">
                            <input type="checkbox" id="f-option4" name="selector" />
                            <label for="f-option4">I've read and accept the </label>
                            <a href="#">terms & conditions*</a>
                        </div>
                        <button type="submit" value="submit" class="btn_3"> Complete Order</button>
    <?php if (!empty($message)) : ?>
    <div class="genric-btn disable radius"><?php echo $message; ?></div>
    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</section>
<!--================End Checkout Area =================-->

  <!--::footer_part start::-->
  <footer class="footer_part">
    <div class="container">
      <div class="row justify-content-around">
        <div class="col-sm-6 col-lg-4">
          <div class="single_footer_part">
            <h4>Newsletter</h4>
            <p>Heaven fruitful doesn't over lesser in days. Appear creeping
            </p>
            <div id="mc_embed_signup">
              <form target="_blank"
                action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01"
                method="get" class="subscribe_form relative mail_part">
                <input type="email" name="email" id="newsletter-form-email" placeholder="Email Address"
                  class="placeholder hide-on-focus" onfocus="this.placeholder = ''"
                  onblur="this.placeholder = ' Email Address '">
                <button type="submit" name="submit" id="newsletter-submit"
                  class="email_icon newsletter-submit button-contactForm">subscribe</button>
                <div class="mt-10 info"></div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="copyright_part">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div class="copyright_text">
              <P><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with love?</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></P>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="footer_icon social_icon">
              <ul class="list-unstyled">
                <li><a href="#" class="single_social_icon"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#" class="single_social_icon"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#" class="single_social_icon"><i class="fas fa-globe"></i></a></li>
                <li><a href="#" class="single_social_icon"><i class="fab fa-behance"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!--::footer_part end::-->

  <!-- jquery plugins here-->
  <!-- jquery -->
  <script src="js/jquery-1.12.1.min.js"></script>
  <!-- popper js -->
  <script src="js/popper.min.js"></script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.min.js"></script>
  <!-- easing js -->
  <script src="js/jquery.magnific-popup.js"></script>
  <!-- swiper js -->
  <script src="js/swiper.min.js"></script>
  <!-- swiper js -->
  <script src="js/masonry.pkgd.js"></script>
  <!-- particles js -->
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.nice-select.min.js"></script>
  <!-- slick js -->
  <script src="js/slick.min.js"></script>
  <script src="js/jquery.counterup.min.js"></script>
  <script src="js/waypoints.min.js"></script>
  <script src="js/contact.js"></script>
  <script src="js/jquery.ajaxchimp.min.js"></script>
  <script src="js/jquery.form.js"></script>
  <script src="js/jquery.validate.min.js"></script>
  <script src="js/mail-script.js"></script>
  <script src="js/stellar.js"></script>
  <script src="js/price_rangs.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>
</body>

</html>