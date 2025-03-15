<?php
include 'connection.php';
include 'includes/header.php';
include 'includes/navbar.php';
include 'includes/sidebar.php';

if (empty($_SESSION['admin_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit();
}

// Fetch staff members
$sql = "SELECT * FROM admin ORDER BY admin_id DESC";
$sql_run = mysqli_query($conn, $sql);



if (!$sql_run) {
    die("Error fetching staff: " . mysqli_error($conn));
}
?>

<div class="app-wrapper">
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Staff Members</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Staff</li>
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
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createStaffModal">
                                            <i class="fas fa-plus me-2"></i>Add Staff
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="staffTable" class="table table-bordered table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Staff Id</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Image</th>
                                            <th>Addrees</th>
                                            <th>Role</th>
                                            <th>Created at</th>
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
                                                <td><?php echo $rows['admin_id']; ?></td>
                                                <td>
                                                    <div class="staff-info">
                                                        <strong><?php echo $rows['firstname'] . ' ' . $rows['lastname']; ?></strong>

                                                    </div>
                                                </td>
                                                <td><?php echo $rows['email']; ?></td>
                                                <td><?php echo $rows['phone']; ?></td>
                                                <td>
                                                    <div class="d-flex flex-wrap gap-1">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal<?php echo $rows['admin_id']; ?>">
                                                            <img src="<?php echo $rows['image']; ?>" alt="Profile" class="img-thumbnail" width="50" height="50">
                                                        </a>
                                                    </div>
                                                </td>


                                                <td>
                                                    <?php echo $rows['city']; ?>
                                                    <button type="button" class="btn btn-sm btn-link text-info" data-bs-toggle="modal" data-bs-target="#detailsModal<?php echo $rows['admin_id']; ?>">
                                                        Details
                                                    </button>
                                                </td>
                                                <td><?php echo ucfirst($rows['type']); ?></td>
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
                                                    <span class="badge bg-<?php echo $status_class; ?>">
                                                        <?php echo ucfirst($rows['status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editStaffModal<?php echo $rows['admin_id']; ?>">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                        <a href="staffsDelete.php?id=<?php echo $rows['admin_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this staff member?')">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Details Modal -->
                                            <div class="modal fade" id="detailsModal<?php echo $rows['admin_id']; ?>" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?php echo $rows['firstname'] . ' ' . $rows['lastname']; ?> - Details</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h6>Address Details</h6>

                                                                    <p><strong>Address:</strong> <?php echo $rows['address']; ?></p>
                                                                    <p><strong>City:</strong> <?php echo $rows['city']; ?></p>
                                                                    <p><strong>Pincode:</strong> <?php echo $rows['pincode']; ?></p>
                                                                    <p><strong>State:</strong> <?php echo $rows['state']; ?></p>
                                                                    <p><strong>Country:</strong> <?php echo $rows['country']; ?></p>
                                                                    <p><strong>Role:</strong> <?php echo ucfirst($rows['type']); ?></p>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Image Modal -->
                                            <div class="modal fade" id="imageModal<?php echo $rows['admin_id']; ?>" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?php echo $rows['firstname'] . ' ' . $rows['lastname']; ?> - Image</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <!-- Modal Body -->
                                                        <div class="modal-body text-center">
                                                            <img src="<?php echo $rows['image']; ?>" alt="Product Image" class="img-fluid" style="max-width: 40%; height: auto;">
                                                        </div>
                                                        <div class="row">
                                                                <div class="col-md-6">
                                                                   
                                                                    <p><strong>Created:</strong> <?php $date = strtotime($rows['created_at']);
                                                                                                    echo date('d M, Y h:i A', $date); ?></p>
                                                                </div>
                                                            </div>
                                                        <!-- Modal Footer -->
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- Edit Staff Modal -->
                                            <div class="modal fade" id="editStaffModal<?php echo $rows['admin_id']; ?>" tabindex="-1" aria-labelledby="editStaffModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Staff: <?php echo $rows['firstname'] . ' ' . $rows['lastname']; ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post" action="staffsEdit.php?id=<?php echo $rows['admin_id']; ?>" enctype="multipart/form-data">
                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="firstname" class="form-label">First Name</label>
                                                                        <input type="text" class="form-control" name="firstname" value="<?php echo $rows['firstname']; ?>" required>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="lastname" class="form-label">Last Name</label>
                                                                        <input type="text" class="form-control" name="lastname" value="<?php echo $rows['lastname']; ?>" required>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="email" class="form-label">Email</label>
                                                                        <input type="email" class="form-control" name="email" value="<?php echo $rows['email']; ?>" required>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="phone" class="form-label">Phone</label>
                                                                        <input type="text" class="form-control" name="phone" value="<?php echo $rows['phone']; ?>" required>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="address" class="form-label">Address</label>
                                                                        <input type="text" class="form-control" name="address" value="<?php echo $rows['address']; ?>" required>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="city" class="form-label">City</label>
                                                                        <input type="text" class="form-control" name="city" value="<?php echo $rows['city']; ?>" required>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="pincode" class="form-label">Pincode</label>
                                                                        <input type="text" class="form-control" name="pincode" value="<?php echo $rows['pincode']; ?>" required>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="state" class="form-label">State</label>
                                                                        <input type="text" class="form-control" name="state" value="<?php echo $rows['state']; ?>" required>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="country" class="form-label">Country</label>
                                                                        <input type="text" class="form-control" name="country" value="<?php echo $rows['country']; ?>" required>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="image" class="form-label">Main Image</label>
                                                                        <input type="file" class="form-control image-upload" name="image" data-preview="mainImagePreview">
                                                                        <div id="mainImagePreview" class="image-preview mt-2">
                                                                            <?php if (!empty($rows['image'])) : ?>
                                                                                <img src="<?php echo $rows['image']; ?>" alt="Current Image" class="img-thumbnail" style="width: 100px; height: auto;">
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="role" class="form-label">Role</label>
                                                                            <select class="form-select" name="role" required>
                                                                                <option value="admin" <?php echo ($rows['type'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                                                                <option value="manager" <?php echo ($rows['type'] == 'manager') ? 'selected' : ''; ?>>Manager</option>
                                                                                <option value="staff" <?php echo ($rows['type'] == 'staff') ? 'selected' : ''; ?>>Staff</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="status" class="form-label">Status</label>
                                                                            <select class="form-select" name="status" required>
                                                                                <option value="active" <?php echo ($rows['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                                                                                <option value="inactive" <?php echo ($rows['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

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

<!-- Create Staff Modal -->
<div class="modal fade" id="createStaffModal" tabindex="-1" aria-labelledby="createStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Staff</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="staffsCreate.php" id="createStaffForm" enctype="multipart/form-data">
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

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" name="city" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pincode" class="form-label">Pincode</label>
                            <input type="text" class="form-control" name="pincode" required>
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
                            <label for="image" class="form-label">Main Image</label>
                            <input type="file" class="form-control image-upload" name="image" data-preview="mainImagePreview" required>
                            <div id="mainImagePreview" class="image-preview mt-2"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" name="role" required>
                                    <option value="admin">Admin</option>
                                    <option value="manager">Manager</option>
                                    <option value="staff">Staff</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" name="status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="submitted">Add Staff</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include DataTables and other scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#staffTable').DataTable({
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
    });


    document.addEventListener('DOMContentLoaded', function() {
        const imageUploads = document.querySelectorAll('.image-upload');

        imageUploads.forEach(input => {
            input.addEventListener('change', function() {
                const previewId = this.getAttribute('data-preview');
                const previewContainer = document.getElementById(previewId);
                previewContainer.innerHTML = ''; // Clear previous preview

                if (this.files && this.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('img-thumbnail');
                        img.style.width = '100px';
                        img.style.height = 'auto';
                        previewContainer.appendChild(img);
                    }

                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all clickable images
        const images = document.querySelectorAll('.clickable-image');

        // Get the popup modal and image element
        const popupModal = new bootstrap.Modal(document.getElementById('imagePopupModal'));
        const popupImage = document.getElementById('popupImage');

        // Add click event listener to each image
        images.forEach(image => {
            image.addEventListener('click', function() {
                // Set the source of the popup image
                popupImage.src = this.getAttribute('data-src');
                // Show the popup modal
                popupModal.show();
            });
        });
    });
</script>

<?php
include 'includes/footer.php';
?>