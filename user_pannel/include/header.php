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
                                        <!-- <a href="index.php">Categories <i class="fa fa-angle-down"></i></a> -->
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
                                    <span class="item-count">
                                        <?php
                                        if (!empty($_SESSION['user_id'])) {
                                            $user_id = $_SESSION['user_id'];

                                            // Query to count the number of wishlist items for the user
                                            $wishlist_count_sql = "SELECT COUNT(*) AS wishlist_count FROM wishlists WHERE user_id = $user_id";
                                            $wishlist_count_run = mysqli_query($conn, $wishlist_count_sql);

                                            if ($wishlist_count_run) {
                                                $wishlist_count_data = mysqli_fetch_assoc($wishlist_count_run);
                                                $wishlist_count = $wishlist_count_data['wishlist_count'];
                                                echo $wishlist_count; 
                                            } else {
                                                echo 0; 
                                            }
                                        } else {
                                            echo 0; 
                                        }
                                        ?>
                                    </span> <!-- Default value, will be updated by AJAX -->
                                </a>
                            </li>
                            <!-- <li>
                                <a href="#offcanvas-add-cart" class="offcanvas-toggle">
                                    <i class="icon-bag"></i>
                                    <span class="item-count">3</span>
                                </a>
                            </li> -->
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



    <!-- Start Offcanvas Wishlist Section -->
    <div id="offcanvas-wishlish" class="offcanvas offcanvas-rightside offcanvas-add-cart-section">
        <!-- Start Offcanvas Header -->
        <div class="offcanvas-header text-right">
            <button class="offcanvas-close"><i class="ion-android-close"></i></button>
        </div> <!-- ENd Offcanvas Header -->

        <!-- Start Offcanvas Mobile Menu Wrapper -->
        <div class="offcanvas-wishlist-wrapper">
            <h4 class="offcanvas-title">Wishlist</h4>
            <ul class="offcanvas-wishlist">
                <?php
                if (!empty($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];

                    // Prepare the SQL query
                    $wishlist_sql = "SELECT wishlists.wishlist_id, products.id, products.name AS product_name, products.image, products.price 
                    FROM wishlists
                    JOIN users ON wishlists.user_id = users.user_id
                    JOIN products ON wishlists.product_id = products.id
                    WHERE users.user_id = $user_id
                    ORDER BY wishlists.wishlist_id DESC
                    LIMIT 4";
                    $wishlist_sql_run = mysqli_query($conn, $wishlist_sql);

                    if (mysqli_num_rows($wishlist_sql_run) > 0) {
                        while ($row = mysqli_fetch_assoc($wishlist_sql_run)) {
                ?>
                            <li class="offcanvas-wishlist-item-single">
                                <div class="offcanvas-wishlist-item-block">
                                    <a href="productDetails.php?id=<?php echo $row['id']; ?>" class="offcanvas-wishlist-item-image-link">
                                        <img src="../admin/<?php echo $row['image']; ?>" alt="<?php echo $row['product_name']; ?>" class="offcanvas-wishlist-image">
                                    </a>
                                    <div class="offcanvas-wishlist-item-content">
                                        <a href="productDetails.php?id=<?php echo $row['id']; ?>" class="offcanvas-wishlist-item-link"><?php echo $row['product_name']; ?></a>
                                        <div class="offcanvas-wishlist-item-details">
                                            <span class="offcanvas-wishlist-item-details-quantity">1 x </span>
                                            <span class="offcanvas-wishlist-item-details-price">$<?php echo $row['price']; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="offcanvas-wishlist-item-delete text-right">
                                    <a href="wishlistDelete.php?id=<?php echo $row['wishlist_id']; ?>" class="offcanvas-wishlist-item-delete"><i class="fa fa-trash-o"></i></a>
                                </div>
                            </li>
                <?php
                        }
                    } else {
                        echo '<li>No items in your wishlist.</li>';
                    }
                } else {
                    echo '<li>Please log in to view your wishlist.</li>';
                }
                ?>
            </ul>
            <ul class="offcanvas-wishlist-action-button">
                <li><a href="wishlist.php" class="btn btn-block btn-golden">View wishlist</a></li>
            </ul>
        </div>
    </div>

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
                            <a href="#" class="offcanvas-cart-item-link">Stylish Chair</a>
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

    <!-- Start Offcanvas Search Bar Section -->
    <div id="search" class="search-modal">
        <button type="button" class="close">×</button>
        <form method="post" action="products.php" class="search-form">
            
            <input type="search"
                name="search"
                placeholder="Type keyword(s) here"
                value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>" />
            <button type="submit" name="search_submit" class="btn btn-lg btn-golden">Search</button>
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