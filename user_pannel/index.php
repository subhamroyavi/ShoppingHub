<?php
include "include/header.php";
include "include/connection.php";
?>

<div class="hero-slider-section">
    <div class="hero-slider-active swiper-container">
        <div class="swiper-wrapper">
            <?php
            // Fetch carousel items
            $sql = "SELECT * FROM carousel WHERE status = 'active' ORDER BY id DESC";
            $sql_run = mysqli_query($conn, $sql);


            // Check if there are any carousel items

            if (mysqli_num_rows($sql_run) > 0) {
                while ($carousel_items = mysqli_fetch_assoc($sql_run)) {
                    // Ensure correct image path (modify if necessary)
                    // $image_url = "admin/" . htmlspecialchars($carousel_items['image']);
            ?>
                    <!-- Hero Single Slider Item -->
                    <div class="hero-single-slider-item swiper-slide">
                        <div class="hero-slider-bg">
                            <img src="../admin/<?php echo $carousel_items['image']; ?>" alt="<?php echo htmlspecialchars($carousel_items['title']); ?>">
                        </div>
                        <div class="hero-slider-wrapper">
                            <div class="container">
                                <div class="row">
                                    <div class="col-auto">
                                        <div class="hero-slider-content">
                                            <h1 class="subtitle"><?php echo $carousel_items['title']; ?></h1>
                                            <?php
                                            $subtitle = explode('from ', $carousel_items['subtitle'], 2); // Splits into 2 parts
                                            ?>
                                            <h2 class="title">
                                                <?php echo htmlspecialchars($subtitle[0]); ?><br>
                                                <?php echo isset($subtitle[1]) ? htmlspecialchars($subtitle[1]) : ''; ?>
                                            </h2>
                                            <a href="product-details-default.html" class="btn btn-lg btn-outline-golden">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Hero Single Slider Item -->
                <?php } ?>
        </div>
        <!-- Swiper Controls -->
        <div class="swiper-pagination active-color-golden"></div>
        <div class="swiper-button-prev d-none d-lg-block"></div>
        <div class="swiper-button-next d-none d-lg-block"></div>
    </div>
</div>
<?php
            } else {
                echo "<p>No carousel items found.</p>";
            }
?>
<!-- End Hero Slider Section-->
<!-- Start Service Section -->
<div class="service-promo-section section-top-gap-100">
    <div class="service-wrapper">
        <div class="container">
            <div class="row">
                <!-- Start Service Promo Single Item -->
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="service-promo-single-item" data-aos="fade-up" data-aos-delay="0">
                        <div class="image">
                            <img src="assets/images/icons/service-promo-1.png" alt="">
                        </div>
                        <div class="content">
                            <h6 class="title">FREE SHIPPING</h6>
                            <p>Get 10% cash back, free shipping, free returns, and more at 1000+ top retailers!</p>
                        </div>
                    </div>
                </div>
                <!-- End Service Promo Single Item -->
                <!-- Start Service Promo Single Item -->
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="service-promo-single-item" data-aos="fade-up" data-aos-delay="200">
                        <div class="image">
                            <img src="assets/images/icons/service-promo-2.png" alt="">
                        </div>
                        <div class="content">
                            <h6 class="title">30 DAYS MONEY BACK</h6>
                            <p>100% satisfaction guaranteed, or get your money back within 30 days!</p>
                        </div>
                    </div>
                </div>
                <!-- End Service Promo Single Item -->
                <!-- Start Service Promo Single Item -->
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="service-promo-single-item" data-aos="fade-up" data-aos-delay="400">
                        <div class="image">
                            <img src="assets/images/icons/service-promo-3.png" alt="">
                        </div>
                        <div class="content">
                            <h6 class="title">SAFE PAYMENT</h6>
                            <p>Pay with the world’s most popular and secure payment methods.</p>
                        </div>
                    </div>
                </div>
                <!-- End Service Promo Single Item -->
                <!-- Start Service Promo Single Item -->
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="service-promo-single-item" data-aos="fade-up" data-aos-delay="600">
                        <div class="image">
                            <img src="assets/images/icons/service-promo-4.png" alt="">
                        </div>
                        <div class="content">
                            <h6 class="title">LOYALTY CUSTOMER</h6>
                            <p>Card for the other 30% of their purchases at a rate of 1% cash back.</p>
                        </div>
                    </div>
                </div>
                <!-- End Service Promo Single Item -->
            </div>
        </div>
    </div>
</div>
<!-- End Service Section -->

