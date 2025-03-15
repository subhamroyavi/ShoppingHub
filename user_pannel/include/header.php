<?php
session_start();
include 'connection.php';

$categories_sql = "SELECT * FROM categories";
$categories_run = mysqli_query($conn, $categories_sql);

if (mysqli_num_rows($categories_run) > 0) {
    $categories = mysqli_fetch_all($categories_run, MYSQLI_ASSOC);
    $_SESSION['categories'] = $categories;
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shopping Hub</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/logo/favicon-16x16.png" />

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/vendor/vendor.min.css">
    <link rel="stylesheet" href="assets/css/plugins/plugins.min.css">
    <link rel="stylesheet" href="assets/css/style.min.css">
    <link rel="stylesheet" href="assets/css/custom.css">
</head>

<body>
    <!-- Start Header Area -->
    <header class="header-section d-none d-xl-block">
        <div class="header-bottom header-bottom-color--golden section-fluid sticky-header sticky-color--golden">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 d-flex align-items-center justify-content-between">
                        <!-- Start Header Logo -->
                        <div class="header-logo">
                            <div class="logo">
                                <a href="index.php" class="d-flex align-items-center text-decoration-none">
                                    <img src="assets/images/logo/logo-icon-black.png" alt="Logo" class="logo-icon me-2">
                                    <h4 class="mb-0 fw-bold text-dark logo-text">
                                        <div class="brand-text text-start">
                                            <span class="d-block"><strong>Shopping</strong></span>
                                            <span class="d-block"><strong>Hub</strong></span>
                                        </div>
                                    </h4>
                                </a>
                            </div>
                        </div>
                        <!-- End Header Logo -->

                        <!-- Start Header Main Menu -->
                        <div class="main-menu menu-color--black menu-hover-color--golden">
                            <nav>
                                <ul>
                                    <li class="has-dropdown">
                                        <a class="active main-menu-link" href="index.php">Home</a>
                                    </li>

                                    <li class="has-dropdown has-megaitem">
                                        <a href="product-details-default.html">Shop <i class="fa fa-angle-down"></i></a>
                                        <!-- Mega Menu -->
                                        <div class="mega-menu container-fluid p-0">
                                            <div class="row">
                                                <?php
                                                if (!empty($categories) && is_array($categories)) {
                                                    foreach ($categories as $category) {
                                                        if (isset($category['c_name'])) {
                                                ?>
                                                            <ul lass="list-unstyled">
                                                                <h6 class="mega-menu-item-title mb-3">
                                                                    <li class="mb-2">
                                                                        <a href="#"><?php echo $category['c_name'] ?></a>
                                                                    </li>
                                                                </h6>
                                                            </ul>
                                                <?php
                                                        }
                                                    }
                                                } else {
                                                    echo '<div class="col-12 text-center py-4">No categories available.</div>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="products.php">Products</a>
                                    </li>

                                    <li>
                                        <a href="about-us.php">About Us</a>
                                    </li>
                                    <li>
                                        <a href="contact-us.php">Contact Us</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <!-- End Header Main Menu -->

                        <!-- Start Header Action Link -->
                        <ul class="header-action-link action-color--black action-hover-color--golden">
                            <li>
                                <a href="#offcanvas-wishlish" class="offcanvas-toggle">
                                    <i class="icon-heart"></i>
                                    <span class="item-count">3</span>
                                </a>
                            </li>
                            <li>
                                <a href="#offcanvas-add-cart" class="offcanvas-toggle">
                                    <i class="icon-bag"></i>
                                    <span class="item-count">3</span>
                                </a>
                            </li>
                            <li>
                                <a href="#search">
                                    <i class="icon-magnifier"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#offcanvas-about" class="offacnvas offside-about offcanvas-toggle">
                                    <i class="icon-menu"></i>
                                </a>
                            </li>
                        </ul>
                        <!-- End Header Action Link -->
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- End Header Area -->

    <!-- Start Mobile Header -->
    <div class="mobile-header mobile-header-bg-color--golden section-fluid d-lg-block d-xl-none">
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex align-items-center justify-content-between">
                    <!-- Start Mobile Left Side -->
                    <div class="mobile-header-left">
                        <ul class="mobile-menu-logo">
                            <li>
                                <a href="index.php">
                                    <div class="logo">
                                        <img src="assets/images/logo/logo-icon-black.png" alt="Logo" class="logo-icon me-2">
                                        <h4 class="mb-0 fw-bold text-light logo-text"><strong>Shopping Hub</strong></h4>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- End Mobile Left Side -->

                    <!-- Start Mobile Right Side -->
                    <div class="mobile-right-side">
                        <ul class="header-action-link action-color--black action-hover-color--golden">
                            <li>
                                <a href="#search">
                                    <i class="icon-magnifier"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#offcanvas-wishlish" class="offcanvas-toggle">
                                    <i class="icon-heart"></i>
                                    <span class="item-count">3</span>
                                </a>
                            </li>
                            <li>
                                <a href="#offcanvas-add-cart" class="offcanvas-toggle">
                                    <i class="icon-bag"></i>
                                    <span class="item-count">3</span>
                                </a>
                            </li>
                            <li>
                                <a href="#mobile-menu-offcanvas" class="offcanvas-toggle offside-menu">
                                    <i class="icon-menu"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- End Mobile Right Side -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Mobile Header -->

    <!-- Start Offcanvas Mobile Menu Section -->
    <div id="offcanvas-about" class="offcanvas offcanvas-rightside offcanvas-mobile-about-section">
        <div class="offcanvas-header text-right">
            <button class="offcanvas-close"><i class="ion-android-close"></i></button>
        </div>
        <div class="mobile-contact-info">
            <div class="logo text-center">
                <a href="index.php" class="d-flex align-items-center justify-content-center text-decoration-none">
                    <img src="assets/images/logo/logo-icon-black.png" alt="Logo" class="logo-icon me-2">
                    <h4 class="mb-0 fw-bold text-light logo-text">
                        <div class="brand-text text-start">
                            <span class="d-block"><strong>Shopping</strong></span>
                            <span class="d-block"><strong>Hub</strong></span>
                        </div>
                    </h4>
                </a>
            </div>

            <?php
            if (!empty($_SESSION['user_id'])) {
            ?>
                <address class="address">
                    <span>Email: <?php echo $_SESSION['user_email']; ?></span>
                    <span>Phone number: <?php echo $_SESSION['user_phone']; ?></span>
                </address>
                <ul class="social-link">
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                </ul>
                <ul class="user-link">
                    <li><a href="my_account.php">My Account</a></li>
                    <li><a href="log_out.php">Log out</a></li>
                </ul>
            <?php
            } else {
            ?>
                <address class="address">
                    <span>Hi! Welcome to Our Website</span>
                    <span>Email: demo@example.com</span>
                    <span>Call Us: 0123456789, 0123456789</span>
                </address>
                <ul class="social-link">
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                </ul>
                <ul class="user-link">
                    <li><a href="login.php">Login / Register</a></li>
                </ul>
            <?php
            }
            ?>
        </div>
    </div>
    <!-- End Offcanvas Mobile Menu Section -->

    <!-- Start Offcanvas Addcart Section -->
    <div id="offcanvas-add-cart" class="offcanvas offcanvas-rightside offcanvas-add-cart-section">
        <div class="offcanvas-header text-right">
            <button class="offcanvas-close"><i class="ion-android-close"></i></button>
        </div>
        <div class="offcanvas-add-cart-wrapper">
            <h4 class="offcanvas-title">Shopping Cart</h4>
            <ul class="offcanvas-cart">
                <li class="offcanvas-cart-item-single">
                    <div class="offcanvas-cart-item-block">
                        <a href="#" class="offcanvas-cart-item-image-link">
                            <img src="assets/images/product/default/home-1/default-1.jpg" alt="" class="offcanvas-cart-image">
                        </a>
                        <div class="offcanvas-cart-item-content">
                            <a href="#" class="offcanvas-cart-item-link">Car Wheel</a>
                            <div class="offcanvas-cart-item-details">
                                <span class="offcanvas-cart-item-details-quantity">1 x </span>
                                <span class="offcanvas-cart-item-details-price">$49.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="offcanvas-cart-item-delete text-right">
                        <a href="#" class="offcanvas-cart-item-delete"><i class="fa fa-trash-o"></i></a>
                    </div>
                </li>
            </ul>
            <div class="offcanvas-cart-total-price">
                <span class="offcanvas-cart-total-price-text">Subtotal:</span>
                <span class="offcanvas-cart-total-price-value">$170.00</span>
            </div>
            <ul class="offcanvas-cart-action-button">
                <li><a href="cart.html" class="btn btn-block btn-golden">View Cart</a></li>
                <li><a href="compare.html" class="btn btn-block btn-golden mt-5">Compare</a></li>
            </ul>
        </div>
    </div>
    <!-- End Offcanvas Addcart Section -->

    <!-- Start Offcanvas Wishlist Section -->
    <div id="offcanvas-wishlish" class="offcanvas offcanvas-rightside offcanvas-add-cart-section">
        <div class="offcanvas-header text-right">
            <button class="offcanvas-close"><i class="ion-android-close"></i></button>
        </div>
        <div class="offcanvas-wishlist-wrapper">
            <h4 class="offcanvas-title">Wishlist</h4>
            <ul class="offcanvas-wishlist">
                <li class="offcanvas-wishlist-item-single">
                    <div class="offcanvas-wishlist-item-block">
                        <a href="#" class="offcanvas-wishlist-item-image-link">
                            <img src="assets/images/product/default/home-1/default-1.jpg" alt="" class="offcanvas-wishlist-image">
                        </a>
                        <div class="offcanvas-wishlist-item-content">
                            <a href="#" class="offcanvas-wishlist-item-link">Car Wheel</a>
                            <div class="offcanvas-wishlist-item-details">
                                <span class="offcanvas-wishlist-item-details-quantity">1 x </span>
                                <span class="offcanvas-wishlist-item-details-price">$49.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="offcanvas-wishlist-item-delete text-right">
                        <a href="#" class="offcanvas-wishlist-item-delete"><i class="fa fa-trash-o"></i></a>
                    </div>
                </li>
            </ul>
            <ul class="offcanvas-wishlist-action-button">
                <li><a href="#" class="btn btn-block btn-golden">View Wishlist</a></li>
            </ul>
        </div>
    </div>
    <!-- End Offcanvas Wishlist Section -->

    <!-- Start Offcanvas Search Bar Section -->
    <div id="search" class="search-modal">
        <button type="button" class="close">×</button>
        <form method="post">
            <input type="search" placeholder="type keyword(s) here" />
            <a href="products.php" type="submit" class="btn btn-lg btn-golden">Search</a>
        </form>
    </div>
    <!-- End Offcanvas Search Bar Section -->

    <!-- Offcanvas Overlay -->
    <div class="offcanvas-overlay"></div>

    <!-- JS Files -->
    <script src="assets/js/vendor/vendor.min.js"></script>
    <script src="assets/js/plugins/plugins.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>