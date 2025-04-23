<?php
include "include/header.php";
include "include/connection.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];


    $product_sql = "SELECT * FROM products WHERE id = $id ORDER BY id DESC";
    $product_sql_run = mysqli_query($conn, $product_sql);

?>




    <!-- ...:::: Start Breadcrumb Section:::... -->
    <div class="breadcrumb-section breadcrumb-bg-color--golden">
        <div class="breadcrumb-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="breadcrumb-title">Product Details - Variable</h3>
                        <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                            <nav aria-label="breadcrumb">
                                <ul>
                                    <li><a href="index.html">Home</a></li>
                                    <li><a href="shop-grid-sidebar-left.html">Shop</a></li>
                                    <li class="active" aria-current="page">Product Details Variable</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- ...:::: End Breadcrumb Section:::... -->

    <!-- Start Product Details Section -->
    <?php

    if (mysqli_num_rows($product_sql_run) > 0) {
        $product = mysqli_fetch_assoc($product_sql_run);




    ?>
        <div class="product-details-section">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-6">
                        <div class="product-details-gallery-area" data-aos="fade-up" data-aos-delay="0">
                            <!-- Start Large Image -->
                            <div class="product-large-image product-large-image-horaizontal swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="product-image-large-image swiper-slide zoom-image-hover img-responsive">
                                        <img src="../admin/<?php echo $product['image']; ?>" alt="">
                                    </div>
                                    <div class="product-image-large-image swiper-slide zoom-image-hover img-responsive">
                                        <img src="../admin/<?php echo $product['image1']; ?>" alt="">
                                    </div>
                                    <div class="product-image-large-image swiper-slide zoom-image-hover img-responsive">
                                        <img src="../admin/<?php echo $product['image2']; ?>" alt="">
                                    </div>
                                    <div class="product-image-large-image swiper-slide zoom-image-hover img-responsive">
                                        <img src="../admin/<?php echo $product['image3']; ?>" alt="">
                                    </div>

                                </div>
                            </div>
                            <!-- End Large Image -->
                            <!-- Start Thumbnail Image -->
                            <div
                                class="product-image-thumb product-image-thumb-horizontal swiper-container pos-relative mt-5">
                                <div class="swiper-wrapper">
                                    <div class="product-image-thumb-single swiper-slide">
                                        <img class="img-fluid" src="../admin/<?php echo $product['image']; ?>"
                                            alt="">
                                    </div>
                                    <div class="product-image-thumb-single swiper-slide">
                                        <img class="img-fluid" src="../admin/<?php echo $product['image1']; ?>"
                                            alt="">
                                    </div>
                                    <div class="product-image-thumb-single swiper-slide">
                                        <img class="img-fluid" src="../admin/<?php echo $product['image2']; ?>"
                                            alt="">
                                    </div>
                                    <div class="product-image-thumb-single swiper-slide">
                                        <img class="img-fluid" src="../admin/<?php echo $product['image3']; ?>"
                                            alt="">
                                    </div>

                                </div>
                                <!-- Add Arrows -->
                                <div class="gallery-thumb-arrow swiper-button-next"></div>
                                <div class="gallery-thumb-arrow swiper-button-prev"></div>
                            </div>
                            <!-- End Thumbnail Image -->
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-6">
                        <div class="product-details-content-area product-details--golden" data-aos="fade-up"
                            data-aos-delay="200">
                            <!-- Start  Product Details Text Area-->
                            <div class="product-details-text">
                                <h4 class="title"><?php echo $product['name']; ?></h4>
                                <div class="d-flex align-items-center">
                                    <?php
                                    // Fetch the rating value from the database
                                    $rating = $product['reviews']; // Assuming 'reviews' contains the rating value (e.g., 4 out of 5)
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
                                    <a href="#" class="customer-review ml-2">

                                        (customer review )</a>
                                </div>
                                <div class="price"> <span class="price"><del><?php echo $product['mrp_price']; ?></del>
                                        <?php echo $product['price']; ?>
                                    </span>
                                </div>
                                <p><?php echo $product['description']; ?></p>
                            </div> <!-- End  Product Details Text Area-->
                            <!-- Start Product Variable Area -->
                            <div class="product-details-variable">
                                <h4 class="title">Available Options</h4>
                                <!-- Product Variable Single Item -->
                                <div class="variable-single-item">
                                    <div class="product-stock"> <span class="product-stock-in"><i
                                                class="ion-checkmark-circled"></i></span><?php echo $product['stock']; ?></div>
                                </div>
                                <!-- Product Variable Single Item -->


                                <div class="d-flex align-items-center ">
                                    <div class="variable-single-item ">
                                        <span>Quantity</span>
                                        <div class="product-variable-quantity">
                                            <input min="1" max="100" value="1" type="number">
                                        </div>
                                    </div>

                                    <div class="product-add-to-cart-btn ">
                                        <!-- <a href="addToCart.php">+ Add To Cart</a> -->
                                        <a href="" class="cart-link" data-product-id="<?php echo $product['id']; ?>">
                                                       + Add To Cart
                                                </a>
                                    </div>
                                </div>
                                <!-- Start  Product Details Meta Area-->
                                <div class="product-details-meta mb-20">
                                    <a href="" class="icon-space-right wishlist-link" data-product-id="<?php echo $product['id']; ?>"><i class="icon-heart"></i>Add to
                                        wishlist</a>
                                    <!-- <a href="compare.html" class="icon-space-right"><i class="icon-refresh"></i>Compare</a> -->
                                </div> <!-- End  Product Details Meta Area-->
                            </div> <!-- End Product Variable Area -->

                            <!-- Start  Product Details Catagories Area-->
                            <div class="product-details-catagory mb-2">
                                <span class="title">CATEGORIES:</span>
                                <ul>
                                    <li><a href="#">BAR STOOL</a></li>
                                    <li><a href="#">KITCHEN UTENSILS</a></li>
                                    <li><a href="#">TENNIS</a></li>
                                </ul>
                            </div> <!-- End  Product Details Catagories Area-->


                            <!-- Start  Product Details Social Area-->
                            <div class="product-details-social">
                                <span class="title">SHARE THIS PRODUCT:</span>
                                <ul>
                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                </ul>
                            </div> <!-- End  Product Details Social Area-->
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- End Product Details Section -->

        <!-- Start Product Content Tab Section -->
        <div class="product-details-content-tab-section section-top-gap-100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="product-details-content-tab-wrapper" data-aos="fade-up" data-aos-delay="0">

                            <!-- Start Product Details Tab Button -->
                            <ul class="nav tablist product-details-content-tab-btn d-flex justify-content-center">
                                <li><a class="nav-link active" data-bs-toggle="tab" href="#description">
                                        Description
                                    </a>
                                </li>

                                <li><a class="nav-link" data-bs-toggle="tab" href="#review">
                                        Reviews (1)
                                    </a>
                                </li>
                            </ul> <!-- End Product Details Tab Button -->

                            <!-- Start Product Details Tab Content -->
                            <div class="product-details-content-tab">
                                <div class="tab-content">
                                    <!-- Start Product Details Tab Content Singel -->
                                    <div class="tab-pane active show" id="description">
                                        <div class="single-tab-content-item">
                                            <p><?php echo $product['long_description']; ?></p>
                                            <p><?php echo $product['long_description']; ?></p>
                                        </div>
                                    </div> <!-- End Product Details Tab Content Singel -->

                                    <!-- Start Product Details Tab Content Singel -->
                                    <div class="tab-pane" id="review">
                                        <div class="single-tab-content-item">
                                            <!-- Start - Review Comment -->
                                            <ul class="comment">
                                                <!-- Start - Review Comment list-->
                                                <li class="comment-list">
                                                    <div class="comment-wrapper">
                                                        <div class="comment-img">
                                                            <img src="assets/images/user/image-1.png" alt="">
                                                        </div>
                                                        <div class="comment-content">
                                                            <div class="comment-content-top">
                                                                <div class="comment-content-left">
                                                                    <h6 class="comment-name">Kaedyn Fraser</h6>
                                                                    <ul class="review-star">
                                                                        <li class="fill"><i class="ion-android-star"></i>
                                                                        </li>
                                                                        <li class="fill"><i class="ion-android-star"></i>
                                                                        </li>
                                                                        <li class="fill"><i class="ion-android-star"></i>
                                                                        </li>
                                                                        <li class="fill"><i class="ion-android-star"></i>
                                                                        </li>
                                                                        <li class="empty"><i class="ion-android-star"></i>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="comment-content-right">
                                                                    <a href="#"><i class="fa fa-reply"></i>Reply</a>
                                                                </div>
                                                            </div>

                                                            <div class="para-content">
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                                    Tempora inventore dolorem a unde modi iste odio amet,
                                                                    fugit fuga aliquam, voluptatem maiores animi dolor nulla
                                                                    magnam ea! Dignissimos aspernatur cumque nam quod sint
                                                                    provident modi alias culpa, inventore deserunt
                                                                    accusantium amet earum soluta consequatur quasi eum eius
                                                                    laboriosam, maiores praesentium explicabo enim dolores
                                                                    quaerat! Voluptas ad ullam quia odio sint sunt. Ipsam
                                                                    officia, saepe repellat. </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Start - Review Comment Reply-->
                                                    <ul class="comment-reply">
                                                        <li class="comment-reply-list">
                                                            <div class="comment-wrapper">
                                                                <div class="comment-img">
                                                                    <img src="assets/images/user/image-2.png" alt="">
                                                                </div>
                                                                <div class="comment-content">
                                                                    <div class="comment-content-top">
                                                                        <div class="comment-content-left">
                                                                            <h6 class="comment-name">Oaklee Odom</h6>
                                                                        </div>
                                                                        <div class="comment-content-right">
                                                                            <a href="#"><i class="fa fa-reply"></i>Reply</a>
                                                                        </div>
                                                                    </div>

                                                                    <div class="para-content">
                                                                        <p>Lorem ipsum dolor sit amet, consectetur
                                                                            adipisicing elit. Tempora inventore dolorem a
                                                                            unde modi iste odio amet, fugit fuga aliquam,
                                                                            voluptatem maiores animi dolor nulla magnam ea!
                                                                            Dignissimos aspernatur cumque nam quod sint
                                                                            provident modi alias culpa, inventore deserunt
                                                                            accusantium amet earum soluta consequatur quasi
                                                                            eum eius laboriosam, maiores praesentium
                                                                            explicabo enim dolores quaerat! Voluptas ad
                                                                            ullam quia odio sint sunt. Ipsam officia, saepe
                                                                            repellat. </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul> <!-- End - Review Comment Reply-->
                                                </li> <!-- End - Review Comment list-->
                                                <!-- Start - Review Comment list-->
                                                <li class="comment-list">
                                                    <div class="comment-wrapper">
                                                        <div class="comment-img">
                                                            <img src="assets/images/user/image-3.png" alt="">
                                                        </div>
                                                        <div class="comment-content">
                                                            <div class="comment-content-top">
                                                                <div class="comment-content-left">
                                                                    <h6 class="comment-name">Jaydin Jones</h6>
                                                                    <ul class="review-star">
                                                                        <li class="fill"><i class="ion-android-star"></i>
                                                                        </li>
                                                                        <li class="fill"><i class="ion-android-star"></i>
                                                                        </li>
                                                                        <li class="fill"><i class="ion-android-star"></i>
                                                                        </li>
                                                                        <li class="fill"><i class="ion-android-star"></i>
                                                                        </li>
                                                                        <li class="empty"><i class="ion-android-star"></i>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="comment-content-right">
                                                                    <a href="#"><i class="fa fa-reply"></i>Reply</a>
                                                                </div>
                                                            </div>

                                                            <div class="para-content">
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                                    Tempora inventore dolorem a unde modi iste odio amet,
                                                                    fugit fuga aliquam, voluptatem maiores animi dolor nulla
                                                                    magnam ea! Dignissimos aspernatur cumque nam quod sint
                                                                    provident modi alias culpa, inventore deserunt
                                                                    accusantium amet earum soluta consequatur quasi eum eius
                                                                    laboriosam, maiores praesentium explicabo enim dolores
                                                                    quaerat! Voluptas ad ullam quia odio sint sunt. Ipsam
                                                                    officia, saepe repellat. </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li> <!-- End - Review Comment list-->
                                            </ul> <!-- End - Review Comment -->
                                            <div class="review-form">
                                                <div class="review-form-text-top">
                                                    <h5>ADD A REVIEW</h5>
                                                    <p>Your email address will not be published. Required fields are marked
                                                        *</p>
                                                </div>

                                                <form action="#" method="post">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="default-form-box">
                                                                <label for="comment-name">Your name <span>*</span></label>
                                                                <input id="comment-name" type="text"
                                                                    placeholder="Enter your name" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="default-form-box">
                                                                <label for="comment-email">Your Email <span>*</span></label>
                                                                <input id="comment-email" type="email"
                                                                    placeholder="Enter your email" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="default-form-box">
                                                                <label for="comment-review-text">Your review
                                                                    <span>*</span></label>
                                                                <textarea id="comment-review-text"
                                                                    placeholder="Write a review" required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <button class="btn btn-md btn-black-default-hover"
                                                                type="submit">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Product Details Tab Content Singel -->
                                </div>
                            </div> <!-- End Product Details Tab Content -->

                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php
    }
}
?>
<!-- End Product Content Tab Section -->

