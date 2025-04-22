<?php
session_start();
include 'include/connection.php';
// echo $_GET['id'];
// Check if 'id' is provided and is a valid integer
if (isset($_GET['id'])) {
   $id = intval($_GET['id']);
   $cart_id = $_SESSION['cart_id']; // Sanitize the input

    // Prepare the SQL query to prevent SQL injection
    echo $sql = "DELETE FROM `cart_items` WHERE product_id =  $id AND cart_id = $cart_id";
    $stmt = mysqli_query($conn, $sql);

    if ($stmt) {
        echo "<script>
             window.location.href = 'cart.php';
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
