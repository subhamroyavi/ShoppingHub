<?php
ob_start(); // Start output buffering

include 'includes/header.php';
include 'includes/navbar.php';
include 'includes/sidebar.php';
include 'connection.php';

if (isset($_POST['createCategory'])) {
    $category = mysqli_real_escape_string($conn, trim($_POST['categoryName'])); // Sanitize input
    $status = mysqli_real_escape_string($conn, $_POST['status']); // Sanitize input

    if (!empty($category)) {
        $sql = "INSERT INTO `categories`(`c_name`, `status`) VALUES ('$category', '$status')";
        $sql_run = mysqli_query($conn, $sql); // Direct query execution

        if ($sql_run) {
            header('Location: categories.php');
            exit(); // Stop script execution
        }
    }
}

?>
