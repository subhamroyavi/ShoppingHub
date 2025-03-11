<?php

include 'connection.php';

echo $id = $_GET['id'];

if (isset($_POST['updateCategory'])) {
    $id = $_GET['id'];
    // if (isset($_GET['id'])) {
    $product_id = mysqli_real_escape_string($conn, $_GET['id']);

    $category = mysqli_real_escape_string($conn, $_POST['categoryName']); // Sanitize input
    $status = mysqli_real_escape_string($conn, $_POST['status']); // Sanitize input

    $check_query = "SELECT * FROM `categories` WHERE `c_name` = '$category'";
    $check_result = mysqli_query($conn, $check_query);


    if (mysqli_num_rows($check_result) == 0) {
        echo "<script>alert('Category already exists!');
                     window.location.href='categories.php';
                </script>";
    } else {
        $sql = "update categories set c_name = '$category', status = '$status' where id = $id";
        $sql_run = mysqli_query($conn, $sql); // Direct query execution

    }

    if ($sql_run) {
        header('Location: categories.php');
        exit(); // Stop script execution
    }
}

$sql = "select * from categories where id = $id";
$sql_run = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($sql_run);

?>


<div class="app-wrapper">
    <main class="app-main"> <!--begin::App Content Header-->
        <div class="app-content-header"> <!--begin::Container-->
            <div class="container-fluid"> <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Edit Category</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Edit Category
                            </li>
                        </ol>
                    </div>
                </div> <!--end::Row-->
            </div> <!--end::Container-->
        </div>


        <div class="container">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Category</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post">
                    <div class="card-body">
                        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                        <div class="form-group">
                            <label for="category">Category Name :</label>
                            <input type="text" class="form-control" id="category" name="category" value="<?php echo $row['name'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="status">Status :</label>
                            <input type="number" class="form-control" id="status" name="status" value="<?php echo $row['status'] ?>">
                        </div>
                        <!-- <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                            </div> -->
                        <!-- <div class="form-group">
                                <label for="exampleInputFile">File input</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Check me out</label>
                            </div> -->
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" name="submit">Update</button>
                        </div>
                </form>
            </div>
            <!-- /.card -->
        </div>





    </main>
</div>

<?php
include 'includes/footer.php';
?>