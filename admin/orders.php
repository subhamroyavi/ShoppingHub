<?php
include 'connection.php';
include 'includes/header.php';
include 'includes/navbar.php';
include 'includes/sidebar.php';

if (empty($_SESSION['admin_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit();
}

// Fetch orders with customer info
$sql = "SELECT o.*, u.firstname AS customer_name 
        FROM orders o 
        JOIN users u ON o.user_id = u.user_id 
        ORDER BY o.order_id ASC";
$sql_run = mysqli_query($conn, $sql);
?>

<div class="app-wrapper">
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Orders</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Orders</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-md-4 col-sm-12 mb-3 mb-md-0">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                                            <i class="fas fa-filter me-2"></i>Filter
                                        </button>
                                    </div>
                                    <!--  -->
                                </div>
                            </div>

                            <div class="card-body">
                                <table id="ordersTable" class="table table-bordered table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Payment</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($order = mysqli_fetch_assoc($sql_run)): ?>
                                            <tr>
                                                <td>#<?= $order['order_id'] ?></td>
                                                <td><?= htmlspecialchars($order['customer_name']) ?></td>
                                                <td><?= date('M d, Y h:i A', strtotime($order['order_date'])) ?></td>
                                                <td><?= number_format($order['total_amount'], 2) ?></td>
                                                <td>
                                                    <span class="badge bg-<?=
                                                                            $order['status'] == 'completed' ? 'success' : ($order['status'] == 'processing' ? 'info' : ($order['status'] == 'cancelled' ? 'danger' : 'warning'))
                                                                            ?>">
                                                        <?= ucfirst($order['status']) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?=
                                                                            $order['payment_status'] == 'paid' ? 'success' : ($order['payment_status'] == 'refunded' ? 'info' : 'danger')
                                                                            ?>">
                                                        <?= ucfirst($order['payment_status']) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="order_view.php?id=<?= $order['order_id'] ?>" class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i> View
                                                        </a>
                                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#statusModal<?= $order['order_id'] ?>">
                                                            <i class="fas fa-edit"></i> Status
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Status Update Modal -->
                                            <div class="modal fade" id="statusModal<?= $order['order_id'] ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Update Order Status</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="order_update.php?order_id=<?= $order['order_id'] ?>" method="POST">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">

                                                                <div class="mb-3">
                                                                    <label class="form-label">Order Status</label>
                                                                    <select class="form-select" name="status" required>
                                                                        <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                                                        <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
                                                                        <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                                                        <option value="completed" <?= $order['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                                                                        <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                                                    </select>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Payment Status</label>
                                                                    <select class="form-select" name="payment_status" required>
                                                                        <option value="unpaid" <?= $order['payment_status'] == 'unpaid' ? 'selected' : '' ?>>Unpaid</option>
                                                                        <option value="paid" <?= $order['payment_status'] == 'paid' ? 'selected' : '' ?>>Paid</option>
                                                                        <option value="refunded" <?= $order['payment_status'] == 'refunded' ? 'selected' : '' ?>>Refunded</option>
                                                                    </select>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Notes</label>
                                                                    <textarea class="form-control" name="notes" rows="3"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Update Status</button>
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

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter Orders</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="GET" action="">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Payment Status</label>
                        <select class="form-select" name="payment_status">
                            <option value="">All Payments</option>
                            <option value="paid">Paid</option>
                            <option value="unpaid">Unpaid</option>
                            <option value="refunded">Refunded</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date Range</label>
                        <div class="input-group">
                            <input type="date" class="form-control" name="date_from">
                            <span class="input-group-text">to</span>
                            <input type="date" class="form-control" name="date_to">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add the same DataTables JS as in carousel.php -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable with the same settings as carousel.php
        $('#ordersTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "pageLength": 10,
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
            $('#ordersTable').DataTable().search(this.value).draw();
        });
    });
</script>

<?php include 'includes/footer.php'; ?>