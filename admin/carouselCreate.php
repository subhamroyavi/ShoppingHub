<?php
include 'includes/header.php';
include 'includes/navbar.php';
include 'includes/sidebar.php';
include 'connection.php';

if (isset($_POST['submit'])) {
    // Retrieve and sanitize form data
    $banner = mysqli_real_escape_string($conn, $_POST['name']);
    $subtitle = mysqli_real_escape_string($conn, $_POST['subtitle']); // Use category ID instead of name
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $file = rand(111111111, 999999999); // Generate a random number for the filename
        $file_name = $file . '_' . basename($_FILES['image']['name']); // Append random number to the filename
        $file_path = 'uploads/' . $file_name;

        // Move the uploaded file to the "uploads" directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {
            // Insert data into the database
            $sql = "INSERT INTO `carousel`(`carousel_name`, `title`, `subtitle`, `status`, `image`) VALUES ('$banner','$subtitle','$title','$status','$file_path')";

            if (mysqli_query($conn, $sql)) {
                echo "<script>
                        alert('Product added successfully!');
                        window.location.href = 'carousel.php';
                    </script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('Error uploading file.');</script>";
        }
    } else {
        echo "<script>alert('No file uploaded or there was an error during the upload.');</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
    <!-- Add your CSS and JS files here -->
</head>

<body>
    <div class="app-wrapper">
        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Create Banner</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Create Banner</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add Banner</h3>
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="banner">Banner Name:</label>
                                <input type="text" class="form-control" id="banner" name="name" placeholder="Enter banner name" required>
                            </div>

                            
                            <div class="form-group">
                                <label for="subtitle">Subtitle:</label>
                                <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Enter subtitle" required>
                            </div>
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="image">Product Image:</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <?php
    include 'includes/footer.php';
    ?>

</body>

</html>