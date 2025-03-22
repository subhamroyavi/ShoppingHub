<?php
include 'include/connection.php';
$_GET['id'];
// Check if 'id' is provided and is a valid integer
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the input

    // Prepare the SQL query to prevent SQL injection
    $sql = "DELETE FROM `wishlists` WHERE wishlist_id =  $id";
    $stmt = mysqli_query($conn, $sql);

    if ($stmt) {
        echo "<script>
             window.location.href = 'wishlist.php';
             </script>";
    } else {
        // Handle query execution error
        echo "<script>
            alert('Error deleting item.');
             window.location.href = 'index.php';
             </script>";
    }
} else {
    // Handle statement preparation error
    echo "<script>
        alert('Error preparing query.');
        window.location.href = 'index.php';
        </script>";
}
?>
