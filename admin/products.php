<?php
include 'connection.php';
include 'includes/header.php';
include 'includes/navbar.php';
include 'includes/sidebar.php';

if (empty($_SESSION['admin_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit();
}

// Fetch products with category names
$sql = "SELECT p.*, c.c_name AS category_name 
        FROM products p 
        JOIN categories c ON p.c_id = c.id ORDER BY id DESC";
$sql_run = mysqli_query($conn, $sql);

// Fetch categories for dropdowns
$category_sql = "SELECT * FROM categories";
$category_result = mysqli_query($conn, $category_sql);

if (!$category_result) {
    die("Error fetching categories: " . mysqli_error($conn));
}


?>

<div class="app-wrapper">
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Products</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Products</li>
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
                                    <div class="card-header">
                                        <div class="row align-items-center">
                                            <div class="col-md-4 col-sm-12 mb-3 mb-md-0">
                                                <!-- Button to Trigger Create Modal -->
                                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createProductModal">
                                                    <i class="fas fa-plus me-2"></i>Create Product
                                                </button>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>


                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Product</th>
                                            <th>Category</th>
                                            <th>Brand</th>
                                            <th>Price (MRP/Actual)</th>
                                            <th>Stock</th>
                                            <th>Images</th>
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
                                                    <div class="product-info">
                                                        <strong><?php echo $rows['name']; ?></strong>
                                                        <button type="button" class="btn btn-sm btn-link text-info" data-bs-toggle="modal" data-bs-target="#descModal<?php echo $rows['id']; ?>">
                                                            Details
                                                        </button>
                                                    </div>
                                                </td>
                                                <td><?php echo $rows['category_name']; ?></td>
                                                <td><?php echo $rows['brand_name']; ?></td>
                                                <td>
                                                    <span class="text-muted">MRP: </span><?php echo $rows['mrp_price']; ?><br>
                                                    <span class="text-success">Actual: </span><?php echo $rows['price']; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $stock = $rows['stock'];
                                                    $stock_class = ($stock > 10) ? 'success' : (($stock > 0) ? 'warning' : 'danger');
                                                    ?>
                                                    <span class="badge bg-<?php echo $stock_class; ?>"><?php echo $stock; ?></span>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-wrap gap-1">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal<?php echo $rows['id']; ?>">
                                                            <img src="<?php echo $rows['image']; ?>" alt="Product" class="img-thumbnail" width="50" height="50">
                                                        </a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php
                                                    $status_class = ($rows['status'] == 'active') ? 'success' : 'danger';
                                                    ?>
                                                    <span class="badge bg-<?php echo $status_class; ?>"><?php echo ucfirst($rows['status']); ?></span>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editProductModal<?php echo $rows['id']; ?>">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                        <a href="productsDelete.php?id=<?php echo $rows['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Description Modal -->
                                            <div class="modal fade" id="descModal<?php echo $rows['id']; ?>" tabindex="-1" aria-labelledby="descModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?php echo $rows['name']; ?> - Details</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h6>Short Description</h6>
                                                                    <p><?php echo htmlspecialchars($rows['description']); ?></p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h6>Long Description</h6>
                                                                    <p><?php echo htmlspecialchars($rows['long_description']); ?></p>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <p><strong>Reviews:</strong> <?php echo $rows['reviews']; ?></p>
                                                                    <p><strong>Created:</strong> <?php $date = strtotime($rows['create_at']);
                                                                                                    echo date('d M, Y h:i A', $date); ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Images Modal -->
                                            <div class="modal fade" id="imageModal<?php echo $rows['id']; ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?php echo $rows['name']; ?> - Images</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6 col-lg-3 mb-3">
                                                                    <div class="card">
                                                                        <img src="<?php echo $rows['image']; ?>" class="card-img-top img-fluid" alt="Main Image">
                                                                        <div class="card-body">
                                                                            <h5 class="card-title">Main Image</h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php if (!empty($rows['image1'])) : ?>
                                                                    <div class="col-md-6 col-lg-3 mb-3">
                                                                        <div class="card">
                                                                            <img src="<?php echo $rows['image1']; ?>" class="card-img-top img-fluid" alt="Image 1">
                                                                            <div class="card-body">
                                                                                <h5 class="card-title">Image 1</h5>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <?php if (!empty($rows['image2'])) : ?>
                                                                    <div class="col-md-6 col-lg-3 mb-3">
                                                                        <div class="card">
                                                                            <img src="<?php echo $rows['image2']; ?>" class="card-img-top img-fluid" alt="Image 2">
                                                                            <div class="card-body">
                                                                                <h5 class="card-title">Image 2</h5>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <?php if (!empty($rows['image3'])) : ?>
                                                                    <div class="col-md-6 col-lg-3 mb-3">
                                                                        <div class="card">
                                                                            <img src="<?php echo $rows['image3']; ?>" class="card-img-top img-fluid" alt="Image 3">
                                                                            <div class="card-body">
                                                                                <h5 class="card-title">Image 3</h5>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Edit Product Modal -->
                                            <div class="modal fade" id="editProductModal<?php echo $rows['id']; ?>" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Product: <?php echo $rows['name']; ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post" action="productsEdit.php?id=<?php echo $rows['id']; ?>" enctype="multipart/form-data">
                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="name" class="form-label">Product Name</label>
                                                                        <input type="text" class="form-control" name="name" value="<?php echo $rows['name']; ?>" required>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="category" class="form-label">Category</label>
                                                                        <select class="form-select" name="category" required>
                                                                            <?php
                                                                            mysqli_data_seek($category_result, 0); // Reset category result pointer
                                                                            while ($cat = mysqli_fetch_assoc($category_result)) {
                                                                                $selected = ($cat['id'] == $rows['c_id']) ? 'selected' : '';
                                                                                echo "<option value='{$cat['id']}' $selected>{$cat['c_name']}</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="brand" class="form-label">Brand Name</label>
                                                                        <input type="text" class="form-control" name="brand" value="<?php echo $rows['brand_name']; ?>" required>
                                                                    </div>
                                                                    <div class="col-md-3 mb-3">
                                                                        <label for="mrp_price" class="form-label">MRP Price</label>
                                                                        <input type="number" class="form-control" name="mrp_price" value="<?php echo $rows['mrp_price']; ?>" required>
                                                                    </div>
                                                                    <div class="col-md-3 mb-3">
                                                                        <label for="price" class="form-label">Actual Price</label>
                                                                        <input type="number" class="form-control" name="price" value="<?php echo $rows['price']; ?>" required>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="stock" class="form-label">Stock</label>
                                                                        <input type="number" class="form-control" name="stock" value="<?php echo $rows['stock']; ?>" required>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="reviews" class="form-label">Reviews</label>
                                                                        <input type="number" class="form-control" name="reviews" value="<?php echo $rows['reviews']; ?>" required>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="description" class="form-label">Description</label>
                                                                    <textarea class="form-control" name="description" rows="3" required><?php echo $rows['description']; ?></textarea>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="long_description" class="form-label">Long Description</label>
                                                                    <textarea class="form-control" name="long_description" rows="5" required><?php echo $rows['long_description']; ?></textarea>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="status" class="form-label">Status</label>
                                                                        <select class="form-select" name="status" required>
                                                                            <option value="active" <?php echo ($rows['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                                                                            <option value="inactive" <?php echo ($rows['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="image" class="form-label">Main Image</label>
                                                                        <input type="file" class="form-control" name="image">
                                                                        <?php if (!empty($rows['image'])) { ?>
                                                                            <div class="mt-2">
                                                                                <img src="<?php echo $rows['image']; ?>" alt="Product Image" class="img-thumbnail" width="100">
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="image1" class="form-label">Additional Image 1</label>
                                                                        <input type="file" class="form-control" name="image1">
                                                                        <?php if (!empty($rows['image1'])) { ?>
                                                                            <div class="mt-2">
                                                                                <img src="<?php echo $rows['image1']; ?>" alt="Product Image 1" class="img-thumbnail" width="100">
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="image2" class="form-label">Additional Image 2</label>
                                                                        <input type="file" class="form-control" name="image2">
                                                                        <?php if (!empty($rows['image2'])) { ?>
                                                                            <div class="mt-2">
                                                                                <img src="<?php echo $rows['image2']; ?>" alt="Product Image 2" class="img-thumbnail" width="100">
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="image3" class="form-label">Additional Image 3</label>
                                                                        <input type="file" class="form-control" name="image3">
                                                                        <?php if (!empty($rows['image3'])) { ?>
                                                                            <div class="mt-2">
                                                                                <img src="<?php echo $rows['image3']; ?>" alt="Product Image 3" class="img-thumbnail" width="100">
                                                                            </div>
                                                                        <?php } ?>
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

<!-- Create Product Modal -->
<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="productsCreate.php" enctype="multipart/form-data" id="createProductForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" name="category" required>
                                <?php
                                mysqli_data_seek($category_result, 0); // Reset category result pointer
                                while ($cat = mysqli_fetch_assoc($category_result)) {
                                    echo "<option value='{$cat['id']}'>{$cat['c_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="brand" class="form-label">Brand Name</label>
                            <input type="text" class="form-control" name="brand" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="mrp_price" class="form-label">MRP Price</label>
                            <input type="number" class="form-control" name="mrp_price" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="actual_price" class="form-label">Actual Price</label>
                            <input type="number" class="form-control" name="actual_price" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" name="stock" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="review" class="form-label">Review Rating</label>
                            <input type="number" class="form-control" name="review" required min="0" max="5" step="0.1">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="small_details" class="form-label">Short Description</label>
                        <textarea class="form-control" name="small_details" rows="2" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="long_details" class="form-label">Long Description</label>
                        <textarea class="form-control" name="long_details" rows="4" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="image" class="form-label">Main Image</label>
                            <input type="file" class="form-control image-upload" name="image" data-preview="mainImagePreview" required>
                            <div id="mainImagePreview" class="image-preview mt-2"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="image1" class="form-label">Additional Image 1</label>
                            <input type="file" class="form-control image-upload" name="image1" data-preview="image1Preview">
                            <div id="image1Preview" class="image-preview mt-2"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="image2" class="form-label">Additional Image 2</label>
                            <input type="file" class="form-control image-upload" name="image2" data-preview="image2Preview">
                            <div id="image2Preview" class="image-preview mt-2"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="image3" class="form-label">Additional Image 3</label>
                            <input type="file" class="form-control image-upload" name="image3" data-preview="image3Preview">
                            <div id="image3Preview" class="image-preview mt-2"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="submited">Create Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Image preview functionality
    document.addEventListener('DOMContentLoaded', function() {
        const imageUploads = document.querySelectorAll('.image-upload');

        imageUploads.forEach(input => {
            input.addEventListener('change', function() {
                const previewId = this.getAttribute('data-preview');
                const previewContainer = document.getElementById(previewId);
                previewContainer.innerHTML = '';

                if (this.files && this.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('img-thumbnail');
                        img.style.width = '100px';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        previewContainer.appendChild(img);
                    }

                    reader.readAsDataURL(this.files[0]);
                }
            });
        });

        // Initialize DataTable
        if (typeof $.fn.DataTable !== 'undefined') {
            $('#productsTable').DataTable({
                responsive: true,
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "order": [
                    [0, "desc"]
                ]
            });
        }

        // Search functionality if DataTable is not available
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const searchValue = this.value.toLowerCase();
                const rows = document.querySelectorAll('#productsTable tbody tr');

                rows.forEach(row => {
                    let found = false;
                    const cells = row.querySelectorAll('td');

                    cells.forEach(cell => {
                        if (cell.textContent.toLowerCase().includes(searchValue)) {
                            found = true;
                        }
                    });

                    row.style.display = found ? '' : 'none';
                });
            });
        }

        // Form validation
        const createProductForm = document.getElementById('createProductForm');
        if (createProductForm) {
            createProductForm.addEventListener('submit', function(event) {
                const requiredInputs = createProductForm.querySelectorAll('[required]');
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

<style>
    /* Responsive styles */
    .table-responsive {
        overflow-x: auto;
    }

    .image-preview {
        min-height: 80px;
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

    /* Product info styling */
    .product-info {
        display: flex;
        flex-direction: column;
    }

    /* Modal body scrolling for small screens */
    .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }

    /* Better image thumbnails */
    .img-thumbnail {
        object-fit: cover;
        transition: transform 0.2s;
    }

    .img-thumbnail:hover {
        transform: scale(1.05);
    }
</style>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable with proper configuration
        $('#example2').DataTable({
            "paging": true, // Enables Pagination
            "lengthChange": true, // Show entries dropdown
            "searching": true, // Enables Search
            "ordering": true, // Enables Sorting
            "info": true, // Show table info
            "autoWidth": false, // Auto column width
            "responsive": true, // Make table responsive
            "pageLength": 10, // Default records per page
            "order": [[0, 'desc']],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ], // Options for records per page
            "language": {
                "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>",
                    "next": "<i class='fas fa-chevron-right'></i>"
                }
            }
        });

        // Remove conflicting search functionality from your custom JS
        // since DataTables provides its own search
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                // Let DataTables handle the search
                $('#example2').DataTable().search(this.value).draw();
            });
        }
    });
</script>

<?php
include 'includes/footer.php';
?>