<!-- Start Banner Section -->
<div class="banner-section section-top-gap-100 section-fluid">
    <div class="banner-wrapper">
        <div class="container-fluid">
            <div class="row mb-n6">

                <div class="col-lg-6 col-12 mb-6">
                    <!-- Start Banner Single Item -->
                    <div class="banner-single-item banner-style-1 banner-animation img-responsive"
                        data-aos="fade-up" data-aos-delay="0">
                        <div class="image">
                            <img src="assets/images/banner/banner-style-1-img-1.jpg" alt="">
                        </div>
                        <div class="content">
                            <h4 class="title">Mini rechargeable
                                Table Lamp - E216</h4>
                            <h5 class="sub-title">We design your home</h5>
                            <a href="product-details-default.html"
                                class="btn btn-lg btn-outline-golden icon-space-left"><span
                                    class="d-flex align-items-center">discover now <i
                                        class="ion-ios-arrow-thin-right"></i></span></a>
                        </div>
                    </div>
                    <!-- End Banner Single Item -->
                </div>

                <div class="col-lg-6 col-12 mb-6">
                    <div class="row mb-n6">
                        <!-- Start Banner Single Item -->
                        <div class="col-lg-6 col-sm-6 mb-6">
                            <div class="banner-single-item banner-style-2 banner-animation img-responsive"
                                data-aos="fade-up" data-aos-delay="0">
                                <div class="image">
                                    <img src="assets/images/banner/banner-style-2-img-1.jpg" alt="">
                                </div>
                                <div class="content">
                                    <h4 class="title">Kitchen <br>
                                        utensils</h4>
                                    <a href="product-details-default.html" class="link-text"><span>Shop
                                            now</span></a>
                                </div>
                            </div>
                        </div>
                        <!-- End Banner Single Item -->
                        <!-- Start Banner Single Item -->
                        <div class="col-lg-6 col-sm-6 mb-6">
                            <div class="banner-single-item banner-style-2 banner-animation img-responsive"
                                data-aos="fade-up" data-aos-delay="200">
                                <div class="image">
                                    <img src="assets/images/banner/banner-style-2-img-2.jpg" alt="">
                                </div>
                                <div class="content">
                                    <h4 class="title">Sofas and <br>
                                        Armchairs</h4>
                                    <a href="product-details-default.html" class="link-text"><span>Shop
                                            now</span></a>
                                </div>
                            </div>
                        </div>
                        <!-- End Banner Single Item -->
                        <!-- Start Banner Single Item -->
                        <div class="col-lg-6 col-sm-6 mb-6">
                            <div class="banner-single-item banner-style-2 banner-animation img-responsive"
                                data-aos="fade-up" data-aos-delay="0">
                                <div class="image">
                                    <img src="assets/images/banner/banner-style-2-img-3.jpg" alt="">
                                </div>
                                <div class="content">
                                    <h4 class="title">Chair & Bar<br>
                                        stools</h4>
                                    <a href="product-details-default.html" class="link-text"><span>Shop
                                            now</span></a>
                                </div>
                            </div>
                        </div>
                        <!-- End Banner Single Item -->
                        <!-- Start Banner Single Item -->
                        <div class="col-lg-6 col-sm-6 mb-6">
                            <div class="banner-single-item banner-style-2 banner-animation img-responsive"
                                data-aos="fade-up" data-aos-delay="200">
                                <div class="image">
                                    <img src="assets/images/banner/banner-style-2-img-4.jpg" alt="">
                                </div>
                                <div class="content">
                                    <h4>Interior <br>
                                        lighting</h4>
                                    <a href="product-details-default.html"><span>Shop now</span></a>
                                </div>
                            </div>
                        </div>
                        <!-- End Banner Single Item -->
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Banner Section -->

