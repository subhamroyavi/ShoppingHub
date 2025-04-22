<?php
include "include/header.php";
include "include/connection.php";

if (empty($_SESSION['user_id'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

// Handle adding product to cart
if (isset($_GET['pid'])) {
    $id = $_GET['pid'];
    $user_id = $_SESSION['user_id'];
    $qty = isset($_GET['qty']) ? (int)$_GET['qty'] : 1;

    // Get or create cart for user
    $query = "SELECT id FROM carts WHERE user_id = '$user_id' ORDER BY created_at DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $cart_id = $row['id'];
        $_SESSION['cart_id'] = $cart_id;
    } else {
        $query = "INSERT INTO carts(user_id) VALUES ('$user_id')";
        $result = mysqli_query($conn, $query);
        $cart_id = mysqli_insert_id($conn);
        $_SESSION['cart_id'] = $cart_id;
    }

    // Check if product already exists in cart
    $check_sql = mysqli_query($conn, "SELECT * FROM cart_items WHERE product_id = '$id' AND cart_id = '$cart_id'");
    if (mysqli_num_rows($check_sql) == 0) {
        $query = "INSERT INTO cart_items(cart_id, product_id, qty) VALUES ('$cart_id', '$id', '$qty')";
        $result = mysqli_query($conn, $query);
    } else {
        // Update quantity if product exists
        $row = mysqli_fetch_assoc($check_sql);
        $new_qty = $row['qty'] + $qty;
        $query = "UPDATE cart_items SET qty = '$new_qty' WHERE id = '{$row['id']}'";
        $result = mysqli_query($conn, $query);
    }
}

// Handle quantity update via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pid']) && isset($_POST['qty'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['pid']);
    $qty = (int)$_POST['qty'];
    $cart_id = $_SESSION['cart_id'];

    $update = mysqli_query($conn, "UPDATE cart_items SET qty = '$qty' WHERE cart_id = '$cart_id' AND product_id = '$product_id'");

    if ($update) {
        // Calculate new total price
        $product_query = mysqli_query($conn, "SELECT price FROM products WHERE id = '$product_id'");
        $product = mysqli_fetch_assoc($product_query);
        $new_total = number_format($product['price'] * $qty, 2);

        echo json_encode([
            'success' => true,
            'new_total' => $new_total,
            'new_subtotal' => calculateCartSubtotal($conn, $cart_id)
        ]);
    } else {
        echo json_encode(['error' => 'Error updating cart: ' . mysqli_error($conn)]);
    }
    exit();
}

// Function to calculate cart subtotal
function calculateCartSubtotal($conn, $cart_id)
{
    $subtotal = 0;
    $query = "SELECT ci.qty, p.price 
              FROM cart_items ci
              JOIN products p ON ci.product_id = p.id
              WHERE ci.cart_id = '$cart_id'";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $subtotal += $row['qty'] * $row['price'];
    }

    return number_format($subtotal, 2);
}

// Pagination logic
$itemsPerPage = 4; // Number of cart items per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

// Get cart items count
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $cart_id = $_SESSION['cart_id'] ?? 0;

    $totalItemsQuery = "SELECT COUNT(*) as total FROM cart_items WHERE cart_id = '$cart_id'";
    $totalItemsResult = mysqli_query($conn, $totalItemsQuery);
    $totalItems = mysqli_fetch_assoc($totalItemsResult)['total'];

    $totalPages = ceil($totalItems / $itemsPerPage);

    // Get cart items for current page
    $cart_items = mysqli_query($conn, "SELECT ci.id as cart_item_id, ci.qty, p.id, p.name, p.image, p.price 
                                      FROM cart_items ci
                                      JOIN products p ON ci.product_id = p.id
                                      WHERE ci.cart_id = '$cart_id'
                                      ORDER BY ci.id DESC
                                      LIMIT $itemsPerPage OFFSET $offset");

    // Calculate cart subtotal
    $subtotal = calculateCartSubtotal($conn, $cart_id);
}
?>

<!-- ...:::: Start Breadcrumb Section:::... -->
<div class="breadcrumb-section breadcrumb-bg-color--golden">
    <div class="breadcrumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="breadcrumb-title">Cart</h3>
                    <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                        <nav aria-label="breadcrumb">
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li class="active" aria-current="page">Cart</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Breadcrumb Section:::... -->

