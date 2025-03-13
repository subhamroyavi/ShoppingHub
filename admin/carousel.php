<?php
include 'connection.php';
include 'includes/header.php';
include 'includes/navbar.php';
include 'includes/sidebar.php';

if (empty($_SESSION['admin_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit();
}

$sql = "SELECT * FROM carousel";
$sql_run = mysqli_query($conn, $sql);

?>


<div class="app-wrapper">
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Carousel</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Carousel</li>
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
                                        <a href="carouselCreate.php" class="btn btn-success">
                                            <i class="fas fa-plus me-2"></i>Create Carousel
                                        </a>
                                    </div>

                                </div>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="carouselTable" class="table table-bordered table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Banner Name</th>
                                            <th>Subtitle</th>
                                            <th>Title</th>
                                            <th>Image</th>
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
                                                <td><?php echo $rows['carousel_name']; ?></td>
                                                <td><?php echo $rows['subtitle']; ?></td>
                                                <td><?php echo $rows['title']; ?></td>
                                                <td>
                                                    <img src="<?php echo $rows['image']; ?>" alt="Carousel Image" class="img-thumbnail" width="50" height="50">
                                                </td>
                                                <td>
                                                    <?php
                                                    $status_class = ($rows['status'] == 'active') ? 'success' : 'danger';
                                                    ?>
                                                    <span class="badge bg-<?php echo $status_class; ?>"><?php echo ucfirst($rows['status']); ?></span>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editCarouselModal<?php echo $rows['id']; ?>">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                        <a href="carouselDelete.php?id=<?php echo $rows['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this carousel?')">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Edit Carousel Modal -->
                                            <div class="modal fade" id="editCarouselModal<?php echo $rows['id']; ?>" tabindex="-1" aria-labelledby="editCarouselModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Carousel: <?php echo $rows['carousel_name']; ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post" action="carouselEdit.php?id=<?php echo $rows['id']; ?>" enctype="multipart/form-data">
                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="name" class="form-label">Banner Name</label>
                                                                        <input type="text" class="form-control" name="name" value="<?php echo $rows['carousel_name']; ?>" required>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="subtitle" class="form-label">Subtitle</label>
                                                                        <input type="text" class="form-control" name="subtitle" value="<?php echo $rows['subtitle']; ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="title" class="form-label">Title</label>
                                                                        <input type="text" class="form-control" name="title" value="<?php echo $rows['title']; ?>" required>
                                                                    </div>
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
                                                                        <label for="image" class="form-label">Image</label>
                                                                        <input type="file" class="form-control" name="image">
                                                                        <?php if (!empty($rows['image'])) { ?>
                                                                            <div class="mt-2">
                                                                                <img src="<?php echo $rows['image']; ?>" alt="Carousel Image" class="img-thumbnail" width="100">
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary" name="update">Save Changes</button>
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
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#carouselTable').DataTable({
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

        // Custom search functionality
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                $('#carouselTable').DataTable().search(this.value).draw();
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


<?php
include 'includes/footer.php';
?>