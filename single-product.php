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

<body>
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

    // Fetch the number of items in the cart
    if($loggedIn) {
        $id = $_SESSION['user_id'];
        $result = $con->query("SELECT SUM(quantity) as count FROM carrito WHERE usernum = $id");
        $row = $result->fetch_assoc();
        $cartCount = $row['count'];
    } else {
        $cartCount = 0; // or whatever you want the default to be
    }
?>

<script>
function checkStockAndLoginStatus(stock) {
    <?php if(!$loggedIn): ?>
        alert('You are not signed in. Please sign in to add items to your cart.');
        return false;
    <?php else: ?>
        var quantity = 1;  // quantity being added to the cart
        if (quantity > stock) {
            alert('The quantity requested is more than the quantity in stock');
            return false;
        }
        return true;
    <?php endif; ?>
}
</script>
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

  <!-- breadcrumb start-->
  <section class="breadcrumb breadcrumb_bg">
    <div class="container">
      <div class="row justify-content-center">
        <div>
          <div class="breadcrumb_iner">
            <div class="breadcrumb_iner_item">
              <h2>Shop</h2>
              <p>Product view</p>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
  <!-- breadcrumb start-->
  <!--================End Home Banner Area =================-->

  <?php
// Connect to your database
$con=mysqli_connect("localhost","root","","uglydolls");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Get the product ID from the URL
$id = $_GET['id'];

// Fetch the product details from the database
$result = $con->query("SELECT * FROM producto WHERE productonum = $id");

if ($result->num_rows > 0) {
    // Fetch the product details
    $row = $result->fetch_assoc();
?>

<!--================Single Product Area =================-->
<div class="product_image_area section_padding">
    <div class="container">
        <div class="row s_product_inner justify-content-between">
            <div class="col-lg-7 col-xl-7">
                <div class="product_slider_img">
                        <div data-thumb="https://lab.anahuac.mx/~a00444232/pngs/<?php echo $row['foto']; ?>">
                            <img src="https://lab.anahuac.mx/~a00444232/pngs/<?php echo $row['foto'] ?>" />
                        </div>
                    </div>
                </div>
            <div class="col-lg-5 col-xl-4">
                <div class="s_product_text">
                    <h3><?php echo $row['nombre']; ?></h3>
                    <h2>$<?php echo $row['precio']; ?></h2>
                    <ul class="list">
                        <li>
                            <a class="active" href="#">
                                <span>Type:</span> <?php echo $row['tipo']; ?></a>
                        </li>
                        <li>
                             <span>In stock:</span> <?php echo $row['stock']; ?>
                        </li>
                    </ul>
                    <p>
                        <?php echo $row['descripcion']; ?>
                    </p>
                    <div class="card_area d-flex justify-content-between align-items-center">
                    <form action="cart.php" method="post" onsubmit="return checkStockAndLoginStatus(stock)">
    <div class="product_count">
        <span class="inumber-decrement"> <i class="ti-minus"></i></span>
        <input class="input-number" type="text" name="quantity" value="1" min="1" max="10">
        <span class="number-increment"> <i class="ti-plus"></i></span>
    </div>
    <input type="hidden" name="add_product" value="1">
    <input type="hidden" name="product_id" value="<?php echo $row['productonum']; ?>">
    <input type="submit" value="Add to cart" class="btn_3">
</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--================End Single Product Area =================-->

<!-- product_list part start-->
<section class="product_list best_seller">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="section_tittle text-center">
                    <h2>Best Sellers <span>shop</span></h2>
                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-12">
                <div class="best_product_slider owl-carousel">
                    <?php
                    $result = $con->query("SELECT productonum, COUNT(*) AS count FROM pedido GROUP BY productonum ORDER BY count DESC LIMIT 5");
                    while ($row = $result->fetch_assoc()) {
                        $product_id = $row['productonum'];

                        $product_result = $con->query("SELECT * FROM producto WHERE productonum = $product_id");
                        $product_row = $product_result->fetch_assoc();
                    ?>
                    <div class="single_product_item">
                    <a href="single-product.php?id=<?php echo $product_row['productonum']; ?>">
    <img src="https://lab.anahuac.mx/~a00444232/pngs/<?php echo $product_row['foto']; ?>" alt="">
</a>
                        <div class="single_product_text">
                            <h4><?php echo $product_row['nombre']; ?></h4>
                            <h3>$<?php echo $product_row['precio']; ?></h3>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
} else {
    echo "Product not found";
}

$con->close();
?>



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
              <P>
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Not really</a>
</P>
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
  <script src="js/lightslider.min.js"></script>
  <!-- swiper js -->
  <script src="js/masonry.pkgd.js"></script>
  <!-- particles js -->
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.nice-select.min.js"></script>
  <!-- slick js -->
  <script src="js/slick.min.js"></script>
  <script src="js/swiper.jquery.js"></script>
  <script src="js/jquery.counterup.min.js"></script>
  <script src="js/waypoints.min.js"></script>
  <script src="js/contact.js"></script>
  <script src="js/jquery.ajaxchimp.min.js"></script>
  <script src="js/jquery.form.js"></script>
  <script src="js/jquery.validate.min.js"></script>
  <script src="js/mail-script.js"></script>
  <script src="js/stellar.js"></script>
  <!-- custom js -->
  <script src="js/theme.js"></script>
  <script src="js/custom.js"></script>
</body>

</html>