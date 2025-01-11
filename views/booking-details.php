<?php
include 'controller/functions.php';

if (isset($_GET['studio'])) {
    $slug = $_GET['studio'];
    $studioDetailsResult = getBySlug($conn, 'studios', $slug);

    // Fetch the studio details
    if (mysqli_num_rows($studioDetailsResult) > 0) {
        $studioDetails = mysqli_fetch_assoc($studioDetailsResult);
        $agent_id = $studioDetails['agent_id'];
        $studio_id = $studioDetails['studio_id'];
        $agentDetails = getAgentById($conn, $agent_id);
        $studio_price = $studioDetails['monthly_rate'] > 0 ? $studioDetails['monthly_rate'] : $studioDetails['original_monthly_rate'];
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDq9mlFO2ZAGNad047X3YaGtJc_3a5FkXY&callback=initMap" async defer></script>
<script>
    function initMap() {
        // Coordinates and studio name
        var latitude = <?php echo $studioDetails['latitude']; ?>;
        var longitude = <?php echo $studioDetails['longitude']; ?>;
        var studioName = '<?php echo $studioDetails['studio_name']; ?>';

        // Map options
        var mapOptions = {
            center: {
                lat: latitude,
                lng: longitude
            },
            zoom: 15,
        };

        // Create a new map
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);

        // Create a new marker
        var marker = new google.maps.Marker({
            position: {
                lat: latitude,
                lng: longitude
            },
            map: map,
            title: studioName
        });

        // Optional: Add an info window
        var infowindow = new google.maps.InfoWindow({
            content: studioName
        });

        marker.addListener('click', function() {
            infowindow.open(map, marker);
        });
    }
</script>

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


    <!-- Single Product Start -->
    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="row g-4 mb-5">
                <div class="col-lg-8 col-xl-9">
                    <div class="row g-4">
                        <!-- Bootstrap Modal for Full-Screen Image -->
                        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <img src="" id="modalImage" class="img-fluid" alt="Zoomed Image">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php
                            // Fetch all images for the studio, including the main image
                            $studio_id = $studioDetails['studio_id'];
                            $images = getStudioImages($conn, $studio_id);
                            $allImages = mysqli_fetch_all($images, MYSQLI_ASSOC);

                            if (count($allImages) > 0) {
                                // Separate the first image as the main image
                                $mainImage = array_shift($allImages);
                            ?>
                                <!-- Main Image (Left) -->
                                <div class="col-lg-6">
                                    <div class="border rounded">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage('uploads/<?= $mainImage['image_path'] ?>')">
                                            <img src="uploads/<?= $mainImage['image_path'] ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($mainImage['caption'] ?? 'Main Image') ?>">
                                        </a>
                                    </div>
                                </div>

                                <!-- Additional Images (Right) -->
                                <div class="col-lg-6">
                                    <div class="row">
                                        <?php foreach ($allImages as $image) { ?>
                                            <div class="col-6">
                                                <div class="border rounded mb-2">
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage('uploads/<?= $image['image_path'] ?>')">
                                                        <img src="uploads/<?= $image['image_path'] ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($image['caption']) ?>">
                                                    </a>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php
                            } else {
                                // If no images are available
                                echo '<p>No images available.</p>';
                            }
                            ?>
                        </div>



                        <div class="col-lg-12 d-flex align-items-center justify-content-between">
                            <div>
                                <h3 class="fw-bold mb-3"><?= $studioDetails['studio_name'] ?></h3>
                                <small class="bg-primary text-white rounded py-1 px-3"><?= $studioDetails['type'] ?></small>
                                <p class="mt-2 mb-3"><?= $studioDetails['address'] ?><a href="#maps" class="text-primary m-2">See Map</a></p>
                                <!-- <div style="border-bottom: 1px solid #d4d6d7;"></div> -->
                            </div>
                            <div class="mr-4" style="margin-right: 50px;">
                                <?php if (isset($_SESSION['email'])): ?>
                                    <?php if ($_SESSION['user_type'] == 'student') : ?>
                                        <!-- Button to trigger the modal if the user is logged in -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" style="padding: 20px;" data-bs-target="#bookingModal">Booking Now</button>
                                    <?php else: ?>
                                        <a href="<?= $base_url ?>/<?= $_SESSION['user_type'] ?>/logout?redirect=<?= urlencode($_SERVER['REQUEST_URI']) ?>"
                                            class="btn btn-secondary" style="padding: 20px;">Please login as Student</a>
                                    <?php endif; ?>

                                <?php else: ?>
                                    <a href="<?= $base_url ?>/log-in?redirect=<?= urlencode($_SERVER['REQUEST_URI']) ?>"
                                        class="btn btn-secondary" style="padding: 20px;">Please login first</a>
                                    <?php $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI']; ?>
                                    <!-- Redirect to login page if not logged in, with a redirect to the current page -->
                                <?php endif; ?>

                            </div>

                        </div>

                        <!-- Modal Structure -->
                        <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="bookingModalLabel">Book Studio</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Booking form or content goes here -->
                                        <p>Enter your booking details here.</p>
                                        <form method="post" action="<?php echo $base_url ?>/submit-booking">
                                            <?php $user = getStudentByUserId($conn, $_SESSION['user_id']); ?>
                                            <div class="mb-3">
                                                <label for="bookingName" class="form-label">Your Name</label>
                                                <input type="text" class="form-control" id="bookingName" name="name" value="<?= $user['name'] ?>" placeholder="Enter your name" readonly>
                                            </div>
                                            <input type="hidden" name="student_id" value="<?= $user['student_id'] ?>" />
                                            <input type="hidden" name="studio_id" value="<?= $studio_id; ?>" />
                                            <input type="hidden" name="studio_price" value="<?= $studio_price; ?>" />
                                            <div class="mb-3">
                                                <label for="bookingDate" class="form-label">Date Move In</label>
                                                <input type="date" name="start_date" class="form-control" id="bookingDate" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="" class="form-label">Duration in Semester</label>
                                                <select name="duration" class="form-control" id="">
                                                    <option value="1">1 semester</option>
                                                    <option value="2">2 semester</option>
                                                    <option value="3">3 semester</option>
                                                    <option value="4">4 semester</option>
                                                    <option value="5">5 semester</option>
                                                </select>
                                            </div>
                                            <input class="btn btn-primary py-3 w-100 mb-4" type="submit" value="Next" name="booked"></input>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-lg-12 d-flex flex-column flex-md-row align-items-start align-items-md-center">
                            <!-- Pricing Section -->
                            <div class="flex-grow-1 mb-3 mb-md-0">
                                <h4 class="fw-bold mb-3 text-center text-md-start">
                                    <?php if ($studioDetails['monthly_rate'] > 0 && $studioDetails['monthly_rate'] < $studioDetails['original_monthly_rate']) { ?>
                                        <p class="py-1" style="font-size: 5vw; font-size: 25px;">
                                            <span style="font-size: 20px;" class="text-muted"><del>RM <?php echo number_format($studioDetails['original_monthly_rate'], 2); ?></del></span>
                                            RM <?php echo number_format($studioDetails['monthly_rate'], 2); ?>/Month
                                        </p>
                                    <?php } else { ?>
                                        <p class="py-1" style="font-size: 5vw; font-size: 25px;">
                                            RM <?php echo number_format($studioDetails['original_monthly_rate'], 2); ?>/Month
                                        </p>
                                    <?php } ?>
                                </h4>
                            </div>

                            <!-- Divider -->
                            <div class="d-none d-md-block mx-5" style="border-right: 1px solid #d4d6d7; height: 100px;"></div>

                            <!-- Facilities Section -->
                            <div class="d-flex flex-column flex-md-row gap-2 gap-md-5 mt-3 mt-md-0 text-center text-md-start">
                                <p class="mb-0" style="font-size: 4vw; font-size: 24px;">
                                    <i class="fa fa-bed text-primary me-2"></i>
                                    <?php echo $studioDetails['master_bedroom'] + $studioDetails['regular_bedroom'] + $studioDetails['small_bedroom']; ?> Bed<?php echo ($studioDetails['master_bedroom'] + $studioDetails['regular_bedroom'] + $studioDetails['small_bedroom']) > 1 ? 's' : ''; ?>
                                </p>
                                <p class="mb-0" style="font-size: 4vw; font-size: 24px;">
                                    <i class="fa fa-bath text-primary me-2"></i>
                                    <?php echo $studioDetails['master_bath'] + $studioDetails['regular_bath'] + $studioDetails['small_bath']; ?> Bath<?php echo ($studioDetails['master_bath'] + $studioDetails['regular_bath'] + $studioDetails['small_bath']) > 1 ? 's' : ''; ?>
                                </p>
                                <p class="mb-0" style="font-size: 4vw; font-size: 24px;">
                                    <?php echo stripos($studioDetails['facilities'], 'Wi-Fi') !== false ? '<small><i class="fa fa-wifi text-primary me-2"></i>Wi-Fi</small>' : '<small><i class="fa fa-wifi text-muted me-2"></i>No Wifi</small>'; ?>
                                </p>
                            </div>

                            <!-- Bottom Divider (Only on mobile) -->
                            <div class="d-md-none" style="border-bottom: 1px solid #d4d6d7; width: 100%;"></div>
                        </div>


                        <div class="col-lg-12 mt-5 mb-5">
                            <h4 class="mb-4">Description</h4>
                            <!-- <button class="nav-link border-white border-bottom-0" type="button" role="tab"
                                        id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                        aria-controls="nav-mission" aria-selected="false">Reviews</button> -->
                            <div class="tab-content mb-5">
                                <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                    <p><?= htmlspecialchars($studioDetails['description']) ?></p>
                                    <div class="px-2">
                                        <div class="row g-4">
                                            <div class="col-6">
                                                <div class="row mt-4">
                                                    <h4 class="mb-4">Facilities</h4>
                                                    <?php
                                                    // Convert facilities string into an array
                                                    $facilities = explode(',', htmlspecialchars($studioDetails['facilities']));
                                                    ?>
                                                    <?php foreach ($facilities as $index => $facility) : ?>
                                                        <div class="col-6">
                                                            <div class="row align-items-center text-center justify-content-start py-2">
                                                                <div class="col-auto">
                                                                    <?php
                                                                    // Display appropriate icon based on the facility
                                                                    $facility = trim($facility); // Remove extra spaces

                                                                    if (stripos($facility, 'Wi-Fi') !== false) {
                                                                        echo '<i class="fa fa-wifi text-primary me-2"></i>';
                                                                    } elseif (stripos($facility, 'Swimming Pool') !== false || stripos($facility, 'Pool') !== false) {
                                                                        echo '<i class="fa-solid fa-person-swimming text-primary me-2"></i>';
                                                                    } elseif (stripos($facility, 'Air Conditioning') !== false) {
                                                                        echo '<i class="fa-solid fa-fan text-primary me-2"></i>';
                                                                    } elseif (stripos($facility, '24-hour Security') !== false) {
                                                                        echo '<i class="fa-solid fa-shield-heart text-primary me-2"></i>';
                                                                    } elseif (stripos($facility, 'Sea View') !== false || stripos($facility, 'Beach Access') !== false) {
                                                                        echo '<i class="fa-solid fa-umbrella-beach text-primary me-2"></i>';
                                                                    } elseif (stripos($facility, 'River View') !== false) {
                                                                        echo '<i class="fa-solid fa-water text-primary me-2"></i>';
                                                                    } elseif (stripos($facility, 'Kitchenette') !== false || stripos($facility, 'Kitchen') !== false) {
                                                                        echo '<i class="fa-solid fa-sink text-primary me-2"></i></i>';
                                                                    } elseif (stripos($facility, 'Washing Machine') !== false || stripos($facility, 'Laundry Room') !== false) {
                                                                        echo '<i class="fa-solid fa-soap text-primary me-2"></i>';
                                                                    } elseif (stripos($facility, 'Parking') !== false) {
                                                                        echo '<i class="fa-solid fa-square-parking text-primary me-2"></i>';
                                                                    } elseif (stripos($facility, 'Gym') !== false) {
                                                                        echo '<i class="fa-solid fa-dumbbell text-primary me-2"></i>';
                                                                    } elseif (stripos($facility, 'Balcony') !== false) {
                                                                        echo '<i class="fa-solid fa-store text-primary me-2"></i>';
                                                                    } else {
                                                                        // Default icon if no specific match found
                                                                        echo '<i class="fa-solid fa-circle text-primary me-2"></i>';
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <div class="col">
                                                                    <p style="font-size: 20px;" class="mb-0"><?= $facility ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Close and start a new row after two items -->
                                                        <?php if (($index + 1) % 2 == 0) : ?>
                                                            <div class="w-100"></div>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="maps" style="border-bottom: 1px solid #d4d6d7;">
                            </div>


                            <div class="col-lg-12 mt-5">
                                <h3 class="fw-bold mb-3">Map</h3>
                                <div id="map" class=""></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-3">
                    <div class="row g-4 fruite">
                        <!-- <div class="col-lg-12">
                            <div class="mb-4">
                                <h4>Categories</h4>
                                <ul class="list-unstyled fruite-categorie">
                                    <li>
                                        <div class="d-flex justify-content-between fruite-name">
                                            <a href="#"><i class="fas fa-apple-alt me-2"></i>Apples</a>
                                            <span>(3)</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex justify-content-between fruite-name">
                                            <a href="#"><i class="fas fa-apple-alt me-2"></i>Oranges</a>
                                            <span>(5)</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex justify-content-between fruite-name">
                                            <a href="#"><i class="fas fa-apple-alt me-2"></i>Strawbery</a>
                                            <span>(2)</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex justify-content-between fruite-name">
                                            <a href="#"><i class="fas fa-apple-alt me-2"></i>Banana</a>
                                            <span>(8)</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex justify-content-between fruite-name">
                                            <a href="#"><i class="fas fa-apple-alt me-2"></i>Pumpkin</a>
                                            <span>(5)</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div> -->
                        <!-- Agent profile card -->
                        <div class="col-lg-12 col-md-12">
                            <div class="card shadow rounded overflow-hidden agent-profile-card">
                                <img class="img-fluid" src="uploads/<?php echo $agentDetails['image_profile']; ?>" alt="Agent Image">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($agentDetails['name']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($agentDetails['business_name']); ?></p>
                                    <p class="card-text"><?php echo htmlspecialchars($agentDetails['phone_number']); ?></p>
                                    <a target="_blank" href="https://wa.me/<?php echo htmlspecialchars($agentDetails['phone_number']); ?>" class="btn btn-success w-100" style="padding: 20px; border-radius: 15px;">
                                        <i class="fa-brands fa-whatsapp"></i> Contact on WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- end agent profile card -->
                    </div>
                </div>
            </div>
            <?php $result_related = getRelated($conn, 'studios', $studio_id); ?>
            <h1 class="fw-bold mb-4">Related Studios</h1>
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
    </div>
    <!-- Single Product End -->


    <?php include 'views/components/footer.php'; ?>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
        function showImage(src) {
            document.getElementById('modalImage').src = src;
        }

        $(window).scroll(function(e) {
            // Check if the screen width is greater than 768px (or any breakpoint you prefer)
            if ($(window).width() > 768) {
                var $el = $('.agent-profile-card');
                var isPositionFixed = ($el.css('position') == 'fixed');

                if ($(this).scrollTop() > 600 && !isPositionFixed) {
                    $el.css({
                        'position': 'fixed',
                        'top': '40px'
                    });
                }
                if ($(this).scrollTop() < 720 && isPositionFixed) {
                    $el.css({
                        'position': 'static',
                        'top': '40px'
                    });
                }
            } else {
                // On mobile, ensure the position is always static
                $('.agent-profile-card').css({
                    'position': 'static',
                    'top': '40px'
                });
            }
        });
    </script>
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