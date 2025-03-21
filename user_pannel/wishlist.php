<?php
session_start();
include "include/connection.php";

// Check if the user is logged in
if (empty($_SESSION['user_id'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

// Check if the request is an AJAX request and contains the product ID
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $wishlist_id = mysqli_real_escape_string($conn, $_POST['id']);
    $user_id = $_SESSION['user_id'];
    $product_id = mysqli_real_escape_string($conn, $_POST['id']);

    // Check if the product is already in the wishlist
    $check_sql = mysqli_query($conn, "SELECT * FROM wishlists WHERE user_id = '$user_id' AND product_id = '$product_id'");
    if (mysqli_num_rows($check_sql) == 0) {
        // Insert the product into the wishlist
        $sql = "INSERT INTO `wishlists`(`user_id`, `product_id`) VALUES ('$user_id', '$product_id')";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['status' => 'info']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>