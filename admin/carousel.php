<?php
include 'connection.php';
include 'includes/header.php';
include 'includes/navbar.php';
include 'includes/sidebar.php';

$sql = "SELECT * FROM carousel";
$sql_run = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carousel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
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
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
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
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div>
                                                <a href="carouselCreate.php" class="btn btn-success">Create Carousel</a>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div id="example1_filter" class="dataTables_filter">
                                                <label for="search-input">Search:</label>
                                                <input id="search-input" type="search" class="form-control form-control-sm" placeholder="Type to search..." aria-controls="example1">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Sl No.</th>
                                                <th>Banner Name</th>
                                                <th>Subtitle</th>
                                                <th>Title</th>
                                                <th>Image</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            while ($rows = mysqli_fetch_assoc($sql_run)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $i;
                                                        $i++; ?></td>
                                                    <td><?php echo $rows['carousel_name']; ?></td>
                                                    <td><?php echo $rows['subtitle']; ?></td>
                                                    <td><?php echo $rows['title']; ?></td>
                                                    <td><?php echo "<img src='{$rows['image']}' alt='Product Image' width='100' height='100'>"; ?></td>
                                                    <td><?php echo $rows['status']; ?></td>
                                                    <td>
                                                        <!-- Edit Button to Trigger Modal -->
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editCarouselModal<?php echo $rows['id']; ?>">
                                                            Edit
                                                        </button>
                                                        <a href="carouselDelete.php?id=<?php echo $rows['id']; ?>" class="btn btn-danger">Delete</a>
                                                    </td>
                                                </tr>

                                                <!-- Edit Carousel Modal for Each Row -->
                                                <div class="modal fade" id="editCarouselModal<?php echo $rows['id']; ?>" tabindex="-1" aria-labelledby="editCarouselModalLabel<?php echo $rows['id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editCarouselModalLabel<?php echo $rows['id']; ?>">Edit Carousel</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Edit Carousel Form -->
                                                                <form method="post" action="carouselEdit.php?id=<?php echo $rows['id']; ?>" enctype="multipart/form-data">
                                                                    <div class="form-group">
                                                                        <label for="name">Banner Name:</label>
                                                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $rows['carousel_name']; ?>" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="subtitle">Subtitle:</label>
                                                                        <input type="text" class="form-control" id="subtitle" name="subtitle" value="<?php echo $rows['subtitle']; ?>" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="title">Title:</label>
                                                                        <input type="text" class="form-control" id="title" name="title" value="<?php echo $rows['title']; ?>" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="status">Status:</label>
                                                                        <select class="form-control" id="status" name="status" required>
                                                                            <option value="active" <?php echo ($rows['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                                                                            <option value="inactive" <?php echo ($rows['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="image">Image:</label>
                                                                        <input type="file" class="form-control" id="image" name="image">
                                                                        <?php if (!empty($rows['image'])): ?>
                                                                            <img src="../admin/<?php echo $rows['image']; ?>" alt="Current Image" width="100" style="margin-top: 10px;">
                                                                        <?php endif; ?>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Sl No.</th>
                                                <th>Banner Name</th>
                                                <th>Subtitle</th>
                                                <th>Title</th>
                                                <th>Image</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
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
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
</body>

</html>

<?php
include 'includes/footer.php';
?>