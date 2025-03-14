<?php
include "include/header.php";
include "include/connection.php";


?>




<!-- ...:::: Start Breadcrumb Section:::... -->
<div class="breadcrumb-section breadcrumb-bg-color--golden">
    <div class="breadcrumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="breadcrumb-title">Products</h3>
                    <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                        <nav aria-label="breadcrumb">
                            <ul>
                                <li><a href="index.html">Home</a></li>
                                <li><a href="shop-grid-sidebar-left.html">Shop</a></li>
                                <li class="active" aria-current="page">Products</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ...:::: End Breadcrumb Section:::... -->

<!-- ...:::: Start Shop Section:::... -->
<div class="shop-section">
    <div class="container">
        <div class="row flex-column-reverse flex-lg-row">
            <div class="col-lg-12">
                <!-- Start Shop Product Sorting Section -->
                <div class="shop-sort-section">
                    <div class="container">
                        <div class="row">
                            <!-- Start Sort Wrapper Box -->
                            <div class="sort-box d-flex justify-content-between align-items-md-center align-items-start flex-md-row flex-column"
                                data-aos="fade-up" data-aos-delay="0">
                                <!-- Start Sort tab Button -->
                                <div class="sort-tablist d-flex align-items-center">
                                    <ul class="tablist nav sort-tab-btn">
                                        <li><a class="nav-link active" data-bs-toggle="tab"
                                                href="#layout-4-grid"><img src="assets/images/icons/bkg_grid.png"
                                                    alt=""></a></li>
                                        <li><a class="nav-link" data-bs-toggle="tab" href="#layout-list"><img
                                                    src="assets/images/icons/bkg_list.png" alt=""></a></li>
                                    </ul>

                                    <!-- Start Page Amount -->
                                    <div class="page-amount ml-2">
                                        <span>Showing 1–9 of 21 results</span>
                                    </div> <!-- End Page Amount -->
                                </div> <!-- End Sort tab Button -->

                                <!-- Start Sort Select Option -->
                                <div class="sort-select-list d-flex align-items-center">
                                    <label class="mr-2">Sort By:</label>
                                    <form action="#">
                                        <fieldset>
                                            <select name="speed" id="speed">
                                                <option>Sort by average rating</option>
                                                <option>Sort by popularity</option>
                                                <option selected="selected">Sort by newness</option>
                                                <option>Sort by price: low to high</option>
                                                <option>Sort by price: high to low</option>
                                                <option>Product Name: Z</option>
                                            </select>
                                        </fieldset>
                                    </form>
                                </div> <!-- End Sort Select Option -->



                            </div> <!-- Start Sort Wrapper Box -->
                        </div>
                    </div>
                </div> <!-- End Section Content -->

                <!-- Start Tab Wrapper -->
                <div class="sort-product-tab-wrapper">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="tab-content">
                                    <!-- Start Grid View Product -->
                                    <div class="tab-pane active show sort-layout-single" id="layout-4-grid">
                                        <div class="row">
                                            <?php
                                            $product_sql = "SELECT * FROM products WHERE status = 'active' ORDER BY id DESC";
                                            $product_sql_run = mysqli_query($conn, $product_sql);

                                            if (mysqli_num_rows($product_sql_run) > 0) {
                                                while ($products = mysqli_fetch_assoc($product_sql_run)) {

                                            ?>
                                                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                                                        <!-- Start Product Default Single Item -->


                                                        <div class="product-default-single-item product-color--golden"
                                                            data-aos="fade-up" data-aos-delay="0">
                                                            <div class="image-box">
                                                                <a href="productDetails.php?id=<?php echo $products['id'] ?>" class="image-link">
                                                                    <img src="../admin/<?php echo $products['image']; ?>"
                                                                        alt="<?php echo $products['image']; ?>">
                                                                    <img src="../admin/<?php echo $products['image']; ?>"
                                                                        alt="<?php echo $products['image']; ?>">
                                                                </a>
                                                                <div class="action-link">
                                                                    <div class="action-link-left">
                                                                        <a href="#" data-bs-toggle="modal"
                                                                            data-bs-target="#modalAddcart">Add to Cart</a>
                                                                    </div>
                                                                    <div class="action-link-right">
                                                                        <a href="productDetails.php?id=<?php echo $products['id'] ?>" ><i
                                                                                class="icon-magnifier"></i></a>
                                                                        <a href="wishlist.html"><i
                                                                                class="icon-heart"></i></a>
                                                                        <!-- <a href="compare.html"><i
                                                                        class="icon-shuffle"></i></a> -->
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
                                                    </div>

                                            <?php
                                                }
                                            }
                                            ?>


                                        </div>
                                    </div> <!-- End List View Product -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- End Tab Wrapper -->

                <!-- Start Pagination -->
                <div class="page-pagination text-center" data-aos="fade-up" data-aos-delay="0">
                    <ul>
                        <li><a class="active" href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#"><i class="ion-ios-skipforward"></i></a></li>
                    </ul>
                </div> <!-- End Pagination -->
            </div> <!-- End Shop Product Sorting Section  -->
        </div>
    </div>
</div> <!-- ...:::: End Shop Section:::... -->


<?php include "include/footer.php" ?>