<?php include 'config.php'; ?>
<!-- Header Start -->
<div class="container-fluid bg-dark px-0">
    <div class="row gx-0">
        <div class="col-lg-3 bg-dark d-none d-lg-block">
            <a href="<?php echo $base_url ?>" class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                <h2 class="m-0 text-primary text-uppercase"><?php echo $system_name; ?></h2>
            </a>
        </div>
        <div class="col-lg-9">
            <div class="row gx-0 bg-white d-none d-lg-flex">
                <div class="col-lg-7 px-5 text-start">
                    <div class="h-100 d-inline-flex align-items-center py-2 me-4">
                        <i class="fa fa-envelope text-primary me-2"></i>
                        <p class="mb-0"><?= $email; ?></p>
                    </div>
                    <div class="h-100 d-inline-flex align-items-center py-2">
                        <i class="fa fa-phone-alt text-primary me-2"></i>
                        <p class="mb-0"><?= $number_phone; ?></p>
                    </div>
                </div>
                <div class="col-lg-5 px-5 text-end">
                    <div class="d-inline-flex align-items-center py-2">
                        <a class="me-3" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="me-3" href=""><i class="fab fa-twitter"></i></a>
                        <a class="me-3" href=""><i class="fab fa-linkedin-in"></i></a>
                        <a class="me-3" href=""><i class="fab fa-instagram"></i></a>
                        <a class="" href=""><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark p-3 p-lg-0">
                <a href="<?php echo $base_url ?>" class="navbar-brand d-block d-lg-none">
                    <h2 class="m-0 text-primary text-uppercase"><?php echo $system_name; ?></h2>
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="<?php echo $base_url ?>" class="nav-item nav-link active">Home</a>
                        <!-- <a href="" class="nav-item nav-link">About</a> -->
                        <a href="<?php echo $base_url ?>/search-studios" class="nav-item nav-link">Studios</a>
                        <!-- <a href="" class="nav-item nav-link">Booking</a> -->
                        <!-- <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="" class="dropdown-item">Booking</a>
                                <a href="" class="dropdown-item">Our Team</a>
                                <a href="" class="dropdown-item">Testimonial</a>
                            </div>
                        </div> -->
                        <!-- <a href="" class="nav-item nav-link">Contact</a> -->
                    </div>
                    <?php if (isset($_SESSION['email'])): ?>
                        <?php if ($_SESSION['user_type'] == 'agent'): ?>
                            <!-- Button to trigger the modal if the user is logged in -->
                            <a href="<?php echo $base_url ?>/agent/dashboard" class="btn btn-primary rounded-0 py-4 px-md-5 d-none d-lg-block">Homepage<i class="fa fa-arrow-right ms-3"></i></a>
                        <?php elseif ($_SESSION['user_type'] == 'admin'): ?>
                            <a href="<?php echo $base_url ?>/admin/dashboard" class="btn btn-primary rounded-0 py-4 px-md-5 d-none d-lg-block">Homepage<i class="fa fa-arrow-right ms-3"></i></a>
                        <?php else: ?>
                            <a href="<?php echo $base_url ?>/homepage" class="btn btn-primary rounded-0 py-4 px-md-5 d-none d-lg-block">Homepage<i class="fa fa-arrow-right ms-3"></i></a>
                        <?php endif; ?>

                    <?php else: ?>
                        <a href="<?php echo $base_url ?>/log-in" class="btn btn-primary rounded-0 py-4 px-md-5 d-none d-lg-block">Login<i class="fa fa-arrow-right ms-3"></i></a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Header End -->