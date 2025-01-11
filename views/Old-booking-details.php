<?php
include 'controller/functions.php';

if (isset($_GET['studio'])) {
    $slug = $_GET['studio'];
    $studioDetailsResult = getBySlug($conn, 'studios', $slug);

    // Fetch the studio details
    if (mysqli_num_rows($studioDetailsResult) > 0) {
        $studioDetails = mysqli_fetch_assoc($studioDetailsResult);
    } else {
        // Redirect if no details found
        header("Location: $base_url");
        exit();
    }
} else {
    // Redirect to base URL if no studio is specified
    header("Location: $base_url");
    exit();
}
require_once 'router.php';
?>

<?php include 'views/components/header.php'; ?>

<body>
    <div class="container-xxl bg-white p-0" style="max-width: 100%;">

        <?php // include 'views/components/spinner.php'; 
        ?>

        <?php include 'views/components/navbar.php'; ?>


        <!-- Page Header Start -->
        <div class="container-fluid page-header mb-5 p-0" style="background-image: url(img/carousel-1.jpg);">
            <div class="container-fluid page-header-inner py-5">
                <div class="container text-center pb-5">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Booking</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="<?= $base_url ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?= $base_url ?>">Studio</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page"><?= htmlspecialchars($studioDetails['studio_name']) ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page Header End -->


        <!-- Booking Start -->
        <div class="container-fluid booking pb-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container">
                <div class="bg-white shadow" style="padding: 35px;">
                    <?php include 'views/components/search.php'; ?>
                </div>
            </div>
        </div>
        <!-- Booking End -->


        <!-- Room Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase">Studio Details</h6>
                    <h1 class="mb-5"><?= htmlspecialchars($studioDetails['studio_name']) ?></h1>
                </div>

                <?php
                // Fetch studio details

                // Fetch agent details associated with the studio
                if ($studioDetails) {
                    $agent_id = $studioDetails['agent_id'];
                    $agentDetails = getAgentById($conn, $agent_id);
                } else {
                    echo "Studio not found.";
                    die();
                }
                ?>

                <div class="row">
                    <!-- Studio Details Card -->
                    <div class="col-lg-8 col-md-12">
                        <div class="room-item shadow rounded overflow-hidden h-100">
                            <div class="position-relative">
                                <img class="img-fluid" src="uploads/<?php echo $studioDetails['image_cover']; ?>" alt="">

                            </div>
                            <div class="p-4 mt-2">
                                <div class="d-flex justify-content-between mb-3">
                                    <h5 class="mb-0"><?php echo htmlspecialchars($studioDetails['studio_name']); ?></h5>
                                    <div class="ps-2">
                                        <!-- Placeholder for stars, can be replaced with actual rating logic -->
                                        <small class="fa fa-star text-primary"></small>
                                        <small class="fa fa-star text-primary"></small>
                                        <small class="fa fa-star text-primary"></small>
                                        <small class="fa fa-star text-primary"></small>
                                        <small class="fa fa-star text-primary"></small>
                                    </div>
                                </div>
                                <div class="d-flex gap-3 mb-3">
                                    <p class="text-body mb-3"><?php echo htmlspecialchars($studioDetails['address']); ?></p>
                                    <p class="text-primary mb-3">See Map</p>
                                </div>
                                <div class="d-flex gap-3 mb-3 align-items-center">
                                    <div>
                                        <?php if ($studioDetails['monthly_rate'] > 0 && $studioDetails['monthly_rate'] < $studioDetails['original_monthly_rate']) { ?>
                                            <p class="py-1" style="font-size: 25px;">
                                                <span style="text-decoration: line-through; color: red;">RM <?php echo number_format($studioDetails['original_monthly_rate'], 2); ?></span>
                                                RM <?php echo number_format($studioDetails['monthly_rate'], 2); ?>/Month
                                            </p>
                                        <?php } else { ?>
                                            <p class="py-1" style="font-size: 25px;">
                                                RM <?php echo number_format($studioDetails['original_monthly_rate'], 2); ?>/Month
                                            </p>
                                        <?php } ?>
                                    </div>
                                    <small class="border-end me-3 pe-3"></small>
                                    <div class="d-flex mb-3">
                                        <small class="border-end me-3 pe-3"><i class="fa fa-bed text-primary me-2"></i><?php echo $studioDetails['master_bedroom'] + $studioDetails['regular_bedroom'] + $studioDetails['small_bedroom']; ?> Bed<?php echo ($studioDetails['master_bedroom'] + $studioDetails['regular_bedroom'] + $studioDetails['small_bedroom']) > 1 ? 's' : ''; ?></small>
                                        <small class="border-end me-3 pe-3"><i class="fa fa-bath text-primary me-2"></i><?php echo $studioDetails['master_bath'] + $studioDetails['regular_bath'] + $studioDetails['small_bath']; ?> Bath<?php echo ($studioDetails['master_bath'] + $studioDetails['regular_bath'] + $studioDetails['small_bath']) > 1 ? 's' : ''; ?></small>
                                        <?php echo stripos($studioDetails['facilities'], 'Wi-Fi') !== false ? '<small><i class="fa fa-wifi text-primary me-2"></i>Wifi</small>' : '<small><i class="fa fa-wifi text-muted me-2"></i>No Wifi</small>'; ?>
                                    </div>
                                </div>
                               
                                <p class="text-body mb-3"><?php echo htmlspecialchars(truncateDescription($studioDetails['description'], 150)); ?></p>
                                <div class="d-flex justify-content-between">
                                    <a class="btn btn-sm btn-primary rounded py-2 px-4" href="#">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <!-- Agent Details Card -->
                <div class="col-lg-4 col-md-12">
                    <div class="card shadow rounded overflow-hidden">
                        <img class="card-img-top" src="uploads/<?php echo $agentDetails['image_profile']; ?>" alt="Agent Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($agentDetails['business_name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($agentDetails['name']); ?></p>
                            <p class="card-text"><?php echo htmlspecialchars($agentDetails['phone_number']); ?></p>
                            <a href="https://wa.me/<?php echo htmlspecialchars($agentDetails['phone_number']); ?>" class="btn btn-success"><i class="fa fa-whatsapp"></i> Contact on WhatsApp</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- Room End -->



        <!-- Newsletter Start -->
        <div class="container newsletter mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="row justify-content-center">
                <div class="col-lg-10 border rounded p-1">
                    <div class="border rounded text-center p-1">
                        <div class="bg-white rounded text-center p-5">
                            <h4 class="mb-4">Subscribe Our <span class="text-primary text-uppercase">Newsletter</span></h4>
                            <div class="position-relative mx-auto" style="max-width: 400px;">
                                <input class="form-control w-100 py-3 ps-4 pe-5" type="text" placeholder="Enter your email">
                                <button type="button" class="btn btn-primary py-2 px-3 position-absolute top-0 end-0 mt-2 me-2">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Newsletter Start -->


        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-light footer wow fadeIn" data-wow-delay="0.1s">
            <div class="container pb-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-4">
                        <div class="bg-primary rounded p-4">
                            <a href="index.html">
                                <h1 class="text-white text-uppercase mb-3">Hotelier</h1>
                            </a>
                            <p class="text-white mb-0">
                                Download <a class="text-dark fw-medium" href="https://htmlcodex.com/hotel-html-template-pro">Hotelier – Premium Version</a>, build a professional website for your hotel business and grab the attention of new visitors upon your site’s launch.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h6 class="section-title text-start text-primary text-uppercase mb-4">Contact</h6>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12">
                        <div class="row gy-5 g-4">
                            <div class="col-md-6">
                                <h6 class="section-title text-start text-primary text-uppercase mb-4">Company</h6>
                                <a class="btn btn-link" href="">About Us</a>
                                <a class="btn btn-link" href="">Contact Us</a>
                                <a class="btn btn-link" href="">Privacy Policy</a>
                                <a class="btn btn-link" href="">Terms & Condition</a>
                                <a class="btn btn-link" href="">Support</a>
                            </div>
                            <div class="col-md-6">
                                <h6 class="section-title text-start text-primary text-uppercase mb-4">Services</h6>
                                <a class="btn btn-link" href="">Food & Restaurant</a>
                                <a class="btn btn-link" href="">Spa & Fitness</a>
                                <a class="btn btn-link" href="">Sports & Gaming</a>
                                <a class="btn btn-link" href="">Event & Party</a>
                                <a class="btn btn-link" href="">GYM & Yoga</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">Your Site Name</a>, All Right Reserved.

                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="">Home</a>
                                <a href="">Cookies</a>
                                <a href="">Help</a>
                                <a href="">FQAs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>