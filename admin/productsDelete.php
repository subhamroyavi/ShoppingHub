<?php
ob_start(); // Start output buffering

include 'includes/header.php';
include 'includes/navbar.php';
include 'includes/sidebar.php';
include 'connection.php';

echo $id = $_GET['id'];
$sql = "delete from products where id = $id";
$sql_run = mysqli_query($conn, $sql); // Direct query execution

if ($sql_run) {
  echo "<script>
                        alert('Data deleted successfully!');
                        window.location.href = 'products.php';
                      </script>";
  exit;
}