<!-- Start Product Default Slider Section -->
<div class="product-default-slider-section section-top-gap-100 section-fluid">
    <!-- Start Section Content Text Area -->
    <div class="section-title-wrapper" data-aos="fade-up" data-aos-delay="0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-content-gap">
                        <div class="secton-content">
                            <h3 class="section-title">THE NEW ARRIVALS</h3>
                            <p>Preorder now to receive exclusive deals & gifts</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Start Section Content Text Area -->
    <div class="product-wrapper" data-aos="fade-up" data-aos-delay="200">
        <div class="container">
            <div class="row">

                <div class="col-12">
                    <div class="product-slider-default-2rows default-slider-nav-arrow">
                        <!-- Slider main container -->
                        <div class="swiper-container product-default-slider-4grid-2row">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">
                                <?php
                                $product_sql = "SELECT * FROM products WHERE status = 'active' ORDER BY id DESC";
                                $product_sql_run = mysqli_query($conn, $product_sql);

                                if (mysqli_num_rows($product_sql_run) > 0) {
                                    while ($products = mysqli_fetch_assoc($product_sql_run)) {

                                ?>

                                        <!-- Start Product Default Single Item -->
                                        <div class="product-default-single-item product-color--golden swiper-slide">
                                            <div class="image-box">
                                                <a href="productDetails.php?id=<?php echo $products['id'] ?>" class="image-link">
                                                    <img src="../admin/<?php echo $products['image']; ?>" alt="">
                                                    <img src="../admin/<?php echo $products['image1']; ?>" alt="">
                                                </a>
                                                <div class="tag">
                                                    <span>sale</span>
                                                </div>
                                                <div class="action-link">
                                                    <div class="action-link-left">
                                                        <a href="cart.php?id=<?php echo $products['id'] ?>" data-bs-toggle="modal"
                                                            data-bs-target="#modalAddcart">Add to Cart</a>
                                                    </div>
                                                    <div class="action-link-right">
                                                        <a href="productDetails.php?id=<?php echo $products['id'] ?>"><i
                                                                class="icon-magnifier"></i></a>
                                                        <a href="wishlist.html"><i class="icon-heart"></i></a>
                                                        <a href="compare.html"><i class="icon-shuffle"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <div class="content-left">
                                                    <h6 class="title"><a href="productDetails.php?id=<?php echo $products['id'] ?>">
                                                            <?php echo $products['name']; ?>
                                                        </a>
                                                    </h6>
                                                    <?php
                                                    // Fetch the rating value from the database
                                                    $rating = $products['reviews']; // Assuming 'reviews' contains the rating value (e.g., 4 out of 5)
                                                    ?>

                                                    <ul class="review-star">
                                                        <?php
                                                        // Generate filled stars
                                                        for ($i = 1; $i <= 5; $i++) {
                                                            if ($i <= $rating) {
                                                                echo '<li class="fill"><i class="fa fa-star"></i></li>';
                                                            } else {
                                                                echo '<li class="empty"><i class="fa fa-star"></i></li>';
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                                <div class="content-right">
                                                    <span class="price"><del><?php echo $products['mrp_price']; ?></del><?php echo $products['price']; ?></span>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- End Product Default Single Item -->
                                <?php
                                    }
                                }
                                ?>


                            </div>
                        </div>
                        <!-- If we need navigation buttons -->
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Product Default Slider Section -->

<!-- Start Banner Section -->
<div class="banner-section section-top-gap-100">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 offset-xl-2">
                <!-- Start Banner Single Item -->
                <div class="banner-single-item banner-style-3 banner-animation img-responsive" data-aos="fade-up"
                    data-aos-delay="0">
                    <div class="image">
                        <img class="img-fluid" src="assets/images/banner/banner-style-3-img-1.jpg" alt="">
                    </div>
                    <div class="content">
                        <h3 class="title">Modern Furniture
                            Basic Collection</h3>
                        <h5 class="sub-title">We design your home more beautiful</h5>
                        <a href="product-details-default.html"
                            class="btn btn-lg btn-outline-golden icon-space-left"><span
                                class="d-flex align-items-center">discover now <i
                                    class="ion-ios-arrow-thin-right"></i></span></a>
                    </div>
                </div>
                <!-- End Banner Single Item -->
            </div>
        </div>
    </div>
</div>
<!-- End Banner Section -->

<!-- Start Product Default Slider Section -->
<div class="product-default-slider-section section-top-gap-100 section-fluid section-inner-bg">
    <!-- Start Section Content Text Area -->
    <div class="section-title-wrapper" data-aos="fade-up" data-aos-delay="0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-content-gap">
                        <div class="secton-content">
                            <h3 class="section-title">BEST SELLERS</h3>
                            <p>Add our best sellers to your weekly lineup.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Start Section Content Text Area -->
    <div class="product-wrapper" data-aos="fade-up" data-aos-delay="0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product-slider-default-1row default-slider-nav-arrow">
                        <!-- Slider main container -->
                        <div class="swiper-container product-default-slider-4grid-1row">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">
                                <!-- End Product Default Single Item -->
                                <!-- Start Product Default Single Item -->
                                <?php

                                $product_sql = "SELECT * FROM products WHERE status = 'active' ORDER BY id ASC";
                                $product_sql_run = mysqli_query($conn, $product_sql);

                                if (mysqli_num_rows($product_sql_run) > 0) {
                                    while ($products = mysqli_fetch_assoc($product_sql_run)) {
                                ?>
                                        <div class="product-default-single-item product-color--golden swiper-slide">
                                            <div class="image-box">
                                                <a href="productDetails.php?id=<?php echo $products['id'] ?>" class="image-link">
                                                    <img src="../admin/<?php echo $products['image'] ?>" alt="<?php echo $products['name'] ?>">
                                                    <img src="../admin/<?php echo $products['image1'] ?>" alt="<?php echo $products['name'] ?>">
                                                </a>
                                                <div class="action-link">
                                                    <div class="action-link-left">
                                                        <a href="cart.php?id=<?php echo $products['id'] ?>" data-bs-toggle="modal"
                                                            data-bs-target="#modalAddcart">Add to Cart</a>
                                                    </div>
                                                    <div class="action-link-right">
                                                        <a href="productDetails.php?id=<?php echo $products['id'] ?>"><i
                                                                class="icon-magnifier"></i></a>
                                                        <a href="wishlist.html"><i class="icon-heart"></i></a>
                                                        <a href="compare.html"><i class="icon-shuffle"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <div class="content-left">
                                                    <h6 class="title"><a href="productDetails.php?id=<?php echo $products['id'] ?>"><?php echo $products['name'] ?></a></h6>

                                                    <?php
                                                    // Fetch the rating value from the database
                                                    $rating = $products['reviews']; // Assuming 'reviews' contains the rating value (e.g., 4 out of 5)
                                                    ?>

                                                    <ul class="review-star">
                                                        <?php
                                                        // Generate filled stars
                                                        for ($i = 1; $i <= 5; $i++) {
                                                            if ($i <= $rating) {
                                                                echo '<li class="fill"><i class="fa fa-star"></i></li>';
                                                            } else {
                                                                echo '<li class="empty"><i class="fa fa-star"></i></li>';
                                                            }
                                                        }
                                                        ?>
                                                    </ul>


                                                </div>
                                                <div class="content-right">
                                                    <span class="price"><del><?php echo $products['mrp_price']; ?></del><?php echo $products['price']; ?></span>

                                                </div>

                                            </div>
                                        </div>
                                <?php
                                    }
                                }

                                ?>
                                <!-- End Product Default Single Item -->

                            </div>
                        </div>
                        <!-- If we need navigation buttons -->
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Product Default Slider Section -->




<!-- Start Instagramr Section -->
<div class="instagram-section section-top-gap-100 section-inner-bg">
    <div class="instagram-wrapper" data-aos="fade-up" data-aos-delay="0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="instagram-box">
                        <div id="instagramFeed" class="instagram-grid clearfix">
                            <a href="https://www.instagram.com/p/CCFOZKDDS6S/" target="_blank"
                                class="instagram-image-link float-left banner-animation"><img
                                    src="assets/images/instagram/instagram-1.jpg" alt=""></a>
                            <a href="https://www.instagram.com/p/CCFOYDNjWF5/" target="_blank"
                                class="instagram-image-link float-left banner-animation"><img
                                    src="assets/images/instagram/instagram-2.jpg" alt=""></a>
                            <a href="https://www.instagram.com/p/CCFOXH6D-zQ/" target="_blank"
                                class="instagram-image-link float-left banner-animation"><img
                                    src="assets/images/instagram/instagram-3.jpg" alt=""></a>
                            <a href="https://www.instagram.com/p/CCFOVcrDDOo/" target="_blank"
                                class="instagram-image-link float-left banner-animation"><img
                                    src="assets/images/instagram/instagram-4.jpg" alt=""></a>
                            <a href="https://www.instagram.com/p/CCFOUajjABP/" target="_blank"
                                class="instagram-image-link float-left banner-animation"><img
                                    src="assets/images/instagram/instagram-5.jpg" alt=""></a>
                            <a href="https://www.instagram.com/p/CCFOS2MDmjj/" target="_blank"
                                class="instagram-image-link float-left banner-animation"><img
                                    src="assets/images/instagram/instagram-6.jpg" alt=""></a>
                        </div>
                        <div class="instagram-link">
                            <h5><a href="https://www.instagram.com/myfurniturecom/" target="_blank"
                                    rel="noopener noreferrer">HONOTEMPLATE</a></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Instagramr Section -->
<!-- Include Swiper JS and CSS -->



<?php include "include/footer.php" ?>