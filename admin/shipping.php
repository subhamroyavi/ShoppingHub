<?php
include 'connection.php';
include 'includes/header.php';
include 'includes/navbar.php';
include 'includes/sidebar.php';

if (empty($_SESSION['admin_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit();
}

// Handle shipping creation
if (isset($_POST['add_shipping'])) {
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $tracking_number = mysqli_real_escape_string($conn, $_POST['tracking_number']);
    $carrier = mysqli_real_escape_string($conn, $_POST['carrier']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $estimated_delivery = mysqli_real_escape_string($conn, $_POST['estimated_delivery']);
    $shipping_date = mysqli_real_escape_string($conn, $_POST['shipping_date']);

    $query = "INSERT INTO shipping (order_id, tracking_number, carrier, status, estimated_delivery, shipping_date) 
              VALUES ('$order_id', '$tracking_number', '$carrier', '$status', '$estimated_delivery', '$shipping_date')";

    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Shipping information added successfully!";
        // Update order status to shipped if not already
        mysqli_query($conn, "UPDATE orders SET status='shipped' WHERE order_id='$order_id'");
    } else {
        $_SESSION['error'] = "Error adding shipping information: " . mysqli_error($conn);
    }

    echo "<script>window.location.href='shipping.php';</script>";
    exit();
}

// Handle shipping update
if (isset($_POST['update_shipping'])) {
    $shipping_id = mysqli_real_escape_string($conn, $_POST['shipping_id']);
    $tracking_number = mysqli_real_escape_string($conn, $_POST['tracking_number']);
    $carrier = mysqli_real_escape_string($conn, $_POST['carrier']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $estimated_delivery = mysqli_real_escape_string($conn, $_POST['estimated_delivery']);
    $actual_delivery = mysqli_real_escape_string($conn, $_POST['actual_delivery']);
    $shipping_date = mysqli_real_escape_string($conn, $_POST['shipping_date']);
    $delivery_date = mysqli_real_escape_string($conn, $_POST['delivery_date']);

    $query = "UPDATE shipping SET 
              tracking_number='$tracking_number', 
              carrier='$carrier', 
              status='$status', 
              estimated_delivery='$estimated_delivery', 
              actual_delivery=" . ($actual_delivery ? "'$actual_delivery'" : "NULL") . ", 
              shipping_date='$shipping_date', 
              delivery_date=" . ($delivery_date ? "'$delivery_date'" : "NULL") . " 
              WHERE shipping_id='$shipping_id'";

    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Shipping information updated successfully!";

        // Update order status if delivered
        if ($status == 'delivered') {
            $order_query = mysqli_query($conn, "SELECT order_id FROM shipping WHERE shipping_id='$shipping_id'");
            $order_data = mysqli_fetch_assoc($order_query);
            mysqli_query($conn, "UPDATE orders SET status='completed', payment_status='paid' WHERE order_id='" . $order_data['order_id'] . "'");
        }
    } else {
        $_SESSION['error'] = "Error updating shipping information: " . mysqli_error($conn);
    }
    echo "<script>window.location.href='shipping.php';</script>";
    exit();
}

// Fetch shipping records with order and customer info
$sql = "SELECT s.*, o.order_id, o.order_date, u.firstname AS customer_name 
        FROM shipping s 
        JOIN orders o ON s.order_id = o.order_id 
        JOIN users u ON o.user_id = u.user_id 
        ORDER BY s.shipping_id DESC";
$sql_run = mysqli_query($conn, $sql);

// Fetch orders that haven't been shipped yet for the add shipping modal
$unshipped_orders = mysqli_query($conn, "SELECT o.order_id, u.firstname AS customer_name 
                                        FROM orders o 
                                        JOIN users u ON o.user_id = u.user_id 
                                        WHERE o.order_id NOT IN (SELECT order_id FROM shipping) 
                                        AND o.status != 'cancelled'");
?>

<div class="app-wrapper">
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Shipping Management</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Shipping</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $_SESSION['success']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $_SESSION['error']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-md-4 col-sm-12 mb-3 mb-md-0">
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addShippingModal">
                                            <i class="fas fa-plus me-2"></i>Add Shipping
                                        </button>
                                    </div>

                                </div>
                            </div>

                            <div class="card-body">
                                <table id="shippingTable" class="table table-bordered table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Shipping ID</th>
                                            <th>Order ID</th>
                                            <th>Customer</th>
                                            <th>Tracking #</th>
                                            <th>Carrier</th>
                                            <th>Status</th>
                                            <th>Shipping Date</th>
                                            <th>Estimated Delivery</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($shipping = mysqli_fetch_assoc($sql_run)): ?>
                                            <tr>
                                                <td>#<?= $shipping['shipping_id'] ?></td>
                                                <td>#<?= $shipping['order_id'] ?></td>
                                                <td><?= htmlspecialchars($shipping['customer_name']) ?></td>
                                                <td><?= htmlspecialchars($shipping['tracking_number']) ?></td>
                                                <td><?= htmlspecialchars($shipping['carrier']) ?></td>
                                                <td>
                                                    <span class="badge bg-<?=
                                                                            $shipping['status'] == 'delivered' ? 'success' : ($shipping['status'] == 'in_transit' ? 'info' : ($shipping['status'] == 'out_for_delivery' ? 'primary' : ($shipping['status'] == 'returned' || $shipping['status'] == 'failed' ? 'danger' : 'warning')))
                                                                            ?>">
                                                        <?= ucfirst(str_replace('_', ' ', $shipping['status'])) ?>
                                                    </span>
                                                </td>
                                                <td><?= date('M d, Y', strtotime($shipping['shipping_date'])) ?></td>
                                                <td><?= $shipping['estimated_delivery'] ? date('M d, Y', strtotime($shipping['estimated_delivery'])) : 'N/A' ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewShippingModal<?= $shipping['shipping_id'] ?>">
                                                            <i class="fas fa-eye"></i> View
                                                        </button>
                                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editShippingModal<?= $shipping['shipping_id'] ?>">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- View Shipping Modal -->
                                            <div class="modal fade" id="viewShippingModal<?= $shipping['shipping_id'] ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Shipping Details #<?= $shipping['shipping_id'] ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h6 class="text-muted">Order Information</h6>
                                                                    <p><strong>Order ID:</strong> #<?= $shipping['order_id'] ?></p>
                                                                    <p><strong>Customer:</strong> <?= htmlspecialchars($shipping['customer_name']) ?></p>
                                                                    <p><strong>Order Date:</strong> <?= date('M d, Y h:i A', strtotime($shipping['order_date'])) ?></p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h6 class="text-muted">Shipping Information</h6>
                                                                    <p><strong>Tracking Number:</strong> <?= htmlspecialchars($shipping['tracking_number']) ?></p>
                                                                    <p><strong>Carrier:</strong> <?= htmlspecialchars($shipping['carrier']) ?></p>
                                                                    <p><strong>Status:</strong>
                                                                        <span class="badge bg-<?=
                                                                                                $shipping['status'] == 'delivered' ? 'success' : ($shipping['status'] == 'in_transit' ? 'info' : ($shipping['status'] == 'out_for_delivery' ? 'primary' : ($shipping['status'] == 'returned' || $shipping['status'] == 'failed' ? 'danger' : 'warning')))
                                                                                                ?>">
                                                                            <?= ucfirst(str_replace('_', ' ', $shipping['status'])) ?>
                                                                        </span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col-md-6">
                                                                    <h6 class="text-muted">Dates</h6>
                                                                    <p><strong>Shipping Date:</strong> <?= date('M d, Y', strtotime($shipping['shipping_date'])) ?></p>
                                                                    <p><strong>Estimated Delivery:</strong> <?= $shipping['estimated_delivery'] ? date('M d, Y', strtotime($shipping['estimated_delivery'])) : 'N/A' ?></p>
                                                                    <p><strong>Actual Delivery:</strong> <?= $shipping['actual_delivery'] ? date('M d, Y h:i A', strtotime($shipping['actual_delivery'])) : 'Not yet delivered' ?></p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h6 class="text-muted">Tracking</h6>
                                                                    <?php if ($shipping['carrier'] && $shipping['tracking_number']): ?>
                                                                        <?php
                                                                        $tracking_url = '';
                                                                        $carrier_lower = strtolower($shipping['carrier']);
                                                                        if (strpos($carrier_lower, 'fedex') !== false) {
                                                                            $tracking_url = "https://www.fedex.com/fedextrack/?tracknumbers=" . $shipping['tracking_number'];
                                                                        } elseif (strpos($carrier_lower, 'ups') !== false) {
                                                                            $tracking_url = "https://www.ups.com/track?tracknum=" . $shipping['tracking_number'];
                                                                        } elseif (strpos($carrier_lower, 'usps') !== false) {
                                                                            $tracking_url = "https://tools.usps.com/go/TrackConfirmAction?tLabels=" . $shipping['tracking_number'];
                                                                        } elseif (strpos($carrier_lower, 'dhl') !== false) {
                                                                            $tracking_url = "https://www.dhl.com/us-en/home/tracking/tracking-parcel.html?submit=1&tracking-id=" . $shipping['tracking_number'];
                                                                        }
                                                                        ?>
                                                                        <?php if ($tracking_url): ?>
                                                                            <a href="<?= $tracking_url ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                                <i class="fas fa-external-link-alt me-1"></i> Track Package
                                                                            </a>
                                                                        <?php else: ?>
                                                                            <p>No tracking link available for this carrier</p>
                                                                        <?php endif; ?>
                                                                    <?php else: ?>
                                                                        <p>No tracking information available</p>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Edit Shipping Modal -->
                                            <div class="modal fade" id="editShippingModal<?= $shipping['shipping_id'] ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Shipping #<?= $shipping['shipping_id'] ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="" method="POST">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="shipping_id" value="<?= $shipping['shipping_id'] ?>">

                                                                <div class="mb-3">
                                                                    <label class="form-label">Tracking Number</label>
                                                                    <input type="text" class="form-control" name="tracking_number" value="<?= htmlspecialchars($shipping['tracking_number']) ?>" required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Carrier</label>
                                                                    <input type="text" class="form-control" name="carrier" value="<?= htmlspecialchars($shipping['carrier']) ?>" required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Status</label>
                                                                    <select class="form-select" name="status" required>
                                                                        <option value="pending" <?= $shipping['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                                                        <option value="in_transit" <?= $shipping['status'] == 'in_transit' ? 'selected' : '' ?>>In Transit</option>
                                                                        <option value="out_for_delivery" <?= $shipping['status'] == 'out_for_delivery' ? 'selected' : '' ?>>Out for Delivery</option>
                                                                        <option value="delivered" <?= $shipping['status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                                                        <option value="returned" <?= $shipping['status'] == 'returned' ? 'selected' : '' ?>>Returned</option>
                                                                        <option value="failed" <?= $shipping['status'] == 'failed' ? 'selected' : '' ?>>Failed</option>
                                                                    </select>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Shipping Date</label>
                                                                    <input type="datetime-local" class="form-control" name="shipping_date" value="<?= date('Y-m-d\TH:i', strtotime($shipping['shipping_date'])) ?>" required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Estimated Delivery</label>
                                                                    <input type="date" class="form-control" name="estimated_delivery" value="<?= $shipping['estimated_delivery'] ? date('Y-m-d', strtotime($shipping['estimated_delivery'])) : '' ?>">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Actual Delivery (if delivered)</label>
                                                                    <input type="datetime-local" class="form-control" name="actual_delivery" value="<?= $shipping['actual_delivery'] ? date('Y-m-d\TH:i', strtotime($shipping['actual_delivery'])) : '' ?>">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Delivery Date (if delivered)</label>
                                                                    <input type="datetime-local" class="form-control" name="delivery_date" value="<?= $shipping['delivery_date'] ? date('Y-m-d\TH:i', strtotime($shipping['delivery_date'])) : '' ?>">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" name="update_shipping" class="btn btn-primary">Save Changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

<!-- Add Shipping Modal -->
<div class="modal fade" id="addShippingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Shipping Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Order</label>
                        <select class="form-select" name="order_id" required>
                            <option value="">Select Order</option>
                            <?php while ($order = mysqli_fetch_assoc($unshipped_orders)): ?>
                                <option value="<?= $order['order_id'] ?>">Order #<?= $order['order_id'] ?> - <?= htmlspecialchars($order['customer_name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tracking Number</label>
                        <input type="text" class="form-control" name="tracking_number" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Carrier</label>
                        <input type="text" class="form-control" name="carrier" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="in_transit">In Transit</option>
                            <option value="out_for_delivery">Out for Delivery</option>
                            <option value="delivered">Delivered</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Shipping Date</label>
                        <input type="datetime-local" class="form-control" name="shipping_date" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Estimated Delivery</label>
                        <input type="date" class="form-control" name="estimated_delivery">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_shipping" class="btn btn-primary">Add Shipping</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable with descending order by default
        $('#shippingTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "pageLength": 10,
            "order": [
                [0, 'desc']
            ], // Sort by first column (shipping_id) in descending order
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "language": {
                "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>",
                    "next": "<i class='fas fa-chevron-right'></i>"
                }
            }
        });

        // Custom search functionality for the search input
        $('#search-input').keyup(function() {
            $('#shippingTable').DataTable().search(this.value).draw();
        });
    });
</script>

<?php include 'includes/footer.php'; ?>