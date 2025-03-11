<?php 
include 'connection.php';

// Validate and sanitize the ID from the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('Invalid carousel ID.'); window.location.href = 'carousel.php';</script>";
    exit;
}   
$id = intval($_GET['id']);

// Fetch the carousel item from the database
$carousel_sql = "delete FROM carousel WHERE id = $id";
$carousel_sql_run = mysqli_query($conn, $carousel_sql); 

if (!$carousel_sql_run) {
    echo "<script>alert('Carousel item not found.'); window.location.href = 'carousel.php';</script>";
    exit;
}

echo "<script>alert('Carousel item deleted successfully.'); window.location.href = 'carousel.php';</script>";
exit;   



?>