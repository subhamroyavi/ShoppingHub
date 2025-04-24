<?php
include 'connection.php';
include 'includes/header.php';
include 'includes/navbar.php';
include 'includes/sidebar.php';

if (empty($_SESSION['admin_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit();
}

$order_id = $_GET['id'] ?? 0;

// Fetch order details
$order_sql = "SELECT o.*, u.firstname, u.email, u.phone 
              FROM orders o 
              JOIN users u ON o.user_id = u.user_id 
              WHERE o.order_id = $order_id";
$order_result = mysqli_query($conn, $order_sql);
$order = mysqli_fetch_assoc($order_result);

// Fetch order items
$items_sql = "SELECT oi.*, p.name, p.image 
              FROM order_items oi 
              JOIN products p ON oi.product_id = p.id 
              WHERE oi.order_id = $order_id";
$items_result = mysqli_query($conn, $items_sql);

// Fetch payment info
$payment_sql = "SELECT * FROM payments WHERE order_id = $order_id";
$payment_result = mysqli_query($conn, $payment_sql);
$payment = mysqli_fetch_assoc($payment_result);

// Fetch shipping info
$shipping_sql = "SELECT * FROM orders WHERE order_id = $order_id";
$shipping_result = mysqli_query($conn, $shipping_sql);
$shipping = mysqli_fetch_assoc($shipping_result);

$shipping_sql = "SELECT * FROM shipping WHERE order_id = $order_id";
$shipping_result = mysqli_query($conn, $shipping_sql);
$shipping_details = mysqli_fetch_assoc($shipping_result);


// Fetch status history
$history_sql = "SELECT * FROM order_status_history 
                WHERE order_id = $order_id 
                ORDER BY status_date DESC";
$history_result = mysqli_query($conn, $history_sql);
?>

<div class="app-wrapper">
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Order #<?= $order_id ?></h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="orders.php">Orders</a></li>
                            <li class="breadcrumb-item active">Order #<?= $order_id ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Order Summary</h5>
                                    <div>
                                        <span class="badge bg-<?=
                                                                $order['status'] == 'completed' ? 'success' : ($order['status'] == 'processing' ? 'info' : ($order['status'] == 'cancelled' ? 'danger' : 'warning'))
                                                                ?> me-2">
                                            <?= ucfirst($order['status']) ?>
                                        </span>
                                        <span class="badge bg-<?=
                                                                $order['payment_status'] == 'paid' ? 'success' : ($order['payment_status'] == 'refunded' ? 'info' : 'danger')
                                                                ?>">
                                            <?= ucfirst($order['payment_status']) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Order Details</h6>
                                        <p><strong>Order ID:</strong> #<?= $order_id ?></p>
                                        <p><strong>Order Date:</strong> <?= date('M d, Y h:i A', strtotime($order['order_date'])) ?></p>
                                        <p><strong>Total Amount:</strong> $<?= number_format($order['total_amount'], 2) ?></p>
                                        <p><strong>Customer Notes:</strong> <?= $order['customer_notes'] ?: '—' ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Customer Details</h6>
                                        <p><strong>Name:</strong> <?= htmlspecialchars($order['firstname']) ?></p>
                                        <p><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
                                        <p><strong>Phone:</strong> <?= $order['phone'] ?: '—' ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Order Items</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Qty</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($item = mysqli_fetch_assoc($items_result)): ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="<?= $item['image'] ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="img-thumbnail me-3" width="60">
                                                            <div>
                                                                <h6 class="mb-0"><?= htmlspecialchars($item['name']) ?></h6>
                                                                <small class="text-muted">SKU: <?= $item['product_id'] ?></small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>$<?= number_format($item['unit_price'], 2) ?></td>
                                                    <td><?= $item['quantity'] ?></td>
                                                    <td>$<?= number_format($item['subtotal'], 2) ?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3" class="text-end">Subtotal:</th>
                                                <td>$<?= number_format($order['total_amount'] - 5, 2) ?></td>
                                            </tr>
                                            <tr>
                                                <th colspan="3" class="text-end">Shipping:</th>
                                                <td>$5.00</td>
                                            </tr>
                                            <tr>
                                                <th colspan="3" class="text-end">Total:</th>
                                                <td>$<?= number_format($order['total_amount'], 2) ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Order Status History Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Order Status History</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <?php
                                    $history_sql = "SELECT * FROM order_status_history 
                                                    WHERE order_id = $order_id 
                                                    ORDER BY status_date DESC";
                                    $history_result = mysqli_query($conn, $history_sql);

                                    while ($history = mysqli_fetch_assoc($history_result)):
                                    ?>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <strong><?= ucfirst($history['status']) ?></strong>
                                                    <?php if ($history['notes']): ?>
                                                        <p class="mb-0"><small><?= htmlspecialchars($history['notes']) ?></small></p>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="text-muted">
                                                    <small><?= date('M d, Y h:i A', strtotime($history['status_date'])) ?></small>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Shipping Information</h5>
                            </div>
                            <div class="card-body">
                                <?php if ($shipping): ?>
                                    <p><strong>Shipping Address:</strong><br>
                                        <?= nl2br(htmlspecialchars($order['shipping_address'])) ?></p>

                                    <p><strong>Carrier:</strong> <?= $shipping_details['carrier'] ?: '—' ?></p>
                                    <p><strong>Tracking Number:</strong> <?= $shipping_details['tracking_number'] ?: '—' ?></p>
                                    <p><strong>Status:</strong>
                                        <span class="badge bg-<?=
                                                                $shipping_details['status'] == 'delivered' ? 'success' : ($shipping['status'] == 'shipped' ? 'info' : ($shipping['status'] == 'processing' ? 'warning' : 'secondary'))
                                                                ?>">
                                            <?= ucfirst($shipping_details['status']) ?>
                                        </span>
                                    </p>
                                    <?php if ($shipping_details['estimated_delivery']): ?>
                                        <p><strong>Estimated Delivery:</strong> <?= date('M d, Y', strtotime($shipping_details['estimated_delivery'])) ?></p>
                                    <?php endif; ?>
                                    <?php if ($shipping_details['actual_delivery']): ?>
                                        <p><strong>Delivered On:</strong> <?= date('M d, Y', strtotime($shipping['actual_delivery'])) ?></p>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <p>Shipping information not available yet.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Payment Information</h5>
                            </div>
                            <div class="card-body">
                                <?php if ($payment): ?>
                                    <p><strong>Payment Method:</strong> <?= ucfirst(str_replace('_', ' ', $payment['payment_method'])) ?></p>
                                    <p><strong>Amount Paid:</strong> $<?= number_format($payment['amount'], 2) ?></p>
                                    <p><strong>Transaction ID:</strong> <?= $payment['transaction_id'] ?: '—' ?></p>
                                    <p><strong>Status:</strong>
                                        <span class="badge bg-<?=
                                                                $payment['status'] == 'completed' ? 'success' : ($payment['status'] == 'pending' ? 'warning' : 'danger')
                                                                ?>">
                                            <?= ucfirst($payment['status']) ?>
                                        </span>
                                    </p>
                                    <p><strong>Payment Date:</strong> <?= date('M d, Y h:i A', strtotime($payment['payment_date'])) ?></p>
                                <?php else: ?>
                                    <p>Payment information not available yet.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Order Actions</h5>
                            </div>
                            <div class="card-body">
                                <form action="order_update.php" method="POST">
                                    <input type="hidden" name="order_id" value="<?= $order_id ?>">

                                    <div class="mb-3">
                                        <label class="form-label">Update Status</label>
                                        <select class="form-select" name="status">
                                            <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
                                            <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                            <option value="completed" <?= $order['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                                            <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Update Payment Status</label>
                                        <select class="form-select" name="payment_status">
                                            <option value="unpaid" <?= $order['payment_status'] == 'unpaid' ? 'selected' : '' ?>>Unpaid</option>
                                            <option value="paid" <?= $order['payment_status'] == 'paid' ? 'selected' : '' ?>>Paid</option>
                                            <option value="refunded" <?= $order['payment_status'] == 'refunded' ? 'selected' : '' ?>>Refunded</option>
                                        </select>
                                    </div>

                                    <?php if ($shipping): ?>
                                        <!-- <div class="mb-3">
                                            <label class="form-label">Update Shipping Status</label>
                                            <select class="form-select" name="shipping_status">
                                                <option value="processing" <?= $shipping['status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
                                                <option value="shipped" <?= $shipping['status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                                <option value="in_transit" <?= $shipping['status'] == 'in_transit' ? 'selected' : '' ?>>In Transit</option>
                                                <option value="delivered" <?= $shipping['status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                            </select>
                                        </div> -->

                                        <div class="mb-3">
                                            <label class="form-label">Tracking Number</label>
                                            <input type="text" class="form-control" name="tracking_number" value="<?= $shipping['order_id'] ?>" disabled>
                                        </div>
                                    <?php endif; ?>

                                    <div class="mb-3">
                                        <label class="form-label">Notes</label>
                                        <textarea class="form-control" name="notes" rows="3"></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">Update Order</button>
                                </form>

                                <hr>

                                <div class="d-grid gap-2">
                                    <a href="#" class="btn btn-outline-success">Print Invoice</a>
                                    <a href="#" class="btn btn-outline-primary">Email Customer</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

<?php include 'includes/footer.php'; ?>