<?php
include 'connection.php';

$result = mysqli_query($conn, "SELECT * FROM categories");
if(mysqli_num_rows($result) > 0){

    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<!-- Start Footer Section -->
<footer class="footer-section footer-bg section-top-gap-100">
    <div class="footer-wrapper">
        <!-- Start Footer Top -->
        <div class="footer-top">
            <div class="container">
                <div class="row mb-n6">
                    <div class="col-lg-3 col-sm-6 mb-6">
                        <!-- Start Footer Single Item -->
                        <div class="footer-widget-single-item footer-widget-color--golden" data-aos="fade-up"
                            data-aos-delay="0">
                            <h5 class="title">INFORMATION</h5>
                            <ul class="footer-nav">
                                <li><a href="terms_condition.php">Terms & Conditions</a></li>
                                <li><a href="contact-us.php">Contact</a></li>
                                <li><a href="about-us.php">About Us</a></li>
                            </ul>
                        </div>
                        <!-- End Footer Single Item -->
                    </div>
                    <div class="col-lg-3 col-sm-6 mb-6">
                        <!-- Start Footer Single Item -->
                        <div class="footer-widget-single-item footer-widget-color--golden" data-aos="fade-up"
                            data-aos-delay="200">
                            <h5 class="title">MY ACCOUNT</h5>
                            <ul class="footer-nav">
                                <li><a href="my_account.php">My account</a></li>
                                <li><a href="wishlist.php">Wishlist</a></li>
                                <li><a href="#">Order History</a></li>
                            </ul>
                        </div>
                        <!-- End Footer Single Item -->
                    </div>
                    <div class="col-lg-3 col-sm-6 mb-6">
                        <!-- Start Footer Single Item -->
                        <div class="footer-widget-single-item footer-widget-color--golden" data-aos="fade-up"
                            data-aos-delay="400">
                            <h5 class="title">CATEGORIES</h5>
                            <ul class="footer-nav">
                                <?php
                                  if (!empty($rows) && is_array($rows)) {
                                    foreach ($rows as $row) {
                                ?>
                                    <li><a href="#"><?php echo $row['c_name'] ?></a></li>
                                <?php
                                }
                            }
                                ?>
                                <!-- <li><a href="#">Decorative</a></li>
                                    <li><a href="#">Kitchen utensils</a></li>
                                    <li><a href="#">Chair & Bar stools</a></li>
                                    <li><a href="#">Sofas and Armchairs</a></li>
                                    <li><a href="#">Interior lighting</a></li> -->
                            </ul>
                        </div>
                        <!-- End Footer Single Item -->
                    </div>
                    <div class="col-lg-3 col-sm-6 mb-6">
                        <!-- Start Footer Single Item -->
                        <div class="footer-widget-single-item footer-widget-color--golden" data-aos="fade-up"
                            data-aos-delay="600">
                            <h5 class="title">ABOUT US</h5>
                            <div class="footer-about">
                                <p>Shopping Hub is your go-to online store for electronics, cosmetics, jewelry, and home essentials. Enjoy a seamless experience with a user-friendly interface, secure payments, and fast delivery. Discover top brands, exclusive deals, and great prices—all in one place. Shop smart with Shopping Hub!
                                <address class="address">
                                    <span>Address: Cooch Behar, West Bengal.</span>
                                    <span>Email: shoppinghub@gmail.com</span>
                                </address>
                            </div>
                        </div>
                        <!-- End Footer Single Item -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer Top -->

        <!-- Start Footer Center -->
        <div class="footer-center">
            <div class="container">
                <div class="row mb-n6">
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-6">
                        <div class="footer-social" data-aos="fade-up" data-aos-delay="0">
                            <h4 class="title">FOLLOW US</h4>
                            <ul class="footer-social-link">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-6 col-md-6 mb-6">
                        <div class="footer-newsletter" data-aos="fade-up" data-aos-delay="200">
                            <h4 class="title">DON'T MISS OUT ON THE LATEST</h4>
                            <div class="form-newsletter">
                                <form action="#" method="post">
                                    <div class="form-fild-newsletter-single-item input-color--golden">
                                        <input type="email" placeholder="Your email address..." required>
                                        <button type="submit">SUBSCRIBE!</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Start Footer Center -->

        <!-- Start Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div
                    class="row justify-content-between align-items-center align-items-center flex-column flex-md-row mb-n6">
                    <div class="col-auto mb-6">
                        <div class="footer-copyright">
                            <p class="copyright-text">&copy; 2025 <a href="index.php">Shopping Hub</a>. Made with <i
                                    class="fa fa-heart text-danger"></i> by <a href="index.php"
                                    target="_blank">Shopping Hub</a> </p>

                        </div>
                    </div>
                    <div class="col-auto mb-6">
                        <div class="footer-payment">
                            <div class="image">
                                <img src="assets/images/company-logo/payment.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Start Footer Bottom -->
    </div>
</footer>
<!-- End Footer Section -->

<!-- material-scrolltop button -->
<button class="material-scrolltop" type="button"></button>

<!-- Start Modal Add cart -->
<div class="modal fade" id="modalAddcart" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col text-right">
                            <button type="button" class="close modal-close" data-bs-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true"> <i class="fa fa-times"></i></span>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="modal-add-cart-product-img">
                                        <img class="img-fluid"
                                            src="assets/images/product/default/home-1/default-1.jpg" alt="">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="modal-add-cart-info"><i class="fa fa-check-square"></i>Added to cart
                                        successfully!</div>
                                    <div class="modal-add-cart-product-cart-buttons">
                                        <a href="cart.html">View Cart</a>
                                        <a href="checkout.html">Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 modal-border">
                            <ul class="modal-add-cart-product-shipping-info">
                                <li> <strong><i class="icon-shopping-cart"></i> There Are 5 Items In Your
                                        Cart.</strong></li>
                                <li> <strong>TOTAL PRICE: </strong> <span>$187.00</span></li>
                                <li class="modal-continue-button"><a href="#" data-bs-dismiss="modal">CONTINUE
                                        SHOPPING</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End Modal Add cart -->

<!-- Start Modal Quickview cart -->
<div class="modal fade" id="modalQuickview" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col text-right">
                            <button type="button" class="close modal-close" data-bs-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true"> <i class="fa fa-times"></i></span>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="product-details-gallery-area mb-7">
                                <!-- Start Large Image -->
                                <div class="product-large-image modal-product-image-large swiper-container">
                                    <div class="swiper-wrapper">
                                        <div class="product-image-large-image swiper-slide img-responsive">
                                            <img src="assets/images/product/default/home-1/default-1.jpg" alt="">
                                        </div>
                                        <div class="product-image-large-image swiper-slide img-responsive">
                                            <img src="assets/images/product/default/home-1/default-2.jpg" alt="">
                                        </div>
                                        <div class="product-image-large-image swiper-slide img-responsive">
                                            <img src="assets/images/product/default/home-1/default-3.jpg" alt="">
                                        </div>
                                        <div class="product-image-large-image swiper-slide img-responsive">
                                            <img src="assets/images/product/default/home-1/default-4.jpg" alt="">
                                        </div>
                                        <div class="product-image-large-image swiper-slide img-responsive">
                                            <img src="assets/images/product/default/home-1/default-5.jpg" alt="">
                                        </div>
                                        <div class="product-image-large-image swiper-slide img-responsive">
                                            <img src="assets/images/product/default/home-1/default-6.jpg" alt="">
                                        </div>
                                    </div>
                                </div>
                                <!-- End Large Image -->
                                <!-- Start Thumbnail Image -->
                                <div
                                    class="product-image-thumb modal-product-image-thumb swiper-container pos-relative mt-5">
                                    <div class="swiper-wrapper">
                                        <div class="product-image-thumb-single swiper-slide">
                                            <img class="img-fluid"
                                                src="assets/images/product/default/home-1/default-1.jpg" alt="">
                                        </div>
                                        <div class="product-image-thumb-single swiper-slide">
                                            <img class="img-fluid"
                                                src="assets/images/product/default/home-1/default-2.jpg" alt="">
                                        </div>
                                        <div class="product-image-thumb-single swiper-slide">
                                            <img class="img-fluid"
                                                src="assets/images/product/default/home-1/default-3.jpg" alt="">
                                        </div>
                                        <div class="product-image-thumb-single swiper-slide">
                                            <img class="img-fluid"
                                                src="assets/images/product/default/home-1/default-4.jpg" alt="">
                                        </div>
                                        <div class="product-image-thumb-single swiper-slide">
                                            <img class="img-fluid"
                                                src="assets/images/product/default/home-1/default-5.jpg" alt="">
                                        </div>
                                        <div class="product-image-thumb-single swiper-slide">
                                            <img class="img-fluid"
                                                src="assets/images/product/default/home-1/default-6.jpg" alt="">
                                        </div>
                                    </div>
                                    <!-- Add Arrows -->
                                    <div class="gallery-thumb-arrow swiper-button-next"></div>
                                    <div class="gallery-thumb-arrow swiper-button-prev"></div>
                                </div>
                                <!-- End Thumbnail Image -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="modal-product-details-content-area">
                                <!-- Start  Product Details Text Area-->
                                <div class="product-details-text">
                                    <h4 class="title">Nonstick Dishwasher PFOA</h4>
                                    <div class="price"><del>$70.00</del>$80.00</div>
                                </div> <!-- End  Product Details Text Area-->
                                <!-- Start Product Variable Area -->
                                <div class="product-details-variable">
                                    <!-- Product Variable Single Item -->
                                    <div class="variable-single-item">
                                        <span>Color</span>
                                        <div class="product-variable-color">
                                            <label for="modal-product-color-red">
                                                <input name="modal-product-color" id="modal-product-color-red"
                                                    class="color-select" type="radio" checked>
                                                <span class="product-color-red"></span>
                                            </label>
                                            <label for="modal-product-color-tomato">
                                                <input name="modal-product-color" id="modal-product-color-tomato"
                                                    class="color-select" type="radio">
                                                <span class="product-color-tomato"></span>
                                            </label>
                                            <label for="modal-product-color-green">
                                                <input name="modal-product-color" id="modal-product-color-green"
                                                    class="color-select" type="radio">
                                                <span class="product-color-green"></span>
                                            </label>
                                            <label for="modal-product-color-light-green">
                                                <input name="modal-product-color"
                                                    id="modal-product-color-light-green" class="color-select"
                                                    type="radio">
                                                <span class="product-color-light-green"></span>
                                            </label>
                                            <label for="modal-product-color-blue">
                                                <input name="modal-product-color" id="modal-product-color-blue"
                                                    class="color-select" type="radio">
                                                <span class="product-color-blue"></span>
                                            </label>
                                            <label for="modal-product-color-light-blue">
                                                <input name="modal-product-color"
                                                    id="modal-product-color-light-blue" class="color-select"
                                                    type="radio">
                                                <span class="product-color-light-blue"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- Product Variable Single Item -->
                                    <div class="d-flex align-items-center flex-wrap">
                                        <div class="variable-single-item ">
                                            <span>Quantity</span>
                                            <div class="product-variable-quantity">
                                                <input min="1" max="100" value="1" type="number">
                                            </div>
                                        </div>

                                        <div class="product-add-to-cart-btn">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalAddcart">Add To
                                                Cart</a>
                                        </div>
                                    </div>
                                </div> <!-- End Product Variable Area -->
                                <div class="modal-product-about-text">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia iste
                                        laborum ad impedit pariatur esse optio tempora sint ullam autem deleniti nam
                                        in quos qui nemo ipsum numquam, reiciendis maiores quidem aperiam, rerum vel
                                        recusandae</p>
                                </div>
                                <!-- Start  Product Details Social Area-->
                                <div class="modal-product-details-social">
                                    <span class="title">SHARE THIS PRODUCT</span>
                                    <ul>
                                        <li><a href="#" class="facebook"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#" class="twitter"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#" class="pinterest"><i class="fa fa-pinterest"></i></a></li>
                                        <li><a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a>
                                        </li>
                                        <li><a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a></li>
                                    </ul>

                                </div> <!-- End  Product Details Social Area-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End Modal Quickview cart -->

<!-- ::::::::::::::All JS Files here :::::::::::::: -->
<!-- Global Vendor, plugins JS -->
<!-- <script src="assets/js/vendor/modernizr-3.11.2.min.js"></script>
    <script src="assets/js/vendor/jquery-3.5.1.min.js"></script>
    <script src="assets/js/vendor/jquery-migrate-3.3.0.min.js"></script>
    <script src="assets/js/vendor/popper.min.js"></script>
    <script src="assets/js/vendor/bootstrap.min.js"></script>
    <script src="assets/js/vendor/jquery-ui.min.js"></script>  -->

<!--Plugins JS-->
<!-- <script src="assets/js/plugins/swiper-bundle.min.js"></script>
    <script src="assets/js/plugins/material-scrolltop.js"></script>
    <script src="assets/js/plugins/jquery.nice-select.min.js"></script>
    <script src="assets/js/plugins/jquery.zoom.min.js"></script>
    <script src="assets/js/plugins/venobox.min.js"></script>
    <script src="assets/js/plugins/jquery.waypoints.js"></script>
    <script src="assets/js/plugins/jquery.lineProgressbar.js"></script>
    <script src="assets/js/plugins/aos.min.js"></script>
    <script src="assets/js/plugins/jquery.instagramFeed.js"></script>
    <script src="assets/js/plugins/ajax-mail.js"></script> -->

<!-- Use the minified version files listed below for better performance and remove the files listed above -->
<script src="assets/js/vendor/vendor.min.js"></script>
<script src="assets/js/plugins/plugins.min.js"></script>

<!-- Main JS -->
<script src="assets/js/main.js"></script>
</body>



</html>