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

// Check if the form to update/delete product was submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_delete'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Check if the new quantity is 0
    if ($quantity == 0) {
        // Delete the product from the cart
        $query = "DELETE FROM carrito WHERE usernum = $id AND productonum = $product_id";
    } else {
        // Update the quantity in the cart
        $query = "UPDATE carrito SET quantity = $quantity WHERE usernum = $id AND productonum = $product_id";
    }

    // Execute the query
    $result = mysqli_query($con, $query);

    // Redirect back to the cart page
    header('Location: cart.php');
    exit;
}

// Check if the form to add product was submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Add the product to the cart
    $query = "INSERT INTO carrito (usernum, productonum, quantity) VALUES ($id, $product_id, $quantity)";
    $result = mysqli_query($con, $query);
    if ($result) {
        // Successful insert
        $message = 'Product added to cart successfully';
    } else {
        // Unsuccessful insert
        $message = 'Failed to add product to cart';
    }
}

?>

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
                        </div>                    
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- Header part end-->


  <!--================Home Banner Area =================-->
  <!-- breadcrumb start
  <section class="breadcrumb breadcrumb_bg">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="breadcrumb_iner">
            <div class="breadcrumb_iner_item">
              <h2>Cart Products</h2>
              <p>Home <span>-</span>Cart Products</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
   breadcrumb end-->

  <!--================Cart Area =================-->
<section class="cart_area padding_top">
    <div class="container">
        <div class="cart_inner">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch the cart items from the database
                        $result = $con->query("SELECT * FROM carrito WHERE usernum = $id");
                        $total = 0;
                        while ($row = $result->fetch_assoc()) {
                            $product_id = $row['productonum'];
                            $quantity = $row['quantity'];

                            // Fetch the product details from the database
                            $product_result = $con->query("SELECT * FROM producto WHERE productonum = $product_id");
                            $product_row = $product_result->fetch_assoc();
                            $product_name = $product_row['nombre'];
                            $product_price = $product_row['precio'];
                            $product_total = $product_price * $quantity;
                            $total += $product_total;
                        ?>
                        <tr>
                            <td>
                                <div class="media">
                                    <div class="d-flex">
                                    <img src="https://lab.anahuac.mx/~a00444232/pngs/<?php echo $product_row['foto']; ?>" style="max-width:150px; max-height:150px;" alt="" />
                                    </div>
                                    <div class="media-body">
                                        <p><?php echo $product_name; ?></p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h5>$<?php echo $product_price; ?></h5>
                            </td>
                            <td>
                            <form action="cart.php" method="post">
    <input type="hidden" name="update_delete" value="1">
    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
    <input class="input-number" type="number" name="quantity" value="<?php echo $quantity; ?>" min="0" max="99" onchange="this.form.submit()">
</form>
                            </td>
                            <td>
                                <h5>$<?php echo $product_total; ?></h5>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <h5>Subtotal</h5>
                            </td>
                            <td>
                                <h5>$<?php echo $total; ?></h5>
                            </td>
                        </tr>
                        <tr class="shipping_area">
                            <td></td>
                            <td></td>
                            <td>
                                <h5>Shipping</h5>
                            </td>
                            <td>
                                <h5>$5.00</h5>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="checkout_btn_inner float-right">
                    <a class="btn_1" href="category.php">Continue Shopping</a>
                    <a class="btn_1 checkout_btn_1" href="checkout.php">Proceed to checkout</a>
                </div>
            </div>
        </div>
</section>
<!--================End Cart Area =================-->


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
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with love</a>
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