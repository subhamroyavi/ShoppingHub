<?php
include 'connection.php';

// Check if the request method is POST
if (isset($_POST['order_id'])) {

    // Validate and sanitize input
    $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
    $status = isset($_POST['status']) ? mysqli_real_escape_string($conn, $_POST['status']) : '';
    $payment_status = isset($_POST['payment_status']) ? mysqli_real_escape_string($conn, $_POST['payment_status']) : '';
    $update_order_status = mysqli_query($conn, "UPDATE `orders` SET `status` = '$status', `payment_status` = '$payment_status' WHERE `order_id` = '$order_id'");

    if ($update_order_status) {
        echo "<script>
        window.location.href='orders.php';
   </script>";
    } else {
        echo "<script>
        window.location.href='orders.php';
   </script>";
    }
}
