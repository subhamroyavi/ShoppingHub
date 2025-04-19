<?php

include "include/header.php";
include "include/connection.php";

// Check if the user is logged in
if (empty($_SESSION['user_id'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

// Check if the request is an AJAX request and contains the product ID
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $wishlist_id = mysqli_real_escape_string($conn, $_POST['id']);
    $user_id = $_SESSION['user_id'];
    $product_id = mysqli_real_escape_string($conn, $_POST['id']);

    // Check if the product is already in the wishlist
    $check_sql = mysqli_query($conn, "SELECT * FROM wishlists WHERE user_id = '$user_id' AND product_id = '$product_id'");
    if (mysqli_num_rows($check_sql) == 0) {
        // Insert the product into the wishlist
        $sql = "INSERT INTO `wishlists`(`user_id`, `product_id`) VALUES ('$user_id', '$product_id')";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['status' => 'info']);
    }
}


// Pagination logic
$itemsPerPage = 4; // Number of wishlist items per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$offset = ($page - 1) * $itemsPerPage; // Offset for SQL query

// Fetch total number of wishlist items for the logged-in user
$user_id = $_SESSION['user_id'];
$totalItemsQuery = "SELECT COUNT(*) as total FROM wishlists WHERE user_id = $user_id";
$totalItemsResult = mysqli_query($conn, $totalItemsQuery);
$totalItems = mysqli_fetch_assoc($totalItemsResult)['total'];

// Calculate total pages
$totalPages = ceil($totalItems / $itemsPerPage);

// Fetch wishlist items for the current page
$wishlist_sql = "SELECT wishlists.wishlist_id, products.id, products.name AS product_name, products.image, products.price, products.status AS product_status 
                 FROM wishlists
                 JOIN products ON wishlists.product_id = products.id
                 WHERE wishlists.user_id = $user_id
                 ORDER BY wishlists.wishlist_id DESC
                 LIMIT $itemsPerPage OFFSET $offset";
$wishlist_sql_run = mysqli_query($conn, $wishlist_sql);

// Calculate the proper "showing X-Y of Z results" text
$startItem = ($page - 1) * $itemsPerPage + 1;
$endItem = min($page * $itemsPerPage, $totalItems);
?>


<!-- ...:::: Start Breadcrumb Section:::... -->
<div class="breadcrumb-section breadcrumb-bg-color--golden">
    <div class="breadcrumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="breadcrumb-title">Wishlists</h3>
                    <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                        <nav aria-label="breadcrumb">
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li><a href="shop-grid-sidebar-left.html">Shop</a></li>
                                <li class="active" aria-current="page">Wishlists</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ...:::: End Breadcrumb Section:::... -->

<!-- ...:::: Start Wishlist Section:::... -->
<div class="wishlist-section">
    <!-- Start Wishlist Table -->
    <div class="wishlish-table-wrapper" data-aos="fade-up" data-aos-delay="0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="table_desc">
                        <div class="table_page table-responsive">
                            <table>
                                <!-- Start Wishlist Table Head -->
                                <thead>
                                    <tr>
                                        <th class="product_remove">Delete</th>
                                        <th class="product_thumb">Image</th>
                                        <th class="product_name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product_stock">Stock Status</th>
                                        <th class="product_addcart">Add To Cart</th>
                                    </tr>
                                </thead> <!-- End Wishlist Table Head -->
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($wishlist_sql_run) > 0) {
                                        while ($row = mysqli_fetch_assoc($wishlist_sql_run)) {
                                    ?>
                                            <!-- Start Wishlist Single Item-->
                                            <tr>
                                                <td class="product_remove">
                                                    <a href="wishlistDelete.php?id=<?php echo $row['wishlist_id']; ?>">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>
                                                </td>
                                                <td class="product_thumb">
                                                    <a href="productDetails.php?id=<?php echo $row['id']; ?>">
                                                        <img src="../admin/<?php echo $row['image']; ?>" alt="">
                                                    </a>
                                                </td>
                                                <td class="product_name">
                                                    <a href="productDetails.php?id=<?php echo $row['id']; ?>">
                                                        <?php echo $row['product_name']; ?>
                                                    </a>
                                                </td>
                                                <td class="product-price"><?php echo $row['price']; ?></td>
                                                <td class="product_stock"><?php echo $row['product_status']; ?></td>
                                                <td class="product_addcart">
                                                    <a href="addToCart.php" class="btn btn-md btn-golden">
                                                        Add To Cart
                                                    </a>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="6" class="text-center">No items in your wishlist.</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Wishlist Table -->
</div>
<!-- ...:::: End Wishlist Section:::... -->

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
        <p>Showing page <?php echo $page; ?> of <?php echo $totalPages; ?> (Total items: <?php echo $totalItems; ?>)</p>
    </div>
</div>

<?php include "include/footer.php" ?>