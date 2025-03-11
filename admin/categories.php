<?php
include 'connection.php'; // Database connection
include 'includes/header.php'; // Header file
include 'includes/navbar.php'; // Navbar file
include 'includes/sidebar.php'; // Sidebar file

// Fetch categories from the database
$sql = "SELECT * FROM categories ORDER BY id DESC";
$sql_run = mysqli_query($conn, $sql);

if (!$sql_run) {
    die("Error fetching categories: " . mysqli_error($conn));
}
?>

<div class="app-wrapper">
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Categories</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Categories</li>
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
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                                            <i class="fas fa-plus me-2"></i>Create Category
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="categoriesTable" class="table table-bordered table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Category Name</th>
                                            <th>Status</th>
                                            <th>Create At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        while ($category = mysqli_fetch_assoc($sql_run)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $category['c_name']; ?></td>
                                                <td>
                                                    <?php
                                                    $status_class = ($category['status'] == 'active') ? 'success' : 'danger';
                                                    ?>
                                                    <span class="badge bg-<?php echo $status_class; ?>"><?php echo ucfirst($category['status']); ?></span>
                                                </td>
                                                <td>
                                                    <?php
                                                    $date = strtotime($category['create_at']);
                                                    echo date('d M, Y h:i A', $date);

                                                    ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <!-- Edit Button -->
                                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editCategoryModal<?php echo $category['id']; ?>">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                        <!-- Delete Button -->
                                                        <a href="categoriesDelete.php?id=<?php echo $category['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Edit Category Modal -->
                                            <div class="modal fade" id="editCategoryModal<?php echo $category['id']; ?>" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Category: <?php echo $category['c_name']; ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post" action="categoriesEdit.php?id=<?php echo $category['id']; ?>">
                                                                <div class="mb-3">
                                                                    <label for="categoryName" class="form-label">Category Name</label>
                                                                    <input type="text" class="form-control" name="categoryName" value="<?php echo $category['c_name']; ?>" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="status" class="form-label">Status</label>
                                                                    <select class="form-select" name="status" required>
                                                                        <option value="active" <?php echo ($category['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                                                                        <option value="inactive" <?php echo ($category['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                                                    </select>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary" name="updateCategory">Save Changes</button>
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

<!-- Create Category Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="categoriesCreate.php">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="categoryName" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="createCategory">Create Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include DataTables Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#categoriesTable').DataTable({
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
</script>

<?php
include 'includes/footer.php'; // Footer file
?>