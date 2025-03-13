<?php
// Include database connection
include 'connection.php';

// Check if the form is submitted
if (isset($_POST['submitted'])) {
    // Retrieve and sanitize form data
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

    $check_email = "SELECT * FROM admin WHERE email = '$email' OR phone = '$phone'";
    $result = mysqli_query($conn, $check_email);
    if (mysqli_num_rows($result) > 0) {
        echo "<script>
                alert('Email or phone number already exists!');
                window.location.href = 'staffs.php';
            </script>";
        exit();
    }

    // Check if the main image was uploaded successfully
    if ($image_path) {
        // Insert data into the database
        $sql = "INSERT INTO `admin` (
                    `firstname`, 
                    `lastname`, 
                    `email`, 
                    `phone`, 
                    `password`, 
                    `image`, 
                    `type`, 
                    `address`, 
                    `city`, 
                    `pincode`, 
                    `state`, 
                    `country`, 
                    `status`
                ) VALUES (
                    '$firstname', 
                    '$lastname', 
                    '$email', 
                    '$phone', 
                    'password', 
                    '$image_path', 
                    '$role', 
                    '$address', 
                    '$city', 
                    '$pincode', 
                    '$state', 
                    '$country', 
                    '$status'
                )";

        if (mysqli_query($conn, $sql)) {
            // Success message and redirect
            echo "<script>
                    alert('Staff added successfully!');
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
        // Error message if the main image upload fails
        echo "<script>
                alert('Error uploading main image.');
                window.location.href = 'staffs.php';
            </script>";
    }
} else {
    // Redirect if the form is not submitted
    echo "<script>
            alert('Form not submitted!');
            window.location.href = 'staffs.php';
        </script>";
}
?>