<?php
// Include database connection
include 'connection.php';

// echo $staff_id = $_GET['id'];

// Check if the form is submitted
if (isset($_POST['updated'])) {

    // Retrieve and sanitize form data
    $staff_id = mysqli_real_escape_string($conn, $_GET['id']); // Staff ID to update
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $pincode = mysqli_real_escape_string($conn, $_POST['pincode']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Function to upload an image and return the file path
    function uploadImage($file, $conn)
    {
        if (isset($file) && $file['error'] == 0) {
            // Validate file type
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($file['type'], $allowed_types)) {
                return null; // Invalid file type
            }

            // Generate a unique filename
            $file_name = rand(111111111, 999999999) . '_' . basename($file['name']);
            $file_path = 'uploads/' . $file_name;

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

    // Upload new image if provided
    $image_path = null;
    if (!empty($_FILES['image']['name'])) {
        $image_path = uploadImage($_FILES['image'], $conn);
    }

    // Fetch the existing image path if no new image is uploaded
    if (!$image_path) {
        $sql = "SELECT image FROM admin WHERE admin_id = '$staff_id'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $image_path = $row['image'];
        }
    }

    // Update data in the database
    $sql = "UPDATE admin SET
                firstname = '$firstname',
                lastname = '$lastname',
                email = '$email',
                phone = '$phone',
                address = '$address',
                city = '$city',
                pincode = '$pincode',
                state = '$state',
                country = '$country',
                type = '$role',
                status = '$status',
                image = '$image_path'
            WHERE admin_id = '$staff_id'";

    if (mysqli_query($conn, $sql)) {
        // Success message and redirect
        echo "<script>
                alert('Staff updated successfully!');
                window.location.href = 'staffs.php';
            </script>";
    } else {
        // Error message if the query fails
        echo "<script>
                alert('Error: " . mysqli_error($conn) . "');
                window.location.href = 'staffs.php';
            </script>";
    }
} else {
    // Redirect if the form is not submitted
    header("Location: staffs.php");
    exit();
}
?>