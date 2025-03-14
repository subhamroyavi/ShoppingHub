<?php
session_start();
include "connection.php";

$sql = "SELECT * FROM `admin` WHERE admin_id = '$_SESSION[admin_id]'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$_SESSION['admin_id'] = $row['admin_id'];
$_SESSION['admin_email'] = $row['email'];
$_SESSION['admin_phone'] = $row['phone'];
$_SESSION['firstname'] = $row['firstname'];
$_SESSION['lastname'] = $row['lastname'];
$_SESSION['image'] = $row['image'];

?>
<!-- <nav class="app-header navbar navbar-expand bg-body"> -->
<nav class="app-header navbar navbar-expand bg-light" data-bs-theme="light">
    <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="bi bi-list"></i> </a> </li>
            <li class="nav-item d-none d-md-block"> <a href="#" class="nav-link">Home</a> </li>
            <li class="nav-item d-none d-md-block"> <a href="#" class="nav-link">Contact</a> </li>
        </ul> <!--end::Start Navbar Links--> <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto"> <!--begin::Navbar Search-->
            <li class="nav-item"> <a class="nav-link" data-widget="navbar-search" href="#" role="button"> <i class="bi bi-search"></i> </a> </li> <!--end::Navbar Search--> <!--begin::Messages Dropdown Menu-->

            <!--end::Notifications Dropdown Menu--> <!--begin::Fullscreen Toggle-->
            <li class="nav-item"> <a class="nav-link" href="#" data-lte-toggle="fullscreen"> <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i> <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i> </a> </li> <!--end::Fullscreen Toggle--> <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="<?php echo $_SESSION['image']; ?>" class="user-image rounded-circle shadow" alt="User Image">
                    <span class="d-none d-md-inline"><?php echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> <!--begin::User Image-->
                    <li class="user-header text-bg-primary"> <img src="<?php echo $_SESSION['image']; ?>" class="rounded-circle shadow" alt="User Image">
                        <p>
                            <?php echo $_SESSION['admin_email']; ?>

                            <small></small>
                        </p>
                    </li> <!--end::User Image--> <!--begin::Menu Body-->
                    <!--end::Menu Body--> <!--begin::Menu Footer-->
                    <li class="user-footer">
                        <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
                        <a href="logout.php" class="btn btn-default btn-flat float-end">Sign out</a>
                    </li> <!--end::Menu Footer-->
                </ul>
            </li> <!--end::User Menu Dropdown-->
        </ul> <!--end::End Navbar Links-->
    </div> <!--end::Container-->
</nav> <!--end::Header-->