<?php
ob_start(); // Start output buffering

include 'includes/header.php';
include 'includes/navbar.php';
include 'includes/sidebar.php';
include 'connection.php';

$id = $_GET['id'];


$sql = "delete from categories where id = $id";

$sql_run = mysqli_query($conn, $sql); // Direct query execution

if ($sql_run) {
    header('Location: categories.php');
    exit(); // Stop script execution
}

?>