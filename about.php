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
              <h2>About</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
    <!-- breadcrumb start-->

	<!-- Start Sample Area -->
	<section class="sample-text-area">
		<div class="container box_1170">
			<h3 class="text-heading">Who are the Uglydolls</h3>
			<p>Uglydolls are the brainchild of <b>David Horvath and Sun-Min Kim</b>, a couple who met at art school in New York and fell in love. They started making and designing art and toys together, and one of their creations was a plush toy based on a character David drew on a letter to Sun-Min.</p>
        <p>That was the beginning of the Uglydolls, who made their debut in 2001. They published their first Uglydoll book, <em>Ugly Guide to the Uglyverse</em>, in 2008.</p>
        <p>The Uglydolls live in Ugly Town, where they have fun and adventures with their friends. Each Uglydoll has its own quirky traits and hobbies that make them special and adorable. Wage loves to work. Ice-Bat loves to chill. Jeero loves to worry. You name it. The Uglydolls are awesome!</p>
		</div>
	</section>
	<!-- End Sample Area -->

	<!-- Start Align Area -->
	<div class="whole-wrap">
		<div class="container box_1170">
			<div class="section-top-border">
				<h3 class="mb-30">The worst thing that has ever happened</h3>
				<div class="row">
					<div class="col-md-3">
						<img src="uglydolls/uglydollmovie.png" alt="" class="img-fluid">
					</div>
					<div class="col-md-9 mt-sm-20">
						<p>Uglydolls were once a charming and original toy line that celebrated diversity and individuality. They were created by a couple of artists who wanted to make something different and fun. They also had a series of books that explored their quirky world and personalities.</p>
                    <p>However, everything changed when the movie came out in 2019. The movie was a bland and generic musical that tried to cash in on the popularity of the toys. It had a clichéd plot, dull characters, and mediocre songs. It also contradicted the message of the toys by making them look cute and appealing, instead of ugly and unique.</p>
                    <p>The movie was a flop with critics and audiences, and it tarnished the reputation of the franchise. The Uglydolls still live on in our memories, but they will never be the same as they were before the movie.</p>
					</div>
				</div>
			</div>

	<!--::footer_part start::-->
	<footer class="footer_part">
		<div class="container">
			<div class="row justify-content-around">
				<div class="col-sm-6 col-lg-3">
					<div class="single_footer_part">
						<h4>About Us</h4>
						<p> Just a store, extremely dedicated to spreading awareness about how awesome Ugly Dolls are (or used to be).
						</p>
					</div>
				</div>
				<div class="col-sm-6 col-lg-3">
					<div class="single_footer_part">
						<h4>Newsletter</h4>
						<p>Heaven fruitful doesn't over lesser in days. Appear creeping seasons deve behold bearing days
							open
						</p>
						<div id="mc_embed_signup">
							<form target="_blank"
								action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01"
								method="get" class="subscribe_form relative mail_part">
								<input type="email" name="email" id="newsletter-form-email" placeholder="Email Address"
									class="placeholder hide-on-focus" onfocus="this.placeholder = ''"
									onblur="this.placeholder = ' Email Address '">
								<button type="submit" name="submit" id="newsletter-submit"
									class="email_icon newsletter-submit button-contactForm"><i
										class="far fa-paper-plane"></i></button>
								<div class="mt-10 info"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
        </div>
			<hr>
			<div class="row">
				<div class="col-lg-8">
					<div class="copyright_text">
						<P><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Not really </a>
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
	<!-- custom js -->
	<script src="js/custom.js"></script>
</body>

</html>