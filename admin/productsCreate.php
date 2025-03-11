<?php
// Include database connection
include 'connection.php';

// Check if the form is submitted
if (isset($_POST['submited'])) {
    // Retrieve and sanitize form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category']);
    $brand_name = mysqli_real_escape_string($conn, $_POST['brand']);
    $mrp_price = mysqli_real_escape_string($conn, $_POST['mrp_price']);
    $actual_price = mysqli_real_escape_string($conn, $_POST['actual_price']);
    $reviews = mysqli_real_escape_string($conn, $_POST['review']);
    $small_details = mysqli_real_escape_string($conn, $_POST['small_details']);
    $long_details = mysqli_real_escape_string($conn, $_POST['long_details']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Function to upload an image and return the file path
    function uploadImage($file, $conn)
    {
        if (isset($file) && $file['error'] == 0) {
            $file_name = rand(111111111, 999999999) . '_' . basename($file['name']); // Generate a unique filename
            $file_path = 'uploads/' . $file_name; // Path to save the file

            // Create the uploads directory if it doesn't exist
            if (!is_dir('uploads')) {
                mkdir('uploads', 0755, true);
            }

            // Move the uploaded file to the uploads directory
            if (move_uploaded_file($file['tmp_name'], $file_path)) {
                return $file_path; // Return the file path if upload is successful
            }
        }
        return null; // Return null if upload fails
    }

    // Upload main image
    $image_path = uploadImage($_FILES['image'], $conn);

    // Upload additional images (image1, image2, image3)
    $image1_path = uploadImage($_FILES['image1'], $conn);
    $image2_path = uploadImage($_FILES['image2'], $conn);
    $image3_path = uploadImage($_FILES['image3'], $conn);

    // Check if the main image was uploaded successfully
    if ($image_path) {
        // Get the current timestamp for `create_at` and `update_at`
        $current_time = date('Y-m-d H:i:s');

        // Insert data into the database
        $sql = "INSERT INTO products (
                    name, c_id, brand_name, mrp_price, price, reviews, description, long_description, stock, status, image, image1, image2, image3
                    ) VALUES (
                    '$name', '$category_id', '$brand_name', '$mrp_price', '$actual_price', '$reviews', '$small_details', '$long_details', '$stock', '$status', '$image_path', '$image1_path', '$image2_path', '$image3_path'
                )";

        if (mysqli_query($conn, $sql)) {
            // Success message and redirect
            echo "<script>
                    alert('Product added successfully!');
                    window.location.href = 'products.php';
                </script>";
        } else {
            // Error message if the query fails
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        // Error message if the main image upload fails
        echo "<script>alert('Error uploading main image.');</script>";
    }
} else {
    // Redirect if the form is not submitted
    header("Location: products.php");
    exit();
}
