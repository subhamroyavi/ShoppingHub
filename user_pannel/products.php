<?php
include "include/header.php";
include "include/connection.php";

// Pagination logic
$productsPerPage = 12; // 3 rows x 4 products
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$offset = ($page - 1) * $productsPerPage; // Offset for SQL query

// Fetch total number of products
$totalProductsQuery = "SELECT COUNT(*) as total FROM products WHERE status = 'active'";
$totalProductsResult = mysqli_query($conn, $totalProductsQuery);
$totalProducts = mysqli_fetch_assoc($totalProductsResult)['total'];

// Calculate total pages
$totalPages = ceil($totalProducts / $productsPerPage);

// Fetch products for the current page
if (isset($_POST['search_submit'])) {
    $search = trim($_POST['search']);

    if (!empty($search)) {
        $search = mysqli_real_escape_string($conn, $search);

        $product_sql = "SELECT * FROM products 
                       WHERE (name LIKE '%$search%' 
                       OR brand_name LIKE '%$search%')
                       AND status = 'active'
                       ORDER BY id DESC 
                       LIMIT $productsPerPage OFFSET $offset";

        $product_sql_run = mysqli_query($conn, $product_sql);

        if (!$product_sql_run) {
            die("Query failed: " . mysqli_error($conn));
        }
    } else {
        $product_sql = "SELECT * FROM products 
                       WHERE status = 'active' 
                       ORDER BY id DESC 
                       LIMIT $productsPerPage OFFSET $offset";
        $product_sql_run = mysqli_query($conn, $product_sql);
    }
} else {
    $product_sql = "SELECT * FROM products 
                   WHERE status = 'active' 
                   ORDER BY id DESC 
                   LIMIT $productsPerPage OFFSET $offset";
    $product_sql_run = mysqli_query($conn, $product_sql);
}

// Calculate the proper "showing X-Y of Z results" text
$startItem = ($page - 1) * $productsPerPage + 1;
$endItem = min($page * $productsPerPage, $totalProducts);
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
                                <li><a href="index.php">Home</a></li>
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
                                                    alt=""></a>
                                        </li>
                                    </ul>

                                    <!-- Start Page Amount -->
                                    <div class="page-amount ml-2">
                                        <span>Showing <?php echo $startItem; ?>–<?php echo $endItem; ?> of <?php echo $totalProducts; ?> results</span>
                                    </div> <!-- End Page Amount -->
                                </div> <!-- End Sort tab Button -->
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
                                                                        <a href="productDetails.php?id=<?php echo $products['id'] ?>"><i
                                                                                class="icon-magnifier"></i></a>
                                                                        <a href="wishlist.php?id=<?php echo $products['id'] ?>"><i
                                                                                class="icon-heart"></i></a>
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
                                            } else {
                                                echo '<div class="col-12 text-center"><p>No products found</p></div>';
                                            }
                                            ?>
                                        </div>
                                    </div> <!-- End Grid View Product -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- End Tab Wrapper -->

                <!-- Pagination -->
                <div class="shop-list-pagination mt-4">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <!-- First Page Link -->
                            <?php if ($page > 1) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=1" aria-label="First">
                                        <span aria-hidden="true">&laquo;&laquo;</span>
                                    </a>
                                </li>
                            <?php else : ?>
                                <li class="page-item disabled">
                                    <span class="page-link"><span aria-hidden="true">&laquo;&laquo;</span></span>
                                </li>
                            <?php endif; ?>

                            <!-- Previous Page Link -->
                            <?php if ($page > 1) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php else : ?>
                                <li class="page-item disabled">
                                    <span class="page-link"><span aria-hidden="true">&laquo;</span></span>
                                </li>
                            <?php endif; ?>

                            <!-- Page Numbers with Limited Display -->
                            <?php
                            $startPage = max(1, $page - 2);
                            $endPage = min($totalPages, $page + 2);

                            // Always show first page
                            if ($startPage > 1) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=1">1</a>
                                </li>
                                <?php if ($startPage > 2) : ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>

                            <!-- Page numbers between start and end -->
                            <?php for ($i = $startPage; $i <= $endPage; $i++) : ?>
                                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Always show last page -->
                            <?php if ($endPage < $totalPages) : ?>
                                <?php if ($endPage < $totalPages - 1) : ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                <?php endif; ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $totalPages; ?>"><?php echo $totalPages; ?></a>
                                </li>
                            <?php endif; ?>

                            <!-- Next Page Link -->
                            <?php if ($page < $totalPages) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php else : ?>
                                <li class="page-item disabled">
                                    <span class="page-link"><span aria-hidden="true">&raquo;</span></span>
                                </li>
                            <?php endif; ?>

                            <!-- Last Page Link -->
                            <?php if ($page < $totalPages) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $totalPages; ?>" aria-label="Last">
                                        <span aria-hidden="true">&raquo;&raquo;</span>
                                    </a>
                                </li>
                            <?php else : ?>
                                <li class="page-item disabled">
                                    <span class="page-link"><span aria-hidden="true">&raquo;&raquo;</span></span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                    <div class="page-amount text-center mt-2">
                        <p>Showing page <?php echo $page; ?> of <?php echo $totalPages; ?> (Total products: <?php echo $totalProducts; ?>)</p>
                    </div>
                </div>
            </div> <!-- End Shop Product Sorting Section  -->
        </div>
    </div>
</div> <!-- ...:::: End Shop Section:::... -->

<?php include "include/footer.php" ?>