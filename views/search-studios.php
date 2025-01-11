<?php
include 'controller/functions.php';

require_once 'router.php';
?>

<?php

if (isset($_GET['search-studios'])) {
    // Get search parameters from the query string
    $location = isset($_GET['location']) ? $_GET['location'] : '';
    $min_price = isset($_GET['min_price']) ? (float)$_GET['min_price'] : 0;
    $max_price = isset($_GET['max_price']) ? (float)$_GET['max_price'] : 0;
    $studio_type = isset($_GET['studio_type']) ? $_GET['studio_type'] : '';

    // Base SQL query
    $sql = "SELECT *, 
            CASE 
                WHEN monthly_rate > 0 THEN monthly_rate 
                ELSE original_monthly_rate 
            END AS effective_rate 
            FROM studios WHERE 1=1 AND availability_status = 'available'";

    // Filter by location (address, state, location)
    if (!empty($location)) {
        $location = mysqli_real_escape_string($conn, $location);
        $sql .= " AND (address LIKE '%$location%' OR state LIKE '%$location%' OR location LIKE '%$location%')";
    }

    if (!empty($studio_type)) {
        $studio_type = mysqli_real_escape_string($conn, $studio_type);
        $sql .= " AND (type LIKE '%$studio_type%')";
    }

    // Filter by price range (optional)
    if ($min_price > 0) {
        $sql .= " AND (CASE WHEN monthly_rate > 0 THEN monthly_rate ELSE original_monthly_rate END) >= $min_price";
    }
    if ($max_price > 0) {
        $sql .= " AND (CASE WHEN monthly_rate > 0 THEN monthly_rate ELSE original_monthly_rate END) <= $max_price";
    }

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if there are results

    // Close the connection
    // mysqli_close($conn);
} else {
    // Display all studios when no search criteria are provided
    $sql = "SELECT *, 
            CASE 
                WHEN monthly_rate > 0 THEN monthly_rate 
                ELSE original_monthly_rate 
            END AS effective_rate 
            FROM studios WHERE availability_status = 'available'";

    $result = mysqli_query($conn, $sql);
}

// Check if there are results
if ($result && mysqli_num_rows($result) == 0) {
    // If no results, display a message
    // echo "<p>No studios found matching your criteria.</p>";
}
?>


<?php include 'views/components/header.php'; ?>


