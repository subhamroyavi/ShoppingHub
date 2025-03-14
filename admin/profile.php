<?php
// session_start(); // Ensure sessions are started
include 'connection.php'; // Database connection
include 'includes/header.php'; // Header file
include 'includes/navbar.php'; // Navbar file
include 'includes/sidebar.php'; // Sidebar file
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Minimal</label>
                                            <select class="form-control select2bs4" style="width: 100%;">
                                                <option selected="selected">Alabama</option>
                                                <option>Alaska</option>
                                                
                                                <option>Washington</option>
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <label>Minimal</label>
                                            <select class="form-control select2bs4" style="width: 100%;">
                                                <option selected="selected">Alabama</option>
                                                <option>Alaska</option>
                                                
                                                <option>Washington</option>
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-6">
                                    <div class="form-group">
                                            <label>Minimal</label>
                                            <select class="form-control select2bs4" style="width: 100%;">
                                                <option selected="selected">Alabama</option>
                                                <option>Alaska</option>
                                                
                                                <option>Washington</option>
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <label>Minimal</label>
                                            <select class="form-control select2bs4" style="width: 100%;">
                                                <option selected="selected">Alabama</option>
                                                <option>Alaska</option>
                                                
                                                <option>Washington</option>
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col -->
                                </div>
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
                            <div class="card-body collapse" id="addressDetails">
                                This is the card body content. Click the minus button to collapse or the times button to remove this card.
                            </div>
                        </div>

                        <!-- Another Card (Closed by Default) -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Card Title</h3>
                                <!-- Card Tools -->
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body collapse" id="anotherCard">
                                This is the card body content. Click the minus button to collapse or the times button to remove this card.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

<?php
include 'includes/footer.php'; // Footer file
?>