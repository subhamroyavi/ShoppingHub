<?php
// session_start(); 
include 'connection.php';
include 'includes/header.php';
include 'includes/navbar.php';
include 'includes/sidebar.php';

if (empty($_SESSION['admin_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Handle form submission
if (isset($_POST['submit'])) {
    $firstname = !empty($_POST['firstname']) ? mysqli_real_escape_string($conn, $_POST['firstname']) : NULL;
    $lastname = !empty($_POST['lastname']) ? mysqli_real_escape_string($conn, $_POST['lastname']) : NULL;
    $marital_status = !empty($_POST['marital_status']) ? mysqli_real_escape_string($conn, $_POST['marital_status']) : NULL;
    $role = !empty($_POST['role']) ? mysqli_real_escape_string($conn, $_POST['role']) : NULL;
    $status = !empty($_POST['status']) ? mysqli_real_escape_string($conn, $_POST['status']) : NULL;

    // Function to handle image upload
    function uploadImage($file)
    {
        if (isset($file) && $file['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($file['type'], $allowed_types)) {
                return null;
            }

            $file_name = rand(111111111, 999999999) . '_' . basename($file['name']);
            $file_path = 'uploads/' . $file_name;

            if (!is_dir('uploads')) {
                mkdir('uploads', 0755, true);
            }

            if (move_uploaded_file($file['tmp_name'], $file_path)) {
                return $file_path;
            }
        }
        return null;
    }

    // Upload new image if provided
    $image_path = null;
    if (!empty($_FILES['image']['name'])) {
        $image_path = uploadImage($_FILES['image']);
    }

    // Fetch the existing image path if no new image is uploaded
    if (!$image_path) {
        $sql = "SELECT image FROM admin WHERE admin_id = '$admin_id'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $image_path = $row['image'];
        }
    }

    // Update query
    $sql = "UPDATE `admin` SET                
            `firstname` = " . ($firstname === NULL ? "NULL" : "'$firstname'") . ",
            `lastname` = " . ($lastname === NULL ? "NULL" : "'$lastname'") . ",
            `marital_status` = " . ($marital_status === NULL ? "NULL" : "'$marital_status'") . ",
            `type` = " . ($role === NULL ? "NULL" : "'$role'") . ",
            `status` = " . ($status === NULL ? "NULL" : "'$status'") . ",
            `image` = " . ($image_path === NULL ? "NULL" : "'$image_path'") . " 
            WHERE `admin_id` = '$admin_id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('Account details updated successfully!');
        window.location.href='profile.php';
        </script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

if (isset($_POST['submit2'])) {
    $address = !empty($_POST['address']) ? mysqli_real_escape_string($conn, $_POST['address']) : NULL;
    $city = !empty($_POST['city']) ? mysqli_real_escape_string($conn, $_POST['city']) : NULL;
    $pincode = !empty($_POST['pincode']) ? mysqli_real_escape_string($conn, $_POST['pincode']) : NULL;
    $state = !empty($_POST['state']) ? mysqli_real_escape_string($conn, $_POST['state']) : NULL;

    // Update query
    $sql = "UPDATE `admin` SET                
            `address` = " . ($address === NULL ? "NULL" : "'$address'") . ",
            `city` = " . ($city === NULL ? "NULL" : "'$city'") . ",
            `pincode` = " . ($pincode === NULL ? "NULL" : "'$pincode'") . ",
            `state` = " . ($state === NULL ? "NULL" : "'$state'") . "
            WHERE `admin_id` = '$admin_id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('Address details updated successfully!');
        window.location.href='profile.php';
        </script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

// Change password
if (isset($_POST['password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate inputs
    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        echo "<script>alert('All fields are required.');</script>";
    } else {
        // Fetch admin's current password from the database
        $sql = "SELECT password FROM admin WHERE admin_id = $admin_id";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $stored_password = $row['password'];

            // Verify old password
            if ($stored_password === $old_password) {
                // Check if new password and confirm password match
                if ($new_password === $confirm_password) {
                    // Validate new password length
                    if (strlen($new_password) >= 8) {
                        // Update password in the database
                        $sql = "UPDATE admin SET password = '$new_password' WHERE admin_id = '$admin_id'";
                        if (mysqli_query($conn, $sql)) {
                            echo "<script>
                                alert('Password changed successfully!');
                                window.location.href='profile.php';
                            </script>";
                        } else {
                            echo "<script>alert('Error updating password.');</script>";
                        }
                    } else {
                        echo "<script>alert('Password must be at least 8 characters long.');</script>";
                    }
                } else {
                    echo "<script>alert('New password and confirm password do not match.');</script>";
                }
            } else {
                echo "<script>alert('Old password is incorrect.');</script>";
            }
        } else {
            echo "<script>alert('User not found.');</script>";
        }
    }
}

$sql = "SELECT * FROM admin WHERE admin_id = $admin_id";
$result = mysqli_query($conn, $sql);
?>

<div class="app-wrapper">
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">My Account</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">My Account</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Account Details Card (Open by Default) -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Account Details</h3>
                                <!-- Card Tools -->
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <!-- /.form-group -->
                                                    <div class="form-group">
                                                        <label for="firstname">First Name</label>
                                                        <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $row['firstname']; ?>" placeholder="Enter First Name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email">Email Address</label>
                                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" placeholder="Enter Email Address" disabled>
                                                    </div>
                                                    <!-- /.form-group -->
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="lastname">Last Name</label>
                                                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $row['lastname']; ?>" placeholder="Enter Last Name">
                                                    </div>
                                                    <!-- /.form-group -->
                                                    <div class="form-group">
                                                        <label for="phone">Phone Number</label>
                                                        <input type="number" class="form-control" id="phone" name="phone" value="<?php echo $row['phone']; ?>" placeholder="Enter Your Phone Number" disabled>
                                                    </div>
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="role">Staff Role</label>
                                                        <select class="form-control" id="role" name="role">
                                                            <option value="admin" <?php echo ($row['type'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                                            <option value="editor" <?php echo ($row['type'] == 'editor') ? 'selected' : ''; ?>>Editor</option>
                                                            <option value="manager" <?php echo ($row['type'] == 'manager') ? 'selected' : ''; ?>>Manager</option>
                                                            <option value="staff" <?php echo ($row['type'] == 'staff') ? 'selected' : ''; ?>>Staff</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="status">Marital Status</label>
                                                        <select class="form-control" id="status" name="marital_status" disabled>
                                                            <option value="active" <?php echo ($row['marital_status'] == 'married') ? 'selected' : ''; ?>>None</option>
                                                            <option value="inactive" <?php echo ($row['marital_status'] == 'unmarried') ? 'selected' : ''; ?>>Unmarried</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="status">Status</label>
                                                        <select class="form-control" id="status" name="status">
                                                            <option value="active" <?php echo ($row['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                                                            <option value="inactive" <?php echo ($row['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                                            <option value="suspended" <?php echo ($row['status'] == 'suspended') ? 'selected' : ''; ?>>Suspended</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="image" class="form-label">Profile Image</label>
                                                        <input type="file" class="form-control image-upload" name="image" data-preview="mainImagePreview">
                                                        <div id="mainImagePreview" class="image-preview mt-2">
                                                            <?php if (!empty($row['image'])) : ?>
                                                                <img src="<?php echo $row['image']; ?>" alt="Current Image" class="img-thumbnail" style="width: 100px; height: auto;">
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="save_button mt-3">
                                                    <button type="submit" class="btn btn-sm btn-primary" name="submit">
                                                        Submit
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                            </div>
                        </div>

                        <!-- Address Details Card (Closed by Default) -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Address Details</h3>
                                <!-- Card Tools -->
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body collapse">
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- /.form-group -->
                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                <input type="text" class="form-control" id="address" name="address" value="<?php echo $row['address']; ?>" placeholder="Enter Your Address">
                                            </div>
                                            <div class="form-group">
                                                <label for="city">City</label>
                                                <input type="text" class="form-control" id="city" name="city" value="<?php echo $row['city']; ?>" placeholder="Enter City Name">
                                            </div>
                                            <!-- /.form-group -->
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pincode">Pincode</label>
                                                <input type="text" class="form-control" id="pincode" name="pincode" value="<?php echo $row['pincode']; ?>" placeholder="Enter Pincode Number">
                                            </div>
                                            <!-- /.form-group -->
                                            <div class="form-group">
                                                <label for="state">State</label>
                                                <input type="text" class="form-control" id="state" name="state" value="<?php echo $row['state']; ?>" placeholder="Enter Your State Name">
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                        <div class="save_button mt-3">
                                            <button type="submit" class="btn btn-sm btn-primary" name="submit2">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Change Password Card (Closed by Default) -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Change Password</h3>
                                <!-- Card Tools -->
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body collapse">
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="show_password">Show Password</label>
                                                <input type="text" class="form-control" id="show_password" value="<?php echo $row['password']; ?>" placeholder="Enter First Name" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="new_password">New Password</label>
                                                <input type="text" class="form-control" id="new_password" name="new_password" placeholder="Enter New Password">
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="old_password">Old Password</label>
                                                <input type="text" class="form-control" id="old_password" name="old_password" placeholder="Enter Old Password">
                                            </div>
                                            <div class="form-group">
                                                <label for="confirm_password">Confirm Password</label>
                                                <input type="text" class="form-control" id="confirm_password" name="confirm_password" placeholder="Enter Confirm Password">
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                        <div class="save_button mt-3">
                                            <button type="submit" class="btn btn-sm btn-primary" name="password">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                        <?php
                                    }
                                }
                        ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageUploads = document.querySelectorAll('.image-upload');

        imageUploads.forEach(input => {
            input.addEventListener('change', function() {
                const previewId = this.getAttribute('data-preview');
                const previewContainer = document.getElementById(previewId);
                previewContainer.innerHTML = ''; // Clear previous preview

                if (this.files && this.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('img-thumbnail');
                        img.style.width = '100px';
                        img.style.height = 'auto';
                        previewContainer.appendChild(img);
                    }

                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    });
</script>

<?php
include 'includes/footer.php'; // Footer file
?>