<body>
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
                        <!-- <li class="breadcrumb-item"><a href="<?= $base_url ?>">Studio</a></li> -->
                        <li class="breadcrumb-item text-white active" aria-current="page">Studios</li>
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


    <!-- Studio Search Detail Start -->
    <?php
    if (!empty($result) && mysqli_num_rows($result) > 0) {
        // Loop through each studio and display details
    ?>
        <p class="text-center">Found <?= mysqli_num_rows($result); ?> result <?php if (isset($location)) { ?> in <?= $location; ?><?php } ?></p>
        <?php
        while ($studio = mysqli_fetch_assoc($result)) {
            $studio_id = $studio['studio_id'];
            $result_images = getStudioImages($conn, $studio_id);
            $agent_id = $studio['agent_id'];
            $agentDetails = getAgentById($conn, $agent_id);
            $slug = urlencode($studio['slug']); // Adjust according to how you generate the slug
        ?>

            <a href="<?= $base_url ?>/details?studio=<?= $slug ?>" class="studio-link" style="text-decoration: none; color: inherit;">
                <div class="container-fluid pb-5">

                    <div class="row mx-xl-5" style="border: 2px solid lightgrey;">

                        <div class="col-lg-5 mb-30 d-flex align-items-stretch" style="min-height: 400px; max-height: 400px; padding: 0px !important;">
                            <div id="product-carousel-<?= $studio['studio_id']; ?>" class="carousel slide h-100 w-100" data-ride="carousel">
                                <div class="carousel-inner h-100 bg-light">
                                    <?php
                                    $mainImageDisplayed = false;

                                    // Display the main cover image as the first active carousel item
                                    if (!empty($studio['image_cover'])) {
                                    ?>
                                        <div class="carousel-item active h-100">
                                            <img class="d-block w-100 h-100" style="object-fit: cover;" src="uploads/<?= htmlspecialchars($studio['image_cover']); ?>" alt="Main Image">
                                        </div>
                                        <?php
                                        $mainImageDisplayed = true;
                                    }

                                    // Display additional images from the database
                                    if ($result_images && mysqli_num_rows($result_images) > 0) {
                                        while ($image = mysqli_fetch_assoc($result_images)) {
                                            if (!empty($image['image_path'])) {
                                                // If main image is not displayed, use the first `image_path` as the main image
                                                if (!$mainImageDisplayed) {
                                                    $mainImageDisplayed = true;
                                        ?>
                                                    <div class="carousel-item active h-100">
                                                        <img class="d-block w-100 h-100" style="object-fit: cover;" src="uploads/<?= htmlspecialchars($image['image_path']); ?>" alt="Main Image">
                                                    </div>
                                                <?php
                                                } else {
                                                ?>
                                                    <div class="carousel-item h-100">
                                                        <img class="d-block w-100 h-100" style="object-fit: cover;" src="uploads/<?= htmlspecialchars($image['image_path']); ?>" alt="Additional Image">
                                                    </div>
                                    <?php
                                                }
                                            }
                                        }
                                    } else {
                                        // Fallback message if no images are available
                                        echo '<p class="text-center">No images available.</p>';
                                    }
                                    ?>
                                </div>


                                <a class="carousel-control-prev" href="#product-carousel-<?= $studio['studio_id']; ?>" data-slide="prev">
                                    <i class="fa fa-2x fa-angle-left text-dark"></i>
                                </a>
                                <a class="carousel-control-next" href="#product-carousel-<?= $studio['studio_id']; ?>" data-slide="next">
                                    <i class="fa fa-2x fa-angle-right text-dark"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-7 h-auto mb-30">
                            <div class="h-100 bg-light p-30">
                                <h3 class="pt-3"><?= $studio['studio_name']; ?></h3>
                                <small class="bg-primary text-white rounded py-1 px-3"><?php echo $studio['type']; ?></small>
                                <p class="mt-1 mb-0"><?= $studio['address']; ?></p>
                                <!-- <div class="d-flex mb-3">
                                    <div class="text-primary mr-2">
                                        Assume rating is dynamically loaded
                                        <small class="fas fa-star"></small>
                                        <small class="fas fa-star"></small>
                                        <small class="fas fa-star"></small>
                                        <small class="fas fa-star-half-alt"></small>
                                        <small class="far fa-star"></small>
                                    </div>
                                    <small class="pt-1">(<?= $studio['reviews_count']; ?> Reviews)</small>
                                </div> -->
                                <!-- <h3 class="font-weight-semi-bold mb-4">RM <?= number_format($studio['effective_rate'], 2); ?></h3> -->
                                <div class="col-lg-12 d-flex flex-column flex-md-row align-items-start align-items-md-center">
                                    <!-- Pricing Section -->
                                    <div class="flex-grow-1 mb-3 mb-md-0">
                                        <h4 class="fw-bold mb-3 text-md-start">
                                            <?php if ($studio['monthly_rate'] > 0 && $studio['monthly_rate'] < $studio['original_monthly_rate']) { ?>
                                                <p class="py-1" style="font-size: 5vw; font-size: 23px;">
                                                    <span class="text-muted" style="font-size: 18px;"><del>RM <?php echo number_format($studio['original_monthly_rate'], 2); ?></del></span><br>
                                                    RM <?php echo number_format($studio['monthly_rate'], 2); ?>/Month
                                                </p>
                                            <?php } else { ?>
                                                <p class="py-1" style="font-size: 5vw; font-size: 25px;">
                                                    RM <?php echo number_format($studio['original_monthly_rate'], 2); ?>/Month
                                                </p>
                                            <?php } ?>
                                        </h4>
                                    </div>

                                    <!-- Divider -->
                                    <div class="d-none d-md-block mx-5" style="border-right: 1px solid #d4d6d7; height: 100px;"></div>

                                    <!-- Facilities Section -->
                                    <div class="d-flex flex-column flex-md-row gap-2 gap-md-5 mt-3 mt-md-0 text-md-start">
                                        <p class="mb-0" style="font-size: 4vw; font-size: 24px;">
                                            <i class="fa fa-bed text-primary me-2"></i>
                                            <?php echo $studio['master_bedroom'] + $studio['regular_bedroom'] + $studio['small_bedroom']; ?> Bed<?php echo ($studio['master_bedroom'] + $studio['regular_bedroom'] + $studio['small_bedroom']) > 1 ? 's' : ''; ?>
                                        </p>
                                        <p class="mb-0" style="font-size: 4vw; font-size: 24px;">
                                            <i class="fa fa-bath text-primary me-2"></i>
                                            <?php echo $studio['master_bath'] + $studio['regular_bath'] + $studio['small_bath']; ?> Bath<?php echo ($studio['master_bath'] + $studio['regular_bath'] + $studio['small_bath']) > 1 ? 's' : ''; ?>
                                        </p>
                                        <p class="mb-0" style="font-size: 4vw; font-size: 24px;">
                                            <?php echo stripos($studio['facilities'], 'Wi-Fi') !== false ? '<small><i class="fa fa-wifi text-primary me-2"></i>Wi-Fi</small>' : '<small><i class="fa fa-wifi text-muted me-2"></i>No Wifi</small>'; ?>
                                        </p>
                                    </div>

                                    <!-- Bottom Divider (Only on mobile) -->
                                    <div class="d-md-none" style="border-bottom: 1px solid #d4d6d7; width: 100%;"></div>
                                </div>
                                <p class="mb-4"><?php echo htmlspecialchars(truncateDescription($studio['description'], 190)); ?></p>
                                <div class="d-flex align-items-center mb-4 pt-2 gap-3" style="position: relative;">
                                    <!-- Display agent profile image -->
                                    <div class="agent-profile-image mr-3">
                                        <img src="uploads/<?= $agentDetails['image_profile']; ?>" alt="Agent Image" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                                    </div>

                                    <!-- Display agent details -->
                                    <div>
                                        <h5 class="mb-1"><?= $agentDetails['name']; ?></h5>
                                        <p class="mb-0"><?= $agentDetails['business_name']; ?></p>
                                    </div>
                                    <!-- WhatsApp Contact Button -->
                                    <div class="contact-btn mb-4 pt-2">
                                        <a href="https://wa.me/<?= $agentDetails['phone_number']; ?>" target="_blank" class="btn btn-primary px-3">
                                            <i class="fa-brands fa-whatsapp mr-1"></i> Contact via WhatsApp
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </a>
    <?php
        }
    } else {
        // If no results, show a message
        echo "<p class='text-center'>No studios found matching your criteria.</p>";
    }
    ?>

    <!-- Studio Search Detail End -->



    <!-- Products Start -->
    <?php
    if (isset($studio_id)) {
        $result_related = getRelated($conn, 'studios', $studio_id);
    } else {

        $result_related = getRelated($conn, 'studios', 0);
    }

    ?>
    <div class="m-5">
        <h1 class="fw-bold mb-4">You May Also Like</h1>
        <div class="vesitable mb-5">
            <div class="owl-carousel vegetable-carousel justify-content-center">
                <?php
                if (mysqli_num_rows($result_related) > 0) {
                    while ($related_studio = mysqli_fetch_assoc($result_related)) {
                        $studio_name = $related_studio['studio_name'];
                        $studio_description = $related_studio['description'];
                        $studio_price = $related_studio['monthly_rate'] > 0 ? $related_studio['monthly_rate'] : $related_studio['original_monthly_rate'];
                        $studio_cover_image = $related_studio['image_cover'];
                        $studio_url = $base_url . '/details?studio=' . $related_studio['slug'];
                ?>
                        <div class="vesitable-item card border border-primary rounded d-flex flex-column">
                            <div class="vesitable-img">
                                <img src="uploads/<?= $studio_cover_image; ?>" class="img-fluid w-100 rounded-top" alt="<?= $studio_name; ?>">
                            </div>
                            <div class="p-4 pb-0">
                                <h4><?= $studio_name; ?></h4>
                                <small class="bg-primary text-white rounded py-1 px-3"><?php echo $related_studio['type']; ?></small>
                                <p class="mt-2 mb-0"><?= $related_studio['address']; ?></p>
                                <div class="mt-3 d-flex flex-wrap">
                                    <p class="text-dark fs-5 fw-bold">RM <?= number_format($studio_price, 2); ?> / month</p>

                                </div>
                                <p class="mt-0"><?= htmlspecialchars(truncateDescription($studio_description, 120)); ?></p>
                                <a href="<?= $studio_url; ?>" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary" style="position: fixed; bottom: 0px;">
                                    <i class="fa fa-info-circle me-2 text-primary"></i> View Details
                                </a>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo '<p>No related studios found.</p>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Products End -->

    <?php include 'views/components/footer.php'; ?>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <style>
        .carousel-item img {
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        @media (max-width: 768px) {
            .contact-btn {
                position: static;
                /* Adjust this if needed based on your layout */
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {

            /* For medium screens */
            .contact-btn {
                position: absolute;
                right: 5rem;
                bottom: 0;
                /* Adjust this if needed based on your layout */
            }
        }

        @media (min-width: 1025px) {

            /* For medium screens */
            .contact-btn {
                position: absolute;
                right: 5rem;
                bottom: 0;
                /* Adjust this if needed based on your layout */
            }
        }
    </style>
    <Style>
        .vesitable-item {
            display: flex;
            flex-direction: column;
            height: 100%;
            /* Ensures the card stretches fully */
        }

        .vesitable-img img {
            object-fit: cover;
            height: 200px;
            /* Set a fixed height for images */
            width: 100%;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            /* Ensures the content fills the remaining height */
        }

        .card-body .mt-auto {
            margin-top: auto;
        }

        .owl-carousel .vesitable-item {
            min-height: 600px;
            max-height: 600px;
            /* Adjust this value according to your design */
        }


        #map {
            height: 400px;
            width: 100%;
        }

        /* Container to hold the sticky sidebar */
        .sidebar-container {
            position: relative;
        }

        /* Fixed position for the agent profile card */
        .agent-profile-card {
            position: static;
            top: 20px;
            /* Distance from the top of the viewport */
            width: 100%;
            /* Adjust the width as needed */
            max-width: 300px;
            /* Optional: set a maximum width */
            z-index: 1000;
            /* Ensure it stays on top of other content */
        }

        /* Adjust the layout so that content does not overlap */
        .content {
            margin-right: 320px;
            /* Adjust this value based on the width of the fixed card */
        }
    </style>
</body>

</html>