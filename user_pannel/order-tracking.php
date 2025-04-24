<?php
include "include/header.php";
include "include/connection.php";

// Check if user is logged in
if (empty($_SESSION['user_id'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

// Get order details if order_id is provided
$order = null;
$order_items = [];
$status_history = [];

$subtotal = 0;
$shipping_fee = 5.00; // Fixed shipping fee
$total = $subtotal + $shipping_fee;

if ($order_id > 0) {
    // Verify the order belongs to the current user
    $order_query = "SELECT o.*, u.firstname, u.lastname 
                    FROM orders o
                    JOIN users u ON o.user_id = u.user_id
                    WHERE o.order_id = $order_id AND o.user_id = $user_id";
    $order_result = mysqli_query($conn, $order_query);

    if (mysqli_num_rows($order_result) > 0) {
        $order = mysqli_fetch_assoc($order_result);

        // Get order items
        $items_query = "SELECT oi.*, p.name, p.image, p.price 
                        FROM order_items oi
                        JOIN products p ON oi.product_id = p.id
                        WHERE oi.order_id = $order_id";
        $items_result = mysqli_query($conn, $items_query);
        while ($row = mysqli_fetch_assoc($items_result)) {
            $order_items[] = $row;
        }

        // Get status history (assuming you have an order_status_history table)
        $status_query = "SELECT * FROM order_status_history 
                         WHERE order_id = $order_id 
                         ORDER BY status_date DESC";
        $status_result = mysqli_query($conn, $status_query);
        while ($row = mysqli_fetch_assoc($status_result)) {
            $status_history[] = $row;
        }
    }
}

// Handle search if form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search_order'])) {
    $search_id = intval($_POST['order_id']);
    echo "<script>window.location.href='order-tracking.php?order_id=$search_id';</script>";
    exit();
}
?>

<!-- ...:::: Start Breadcrumb Section:::... -->
<div class="breadcrumb-section breadcrumb-bg-color--golden">
    <div class="breadcrumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="breadcrumb-title">Order Tracking</h3>
                    <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                        <nav aria-label="breadcrumb">
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li class="active" aria-current="page">Order Tracking</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Breadcrumb Section:::... -->

<!-- ...:::: Start Order Tracking Section:::... -->
<div class="order-tracking-section section-fluid-270 section-top-gap-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="order-tracking-wrapper">
                    <!-- Order Search Form -->
                    <div class="order-search-form">
                        <h3>Track Your Order</h3>
                        <p>Enter your order number to view order status</p>
                        <form method="post">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="default-form-box">
                                        <label>Order Number <span>*</span></label>
                                        <input type="text" name="order_id" value="<?= $order_id ? $order_id : '' ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="default-form-box">
                                        <label>&nbsp;</label>
                                        <button type="submit" name="search_order" class="btn btn-md btn-black-default-hover">Track Order</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <?php if ($order_id > 0 && $order): ?>
                        <div class="row">
                            <!-- Order Status Timeline - Now placed in a column next to order details -->
                            <div class="col-lg-6">
                                <div class="order-tracker">
                                    <h4 class="order-title">Order #<?= $order['order_id'] ?> Status</h4>

                                    <?php if (!empty($status_history)): ?>
                                        <div class="timeline-container">
                                            <?php
                                            $statuses = [
                                                'pending' => 'Order Placed',
                                                'processing' => 'Processing',
                                                'shipped' => 'Shipped',
                                                'completed' => 'Completed',
                                                'cancelled' => 'Cancelled'
                                            ];

                                            $current_status = $order['status'];
                                            ?>

                                            <?php foreach ($statuses as $status => $label): ?>
                                                <?php
                                                $isActive = $status == $current_status;
                                                $isCompleted = array_search($status, array_keys($statuses)) < array_search($current_status, array_keys($statuses));
                                                $status_date = '';

                                                foreach ($status_history as $history) {
                                                    if ($history['status'] == $status) {
                                                        $status_date = date('M j, Y g:i A', strtotime($history['status_date']));
                                                        break;
                                                    }
                                                }
                                                ?>
                                                <div class="timeline-step <?= $isActive ? 'active' : '' ?> <?= $isCompleted ? 'completed' : '' ?>">
                                                    <div class="step-icon">
                                                        <i class="fa <?= $isCompleted || $isActive ? 'fa-check-circle' : 'fa-circle' ?>"></i>
                                                    </div>
                                                    <div class="step-details">
                                                        <h6 class="step-title"><?= $label ?></h6>
                                                        <?php if ($status_date): ?>
                                                            <p class="step-date"><?= $status_date ?></p>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="timeline-empty alert alert-info">
                                            <p>Current Status: <strong><?= ucfirst($order['status']) ?></strong></p>
                                            <p>No status history available yet.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Order Details - Now placed in a column next to the timeline -->
                            <div class="col-lg-6">
                                <div class="order-details-summary">
                                    <div class="order-shipping-details">
                                        <h5>Order Information</h5>
                                        <div class="order-info-box">
                                            <div class="order-info-item">
                                                <span class="info-label">Order Number:</span>
                                                <span class="info-value">#<?= $order['order_id'] ?></span>
                                            </div>
                                            <div class="order-info-item">
                                                <span class="info-label">Order Date:</span>
                                                <span class="info-value"><?= date('F j, Y', strtotime($order['created_at'])) ?></span>
                                            </div>
                                            <div class="order-info-item">
                                                <span class="info-label">Order Status:</span>
                                                <span class="info-value status-<?= $order['status'] ?>"><?= ucfirst($order['status']) ?></span>
                                            </div>
                                            <div class="order-info-item">
                                                <span class="info-label">Order Total:</span>
                                                <span class="info-value">$<?= number_format($order['total_amount'], 2) ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="order-shipping-details mt-4">
                                        <h5>Shipping Information</h5>
                                        <div class="shipping-info-box">
                                            <div class="shipping-info-item">
                                                <span class="info-label">Customer:</span>
                                                <span class="info-value"><?= $order['firstname'] ?> <?= $order['lastname'] ?></span>
                                            </div>
                                            <div class="shipping-info-item">
                                                <span class="info-label">Address:</span>
                                                <span class="info-value"><?= $order['shipping_address'] ?></span>
                                            </div>
                                            <div class="shipping-info-item">
                                                <span class="info-label">Phone:</span>
                                                <span class="info-value"><?= $order['shipping_phone'] ?? 'N/A' ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items - Full width below the two columns -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="order-items-section">
                                    <h5>Order Items</h5>
                                    <div class="table-responsive">
                                        <table class="table order-items-table">
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
                                                            <div class="product-info">
                                                                <?php if (!empty($item['image'])): ?>
                                                                    <img src="../admin/<?= $item['image'] ?>" alt="<?= $item['name'] ?>" width="60">
                                                                <?php endif; ?>
                                                                <span><?= htmlspecialchars($item['name']) ?></span>
                                                            </div>
                                                        </td>
                                                        <td>$<?= number_format($item['price'], 2) ?></td>
                                                        <td><?= $item['quantity'] ?></td>
                                                        <td>$<?= number_format($item['subtotal'], 2) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3" class="text-end">Subtotal:</td>
                                                    <td>$<?= number_format($order['total_amount'] - $shipping_fee, 2) ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="text-end">Shipping:</td>
                                                    <td>$<?= number_format($shipping_fee, 2) ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="text-end fw-bold">Total:</td>
                                                    <td class="fw-bold">$<?= number_format($order['total_amount'], 2) ?></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Support Information -->
                        <div class="order-support-info mt-4">
                            <div class="alert alert-light">
                                <h5>Need Help?</h5>
                                <p>If you have any questions about your order, please contact our customer service.</p>
                                <a href="contact-us.php" class="btn btn-md btn-black-default-hover">Contact Us</a>
                            </div>
                        </div>

                    <?php elseif ($order_id > 0): ?>
                        <!-- Order not found message -->
                        <div class="alert alert-danger">
                            <h5>Order Not Found</h5>
                            <p>We couldn't find an order with ID <?= $order_id ?> associated with your account.</p>
                            <p>Please check your order number and try again.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Order Tracking Section:::... -->

<?php include "include/footer.php"; ?>