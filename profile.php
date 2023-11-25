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
                            <div class="dropdown cart">
                                <a class="dropdown-toggle" href="#" id="navbarDropdown3" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-cart-plus"></i>
                                </a>
                            </div>
                        </div>                        
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- Header part end-->
  <!--================End Home Banner Area =================-->

  <?php

// Connect to your database
$con=mysqli_connect("localhost","root","","uglydolls");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Get the user ID from the session
$id = $_SESSION['user_id'];

// Check if the forms were submitted and update the database accordingly
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['new_name'])) {
        $new_name = $_POST['new_name'];
        // Update the name in the database
        $query = "UPDATE usuario SET nombre = '$new_name' WHERE usernum = $id";
        $result = mysqli_query($con, $query);
        if ($result) {
            // Successful update
            $message = 'Name updated successfully';
        } else {
            // Unsuccessful update
            $message = 'Failed to update name';
        }
    } elseif (isset($_POST['new_email'])) {
        $new_email = $_POST['new_email'];
        // Update the email in the database
        $query = "UPDATE usuario SET correo = '$new_email' WHERE usernum = $id";
        $result = mysqli_query($con, $query);
        if ($result) {
            // Successful update
            $message = 'Email updated successfully';
        } else {
            // Unsuccessful update
            $message = 'Failed to update email';
        }
    } elseif (isset($_POST['new_password'])) {
        $new_password = $_POST['new_password'];
        // Update the password in the database
        $query = "UPDATE usuario SET contrasenia = '$new_password' WHERE usernum = $id";
        $result = mysqli_query($con, $query);
        if ($result) {
            // Successful update
            $message = 'Password updated successfully';
        } else {
            // Unsuccessful update
            $message = 'Failed to update password';
        }
    } elseif (isset($_POST['sign_out'])) {
        // Sign out
        session_destroy();
        header('Location: index.php');
        exit;
    } elseif (isset($_POST['delete_account'])) {
        // Delete the account
        $query = "DELETE FROM usuario WHERE usernum = $id";
        $result = mysqli_query($con, $query);
        session_destroy();
        header('Location: index.php');
        exit;
    }
}

// Fetch the user details from the database
$result = $con->query("SELECT * FROM usuario WHERE usernum = $id");

if ($result->num_rows > 0) {
    // Fetch the user details
    $row = $result->fetch_assoc();
?>

<!--================User Profile Area =================-->
<div class="user_profile_area section_padding">
    <div class="container">
        <div class="row s_user_profile_inner justify-content-between">
            <div class="col-lg-7 col-xl-7">
                <div class="user_profile_info">
                    <h3><span>Name: </span><?php echo $row['nombre']; ?> <a href="#" class="genric-btn default-border" onclick="document.getElementById('change_name_form').style.display='block'">Change</a></h3>
                    <form id="change_name_form" style="display: none;" action="profile.php" method="post">
                        <label for="new_name">New Name:</label>
                        <input type="text" id="new_name" name="new_name">
                        <input type="submit" value="Submit">
                    </form>

                    <h2><span>Email: </span><?php echo $row['correo']; ?> <a href="#" class="genric-btn default-border" onclick="document.getElementById('change_email_form').style.display='block'">Change</a></h2>
                    <form id="change_email_form" style="display: none;" action="profile.php" method="post">
                        <label for="new_email">New Email:</label>
                        <input type="text" id="new_email" name="new_email">
                        <input type="submit" value="Submit">
                    </form>

                    <p><span>Password: </span><?php echo $row['contrasenia']; ?> <a href="#" class="genric-btn default-border" onclick="document.getElementById('change_password_form').style.display='block'">Change</a></p>
                    <form id="change_password_form" style="display: none;" action="profile.php" method="post">
                        <label for="new_password">New Password:</label>
                        <input type="password" id="new_password" name="new_password">
                        <input type="submit" value="Submit">
                    </form>
                    <br>
                    <form action="profile.php" method="post">
                    <input type="submit" name="sign_out" value="Sign out" class="genric-btn primary-border e-large">
                    </form>
                    <br>
                    <form action="profile.php" method="post" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                        <input type="submit" name="delete_account" value="Delete account" class="genric-btn primary e-large">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--================End User Profile Area =================-->

<?php
} else {
    echo "User not found";
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