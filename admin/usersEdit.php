<?php
// Include database connection
include 'connection.php';

// Check if the user ID is provided in the URL
if (isset($_GET['id'])) {
    $user_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Check if the form is submitted
    if (isset($_POST['updated'])) {
        // Get the updated status from the form
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        // Update the user's status in the database
        $sql = "UPDATE users SET status = '$status' WHERE user_id = '$user_id'";

        if (mysqli_query($conn, $sql)) {
            // Success message and redirect
            echo "<script>
                alert('User updated successfully!');
                window.location.href = 'users.php';
            </script>";
        } else {
            // Error message
            echo "<script>
                alert('Error updating user: " . mysqli_error($conn) . "');
                window.location.href = 'users.php';
            </script>";
        }
    }
} else {
    // Redirect if no user ID is provided
    header("Location: users.php");
    exit();
}
?>