<!-- Start Product Default Slider Section -->
<div class="product-default-slider-section section-top-gap-100 section-fluid">
    <!-- Start Section Content Text Area -->
    <div class="section-title-wrapper" data-aos="fade-up" data-aos-delay="0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-content-gap">
                        <div class="secton-content">
                            <h3 class="section-title">PRODUCTS</h3>

                            <p>Browse the collection of our products.</p>

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

                                $product_sql = "SELECT * FROM products ORDER BY reviews DESC";
                                $product_sql_run = mysqli_query($conn, $product_sql);

                                while ($products = mysqli_fetch_assoc($product_sql_run)) {

                                ?>

                                    <div class="product-default-single-item product-color--golden swiper-slide">
                                        <div class="image-box">
                                            <a href="product-details-default.html" class="image-link">
                                                <img src="../admin/<?php echo $products['image'] ?>" alt="">
                                                <img src="../admin/<?php echo $products['image'] ?>" alt="">
                                            </a>
                                            <div class="action-link">
                                                <div class="action-link-left">
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#modalAddcart">Add to Cart</a>
                                                </div>
                                                <div class="action-link-right">
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#modalQuickview"><i
                                                            class="icon-magnifier"></i></a>
                                                    <a href="wishlist.html"><i class="icon-heart"></i></a>
                                                    <a href="compare.html"><i class="icon-shuffle"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <div class="content-left">
                                                <h6 class="title"><a href="product-details-default.html"><?php echo $products['name'] ?></a></h6>
                                                <?php
                                                // Fetch the rating value from the database
                                                $rating = $product['reviews']; // Assuming 'reviews' contains the rating value (e.g., 4 out of 5)
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.cart-link').on('click', function(e) {
            e.preventDefault();
            var productId = $(this).data('product-id');
            // console.log('Product ID to send:', productId);
            $.ajax({
                url: 'cart.php',
                type: 'GET',
                data: { pid: productId },
                success: function(response) {

                    console.log('Product added to cart:', response);
                    window.location.href = 'cart.php?pid=' + productId;
                    location.reload(); 
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    });

    $(document).ready(function() {
        $('.wishlist-link').on('click', function(e) {
            e.preventDefault(); // Prevent the default link behavior

            var productId = $(this).data('product-id'); // Get the product ID from the data attribute

            // Send an AJAX request to wishlist.php
            $.ajax({
                url: 'wishlist.php',
                type: 'POST',
                data: {
                    id: productId
                }, // Send the product ID as POST data
                success: function(response) {
                    // Handle the response from wishlist.php
                    location.reload(); // Reload the page
                    console.log('Product added to wishlist:', response);
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error('Error:', error);
                }
            });
        });
    });
</script>


<?php include "include/footer.php" ?>