<!-- ...:::: Start Cart Section:::... -->
<div class="cart-section">
    <!-- Start Cart Table -->
    <div class="cart-table-wrapper" data-aos="fade-up" data-aos-delay="0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="table_desc">
                        <div class="table_page table-responsive">
                            <table>
                                <!-- Start Cart Table Head -->
                                <thead>
                                    <tr>
                                        <th class="product_remove">Delete</th>
                                        <th class="product_thumb">Image</th>
                                        <th class="product_name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product_quantity">Quantity</th>
                                        <th class="product_total">Total</th>
                                        <th class="product_total">Action</th>
                                    </tr>
                                </thead> <!-- End Cart Table Head -->
                                <tbody>
                                    <?php
                                    if (isset($cart_items) && mysqli_num_rows($cart_items) > 0) {
                                        while ($cart_details = mysqli_fetch_assoc($cart_items)) {
                                            $item_total = $cart_details['price'] * $cart_details['qty'];
                                    ?>
                                            <tr>
                                                <td class="product_remove">
                                                    <a href="cart_itemDelete.php?id=<?php echo $cart_details['id']; ?>">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>
                                                </td>
                                                <td class="product_thumb">
                                                    <a href="productDetails.php?id=<?php echo $cart_details['id']; ?>">
                                                        <img src="../admin/<?php echo $cart_details['image']; ?>" alt="">
                                                    </a>
                                                </td>
                                                <td class="product_name">
                                                    <a href="productDetails.php?id=<?php echo $cart_details['id']; ?>">
                                                        <?php echo $cart_details['name']; ?>
                                                    </a>
                                                </td>
                                                <td class="product-price">$<?php echo number_format($cart_details['price'], 2); ?></td>
                                                <td class="product_quantity">
                                                    <label>Quantity</label>
                                                    <input class="qty-input" min="1" max="100"
                                                        value="<?php echo $cart_details['qty']; ?>"
                                                        type="number"
                                                        data-product-id="<?php echo $cart_details['id']; ?>">
                                                </td>
                                                <td class="product_total" id="product_total_<?php echo $cart_details['id']; ?>">
                                                    $<?php echo number_format($item_total, 2); ?>
                                                </td>
                                                <td>
                                                    <button class="update-cart-btn btn btn-md btn-golden"
                                                        data-product-id="<?php echo $cart_details['id']; ?>">
                                                        Update
                                                    </button>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="7" class="text-center">Your cart is empty</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Cart Table -->

    <!-- Pagination -->
    <?php if (isset($totalPages) && $totalPages > 1): ?>
        <div class="shop-list-pagination mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <!-- First Page Link -->
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=1" aria-label="First">
                                <span aria-hidden="true">&laquo;&laquo;</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <span class="page-link"><span aria-hidden="true">&laquo;&laquo;</span></span>
                        </li>
                    <?php endif; ?>

                    <!-- Previous Page Link -->
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <span class="page-link"><span aria-hidden="true">&laquo;</span></span>
                        </li>
                    <?php endif; ?>

                    <!-- Page Numbers -->
                    <?php
                    $startPage = max(1, $page - 2);
                    $endPage = min($totalPages, $page + 2);

                    if ($startPage > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=1">1</a>
                        </li>
                        <?php if ($startPage > 2): ?>
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($endPage < $totalPages): ?>
                        <?php if ($endPage < $totalPages - 1): ?>
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        <?php endif; ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $totalPages; ?>"><?php echo $totalPages; ?></a>
                        </li>
                    <?php endif; ?>

                    <!-- Next Page Link -->
                    <?php if ($page < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <span class="page-link"><span aria-hidden="true">&raquo;</span></span>
                        </li>
                    <?php endif; ?>

                    <!-- Last Page Link -->
                    <?php if ($page < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $totalPages; ?>" aria-label="Last">
                                <span aria-hidden="true">&raquo;&raquo;</span>
                            </a>
                        </li>
                    <?php else: ?>
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
    <?php endif; ?>

    <!-- Start Coupon and Cart Totals -->
    <div class="coupon_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="coupon_code left" data-aos="fade-up" data-aos-delay="200">
                        <h3>Coupon</h3>
                        <div class="coupon_inner">
                            <p>Enter your coupon code if you have one.</p>
                            <input class="mb-2" placeholder="Coupon code" type="text">
                            <button type="submit" class="btn btn-md btn-golden">Apply coupon</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="coupon_code right" data-aos="fade-up" data-aos-delay="400">
                        <h3>Cart Totals</h3>
                        <div class="coupon_inner">
                            <div class="cart_subtotal">
                                <p>Subtotal</p>
                                <p class="cart_amount">$<?php echo isset($subtotal) ? $subtotal : '0.00'; ?></p>
                            </div>
                            <div class="cart_subtotal">
                                <p>Shipping</p>
                                <p class="cart_amount"><span>Flat Rate:</span> $0.00</p>
                            </div>
                            <div class="cart_subtotal">
                                <p>Total</p>
                                <p class="cart_amount">$<?php echo isset($subtotal) ? $subtotal : '0.00'; ?></p>
                            </div>
                            <div class="checkout_btn">
                                <a href="checkout.php" class="btn btn-md btn-golden">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Handle cart updates (button click or Enter key)
        $('.update-cart-btn').on('click', updateCart);
        $('.qty-input').on('keypress', function(e) {
            if (e.which === 13) {
                $(this).closest('tr').find('.update-cart-btn').click();
                e.preventDefault();
            }
        });

        function updateCart(e) {
            e.preventDefault();
            var productId = $(this).data('product-id');
            var qty = $(this).closest('tr').find('.qty-input').val();

            $.ajax({
                url: 'cart.php',
                type: 'POST',
                data: {
                    pid: productId,
                    qty: qty
                },
                success: function() {
                    location.reload(); // Simple reload after update
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('Update failed. Please try again.');
                }
            });
        }
    });
</script>

<?php include "include/footer.php"; ?>