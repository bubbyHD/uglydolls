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
        $cartCount = 0; 
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
    
    <!-- banner part start-->
    <section class="banner_part">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="banner_slider owl-carousel">
                        <div class="single_banner_slider">
                            <div class="row">
                                <div class="col-lg-5 col-md-8">
                                    <div class="banner_text">
                                        <div class="banner_text_iner">
                                            <h1>Shop For
                                                Cutie Guys.</h1>
                                            <p>They know they're ugly. So what?
                                                Keep them with you. We don't want them.</p>
                                            <a href="category.php" class="btn_2">buy now</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="banner_img d-none d-lg-block">
                                    <img src="uglydolls/mygoats.jpg" alt="">
                                </div>
                            </div>
                        </div><div class="single_banner_slider">
                            <div class="row">
                                <div class="col-lg-5 col-md-8">
                                    <div class="banner_text">
                                        <div class="banner_text_iner">
                                            <h1>Truly
                                                Hideous.</h1>
                                            <p>They can do everything a regular doll can!
                                                They are just uglier.</p>
                                            <a href="category.php" class="btn_2">buy now</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="banner_img d-none d-lg-block">
                                    <img src="uglydolls/uglygamers.jpg" alt="">
                                </div>
                            </div>
                        </div><div class="single_banner_slider">
                            <div class="row">
                                <div class="col-lg-5 col-md-8">
                                    <div class="banner_text">
                                        <div class="banner_text_iner">
                                            <h1>BUY
                                                ME!!!</h1>
                                            <p>i figured out how 2 use html just so i could write this ...
                                                buy me now buy 20 of me buy me now</p>
                                            <a href="category.php" class="btn_2">buy now</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="banner_img d-none d-lg-block">
                                    <img src="uglydolls/hi.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slider-counter"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- product_list part start-->
<section class="product_list best_seller">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="section_tittle text-center">
                    <h2>Featured: Best Sellers <span>shop</span></h2>
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

    <!--::footer_part start::-->
    <footer class="footer_part">
        <div class="container">
            <div class="row justify-content-around">
                <div class="col-sm-6 col-lg-4">
                    <div class="single_footer_part">
                        <h4>Newsletter</h4>
                        <p>The harvest is bountiful this year! We thank our lucky stars
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
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Not really</a>
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
    <!-- custom js -->
    <script src="js/custom.js"></script>
</body>

</html>