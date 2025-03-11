<?php
include 'includes/header.php';
include 'includes/navbar.php';
include 'includes/sidebar.php';
include 'connection.php';

// Validate and sanitize the ID from the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('Invalid carousel ID.'); window.location.href = 'carousel.php';</script>";
    exit;
}
$id = intval($_GET['id']);

// Fetch the carousel item from the database
$carousel_sql = "SELECT * FROM carousel WHERE id = $id";
$carousel_sql_run = mysqli_query($conn, $carousel_sql);

if (!$carousel_sql_run || mysqli_num_rows($carousel_sql_run) === 0) {
    echo "<script>alert('Carousel item not found.'); window.location.href = 'carousel.php';</script>";
    exit;
}
$carousel = mysqli_fetch_assoc($carousel_sql_run);

// Handle form submission
if (isset($_POST['update'])) {
    // Retrieve and sanitize form data
    $banner = mysqli_real_escape_string($conn, $_POST['name']);
    $subtitle = mysqli_real_escape_string($conn, $_POST['subtitle']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Initialize image path with the existing image
    $image_path = $carousel['image'];

    // Handle image upload if a new file is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image'];
        $image_name = basename($image['name']); // Get the file name
        $image_tmp = $image['tmp_name']; // Get the temporary file path

        // Create a unique file name to avoid conflicts
        $image_name = uniqid() . '_' . $image_name;

        // Define the upload directory
        $upload_dir = 'uploads/';

        // Ensure the upload directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Delete the old image file if it exists
        if (!empty($carousel['image']) && file_exists($carousel['image'])) {
            unlink($carousel['image']); // Delete the old image file
        }

        // Move the uploaded file to the upload directory
        $image_path = $upload_dir . $image_name;
        if (!move_uploaded_file($image_tmp, $image_path)) {
            echo "<script>alert('Error uploading image.');</script>";
            exit;
        }
    }

    // Update carousel data in the database
    $update_sql = "UPDATE carousel
                   SET carousel_name = '$banner', 
                       subtitle = '$subtitle', 
                       title = '$title', 
                       image = '$image_path', 
                       status = '$status' 
                   WHERE id = $id";

    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Carousel updated successfully!'); window.location.href = 'carousel.php';</script>";
        exit;
    } else {
        echo "<script>alert('Error updating carousel: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Carousel</title>
    <!-- Add your CSS and JS files here -->
</head>
<body>
    <div class="container">
        <h2>Edit Carousel</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Banner Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $carousel['carousel_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="subtitle">Subtitle:</label>
                <input type="text" class="form-control" id="subtitle" name="subtitle" value="<?php echo $carousel['subtitle']; ?>" required>
            </div>
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $carousel['title']; ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="active" <?php echo ($carousel['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                    <option value="inactive" <?php echo ($carousel['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control" id="image" name="image">
                <?php if (!empty($carousel['image'])): ?>
                    <img src="../admin/<?php echo $carousel['image']; ?>" alt="Current Image" width="100" style="margin-top: 10px;">
                <?php endif; ?>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>

<?php
include 'includes/footer.php';
?>