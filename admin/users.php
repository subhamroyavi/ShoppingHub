<?php
include 'connection.php';
include 'includes/header.php';
include 'includes/navbar.php';
include 'includes/sidebar.php';

if (empty($_SESSION['admin_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit();
}

// Fetch users
$sql = "SELECT * FROM users";
$sql_run = mysqli_query($conn, $sql);

if (!$sql_run) {
    die("Error fetching users: " . mysqli_error($conn));
}

?>

<div class="app-wrapper">
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Users</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Users</li>
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
                                        <!-- Button to Trigger Create Modal -->
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createUserModal">
                                            <i class="fas fa-plus me-2"></i>Create User
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="userTable" class="table table-bordered table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Created At</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        while ($rows = mysqli_fetch_assoc($sql_run)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td>
                                                    <div class="user-info">
                                                        <strong><?php echo $rows['firstname'] . ' ' . $rows['lastname']; ?></strong>

                                                    </div>
                                                </td>
                                                <td><?php echo $rows['email']; ?></td>
                                                <td><?php echo $rows['phone']; ?></td>
                                                <td>
                                                    <?php
                                                    echo $rows['city'] . ', ' . $rows['state'];

                                                    ?>
                                                    <button type="button" class="btn btn-sm btn-link text-info" data-bs-toggle="modal" data-bs-target="#userModal<?php echo $rows['user_id']; ?>">
                                                        Details
                                                    </button>
                                                </td>
                                                <td>
                                                    <?php
                                                    $date = strtotime($rows['created_at']);
                                                    echo date('d M, Y h:i A', $date);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $status_class = ($rows['status'] == 'active') ? 'success' : 'danger';
                                                    ?>
                                                    <span class="badge bg-<?php echo $status_class; ?>"><?php echo ucfirst($rows['status']); ?></span>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal<?php echo $rows['user_id']; ?>">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Details Modal -->
                                            <div class="modal fade" id="userModal<?php echo $rows['user_id']; ?>" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title"><?php echo $rows['firstname'] . ' ' . $rows['lastname']; ?> - Details</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <!-- Modal Body -->
                                                        <div class="modal-body">
                                                            <!-- Personal Information Section -->
                                                            <!--  -->

                                                            <!-- Address Section -->
                                                            <div class="row">
                                                                <!-- Primary Address -->
                                                                <div class="col-md-6">
                                                                    <h6 class="text-primary mb-3"><i class="fas fa-map-marker-alt me-2"></i>Primary Address</h6>
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <p class="card-text"><strong>Address:</strong> <?php echo $rows['address']; ?></p>
                                                                            <p class="card-text"><strong>City:</strong> <?php echo $rows['city']; ?></p>
                                                                            <p class="card-text"><strong>State:</strong> <?php echo $rows['state']; ?></p>
                                                                            <p class="card-text"><strong>Country:</strong> <?php echo $rows['country']; ?></p>
                                                                            <p class="card-text"><strong>Pincode:</strong> <?php echo $rows['pincode']; ?></p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Secondary Address (Conditional) -->
                                                                <?php if (!empty($rows['address2']) || !empty($rows['city2'])) : ?>
                                                                    <div class="col-md-6">
                                                                        <h6 class="text-primary mb-3"><i class="fas fa-map-marker-alt me-2"></i>Secondary Address</h6>
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <p class="card-text"><strong>Address:</strong> <?php echo $rows['address2']; ?></p>
                                                                                <p class="card-text"><strong>City:</strong> <?php echo $rows['city2']; ?></p>
                                                                                <p class="card-text"><strong>State:</strong> <?php echo $rows['state2']; ?></p>
                                                                                <p class="card-text"><strong>Country:</strong> <?php echo $rows['country2']; ?></p>
                                                                                <p class="card-text"><strong>Pincode:</strong> <?php echo $rows['pincode2']; ?></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>

                                                        <!-- Modal Footer -->
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                <i class="fas fa-times me-2"></i>Close
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Edit User Modal -->
                                            <!-- Edit User Modal -->
<div class="modal fade" id="editUserModal<?php echo $rows['user_id']; ?>" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit User: <?php echo $rows['firstname'] . ' ' . $rows['lastname']; ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form method="post" action="usersEdit.php?id=<?php echo $rows['user_id']; ?>">
                    <!-- Status Field -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="active" <?php echo ($rows['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo ($rows['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="updated">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
                                        <?php } ?>
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

<!-- Create User Modal -->
<!-- <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="usersCreate.php" id="createUserForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstname" class="form-label">First Name</label>
                            <input type="text" class="form-control" name="firstname" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="lastname" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <h5 class="mt-4 mb-3">Primary Address</h5>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address Line</label>
                        <input type="text" class="form-control" name="address" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" name="city" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" name="state" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" class="form-control" name="country" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pincode" class="form-label">Pincode</label>
                            <input type="text" class="form-control" name="pincode" required>
                        </div>
                    </div>

                    <h5 class="mt-4 mb-3">Secondary Address (Optional)</h5>
                    <div class="mb-3">
                        <label for="address2" class="form-label">Address Line</label>
                        <input type="text" class="form-control" name="address2">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="city2" class="form-label">City</label>
                            <input type="text" class="form-control" name="city2">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="state2" class="form-label">State</label>
                            <input type="text" class="form-control" name="state2">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="country2" class="form-label">Country</label>
                            <input type="text" class="form-control" name="country2">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pincode2" class="form-label">Pincode</label>
                            <input type="text" class="form-control" name="pincode2">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="submitted">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> -->

<style>
    /* Responsive styles */
    .table-responsive {
        overflow-x: auto;
    }

    /* Make action buttons stack on small screens */
    @media (max-width: 768px) {
        .btn-group {
            display: flex;
            flex-direction: column;
        }

        .btn-group .btn {
            margin-bottom: 5px;
            border-radius: 4px !important;
        }
    }

    /* User info styling */
    .user-info {
        display: flex;
        flex-direction: column;
    }

    /* Modal body scrolling for small screens */
    .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable with proper configuration
        $('#userTable').DataTable({
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

        // Form validation for create user form
        const createUserForm = document.getElementById('createUserForm');
        if (createUserForm) {
            createUserForm.addEventListener('submit', function(event) {
                const requiredInputs = createUserForm.querySelectorAll('[required]');
                let isValid = true;

                requiredInputs.forEach(input => {
                    if (!input.value) {
                        isValid = false;
                        input.classList.add('is-invalid');
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    event.preventDefault();
                    alert('Please fill in all required fields.');
                }
            });
        }
    });
</script>

<?php
include 'includes/footer.php';
?>