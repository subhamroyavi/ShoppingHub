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
        $items_query = "SELECT oi.*, p.name, p.image 
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
                        <!-- Order Status Timeline -->
                        <div class="order-status-timeline">
                            <h4>Order #<?= $order['order_id'] ?> Status</h4>
                            
                            <?php if (!empty($status_history)): ?>
                                <div class="timeline-steps">
                                    <?php 
                                    $statuses = [
                                        'pending' => 'Order Placed',
                                        'processing' => 'Processing',
                                        'shipped' => 'Shipped',
                                        'delivered' => 'Delivered',
                                        'cancelled' => 'Cancelled'
                                    ];
                                    
                                    $current_status = $order['status'];
                                    ?>
                                    
                                    <?php foreach ($statuses as $status => $label): ?>
                                        <div class="timeline-step <?= $status == $current_status ? 'active' : '' ?> 
                                            <?= array_search($status, array_keys($statuses)) < array_search($current_status, array_keys($statuses)) ? 'completed' : '' ?>">
                                            <div class="timeline-icon">
                                                <i class="fa fa-check"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <h6><?= $label ?></h6>
                                                <?php 
                                                // Find if this status exists in history
                                                $status_date = '';
                                                foreach ($status_history as $history) {
                                                    if ($history['status'] == $status) {
                                                        $status_date = date('M j, Y g:i A', strtotime($history['created_at']));
                                                        break;
                                                    }
                                                }
                                                ?>
                                                <?php if ($status_date): ?>
                                                    <p><?= $status_date ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    <p>Current Status: <strong><?= ucfirst($order['status']) ?></strong></p>
                                    <p>No status history available yet.</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Order Details -->
                        <div class="order-details-summary">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="order-shipping-details">
                                        <h5>Shipping Information</h5>
                                        <address>
                                            <strong><?= $order['firstname'] ?> <?= $order['lastname'] ?></strong><br>
                                            <?= $order['shipping_address'] ?><br>
                                            Order Date: <?= date('F j, Y', strtotime($order['created_at'])) ?><br>
                                            Order Total: $<?= number_format($order['total_amount'], 2) ?>
                                        </address>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="order-items-preview">
                                        <h5>Order Items</h5>
                                        <ul class="order-items-list">
                                            <?php foreach ($order_items as $item): ?>
                                                <li>
                                                    <?php if (!empty($item['image'])): ?>
                                                        <img src="../admin/<?= $item['image'] ?>" alt="<?= $item['name'] ?>" width="40">
                                                    <?php endif; ?>
                                                    <span><?= htmlspecialchars($item['name']) ?> (x<?= $item['quantity'] ?>)</span>
                                                    <span>$<?= number_format($item['subtotal'], 2) ?></span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Support Information -->
                        <div class="order-support-info">
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