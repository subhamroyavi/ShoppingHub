<?php
include "include/header.php";
include "include/connection.php";

// Check if user is logged in
if (empty($_SESSION['user_id'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

// Get order ID from URL
if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

$order_id = intval($_GET['order_id']);
$user_id = $_SESSION['user_id'];

// Verify the order belongs to the current user
$order_query = "SELECT o.*, u.firstname, u.lastname, u.email, u.phone 
                FROM orders o
                JOIN users u ON o.user_id = u.user_id
                WHERE o.order_id = $order_id AND o.user_id = $user_id";
$order_result = mysqli_query($conn, $order_query);

if (mysqli_num_rows($order_result) === 0) {
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

$order = mysqli_fetch_assoc($order_result);

// Get order items
$items_query = "SELECT oi.*, p.name, p.image 
                FROM order_items oi
                JOIN products p ON oi.product_id = p.id
                WHERE oi.order_id = $order_id";
$items_result = mysqli_query($conn, $items_query);
$order_items = [];
while ($row = mysqli_fetch_assoc($items_result)) {
    $order_items[] = $row;
}

// Get payment details
$payment_query = "SELECT * FROM payments WHERE order_id = $order_id";
$payment_result = mysqli_query($conn, $payment_query);
$payment = mysqli_fetch_assoc($payment_result);
?>

<!-- ...:::: Start Breadcrumb Section:::... -->
<div class="breadcrumb-section breadcrumb-bg-color--golden">
    <div class="breadcrumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="breadcrumb-title">Order Confirmation</h3>
                    <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                        <nav aria-label="breadcrumb">
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li class="active" aria-current="page">Order Confirmation</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Breadcrumb Section:::... -->

<!-- ...:::: Start Order Confirmation Section:::... -->
<div class="order-confirmation-section section-fluid-270 section-top-gap-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="order-confirmation-wrapper">
                    <!-- Order Confirmation Title -->
                    <div class="order-confirmation-title">
                        <h2>Thank You For Your Order!</h2>
                        <p>Your order has been received and is now being processed.</p>
                    </div>

                    <!-- Order Details -->
                    <div class="order-confirmation-details">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="order-details-box">
                                    <h4>Order Information</h4>
                                    <ul>
                                        <li><span>Order Number:</span> <?= $order['order_id'] ?></li>
                                        <li><span>Date:</span> <?= date('F j, Y', strtotime($order['created_at'])) ?></li>
                                        <li><span>Total:</span> $<?= number_format($order['total_amount'], 2) ?></li>
                                        <li><span>Payment Method:</span> 
                                            <?= ucwords(str_replace('_', ' ', $payment['payment_method'])) ?>
                                            (<?= ucfirst($payment['status']) ?>)
                                        </li>
                                        <li><span>Order Status:</span> <?= ucfirst($order['status']) ?></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="customer-details-box">
                                    <h4>Customer Details</h4>
                                    <ul>
                                        <li><span>Name:</span> <?= $order['firstname'] ?> <?= $order['lastname'] ?></li>
                                        <li><span>Email:</span> <?= $order['email'] ?></li>
                                        <li><span>Phone:</span> <?= $order['phone'] ?></li>
                                        <li><span>Shipping Address:</span> <?= $order['shipping_address'] ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="order-confirmation-items">
                        <h4>Order Items</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($order_items as $item): ?>
                                        <tr>
                                            <td>
                                                <!-- <div class="product-info"> -->
                                                    <?php if (!empty($item['image'])): ?>
                                                        <img src="../admin/<?= $item['image'] ?>" alt="<?= $item['name'] ?>" width="60">
                                                    <?php endif; ?>
                                                    <span><?= htmlspecialchars($item['name']) ?></span>
                                                <!-- </div> -->
                                            </td>
                                            <td>$<?= number_format($item['unit_price'], 2) ?></td>
                                            <td><?= $item['quantity'] ?></td>
                                            <td>$<?= number_format($item['subtotal'], 2) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right">Subtotal:</td>
                                        <td>$<?= number_format($order['total_amount'] - 5.00, 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-right">Shipping:</td>
                                        <td>$5.00</td>
                                    </tr>
                                    <tr class="total">
                                        <td colspan="3" class="text-right">Total:</td>
                                        <td>$<?= number_format($order['total_amount'], 2) ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="order-confirmation-actions">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="order-tracking">
                                    <h4>Track Your Order</h4>
                                    <p>You can track your order using your order number.</p>
                                    <a href="order-tracking.php?order_id=<?= $order_id ?>" class="btn btn-md btn-black-default-hover">Track Order</a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="continue-shopping">
                                    <h4>Continue Shopping</h4>
                                    <p>Browse our collection for more great products.</p>
                                    <a href="products.php" class="btn btn-md btn-black-default-hover">Back to Shop</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Order Confirmation Section:::... -->

<?php include "include/footer.php"; ?>