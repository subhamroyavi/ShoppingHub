<?php
// Include database connection
include 'connection.php';

// Check if the product ID is provided in the URL
if (isset($_GET['id'])) {
    $product_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch the product data from the database
    $sql = "SELECT * FROM products WHERE id = '$product_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $product = mysqli_fetch_assoc($result);
    } else {
        // Redirect if the product is not found
        echo "<script>alert('Product not found.'); window.location.href = 'products.php';</script>";
        exit();
    }
} else {
    // Redirect if no product ID is provided
    header("Location: products.php");
    exit();
}

// Check if the form is submitted
if (isset($_POST['updated'])) {
    // Retrieve and sanitize form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category']);
    $brand_name = mysqli_real_escape_string($conn, $_POST['brand']);
    $mrp_price = mysqli_real_escape_string($conn, $_POST['mrp_price']);
    $actual_price = mysqli_real_escape_string($conn, $_POST['price']);
    $reviews = mysqli_real_escape_string($conn, $_POST['reviews']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $long_description = mysqli_real_escape_string($conn, $_POST['long_description']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Function to upload an image and return the file path
    function uploadImage($file, $conn) {
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

    // Upload main image if a new one is provided
    $image_path = !empty($_FILES['image']['name']) ? uploadImage($_FILES['image'], $conn) : $product['image'];

    // Upload additional images if new ones are provided
    $image1_path = !empty($_FILES['image1']['name']) ? uploadImage($_FILES['image1'], $conn) : $product['image1'];
    $image2_path = !empty($_FILES['image2']['name']) ? uploadImage($_FILES['image2'], $conn) : $product['image2'];
    $image3_path = !empty($_FILES['image3']['name']) ? uploadImage($_FILES['image3'], $conn) : $product['image3'];

    // Get the current timestamp for `update_at`
    $current_time = date('Y-m-d H:i:s');

    // Update the product data in the database
    $sql = "UPDATE products SET
                name = '$name',
                c_id = '$category_id',
                brand_name = '$brand_name',
                mrp_price = '$mrp_price',
                price = '$actual_price',
                reviews = '$reviews',
                description = '$description',
                long_description = '$long_description',
                stock = '$stock',
                status = '$status',
                image = '$image_path',
                image1 = '$image1_path',
                image2 = '$image2_path',
                image3 = '$image3_path',
                update_at = '$current_time'
            WHERE id = '$product_id'";

    if (mysqli_query($conn, $sql)) {
        // Success message and redirect
        echo "<script>
                alert('Product updated successfully!');
                window.location.href = 'products.php';
            </script>";
    } else {
        // Error message if the query fails
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>