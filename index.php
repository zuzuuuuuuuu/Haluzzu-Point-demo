<?php
include 'controller/dbconnect.php';
include 'controller/functions.php';

// require 'function.php';
require 'router.php';
?>

<?php include 'views/components/header.php'; ?>

<body>
    <div class="container-xxl bg-white p-0" style="max-width: 100%;">

        <?php // include 'views/components/spinner.php'; 
        ?>

        <?php include 'views/components/navbar.php'; ?>

        <?php include 'views/components/carousel.php'; ?>

        <!-- Booking Start -->
        <div class="container-fluid booking pb-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container">
                <div class="bg-white shadow" style="padding: 35px;">
                    <?php include 'views/components/search.php'; ?>
                </div>
            </div>
        </div>
        <!-- Booking End -->


        <!-- About Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <h6 class="section-title text-start text-primary text-uppercase">About Us</h6>
                        <h1 class="mb-4">Welcome to <span class="text-primary text-uppercase"><?php echo $system_name; ?></span></h1>
                        <p class="mb-4">Discover the ideal studio rentals tailored for students across Malaysia. At Haluzzu Point, we connect students with comfortable, affordable, and strategically located studios near universities and colleges. Whether you're looking for a cozy space to focus on your studies or a convenient place to call home, we’ve got you covered.

                            <br><br>Join our platform to explore a wide range of studio options designed to meet your needs, with easy booking and personalized support. Haluzzu Point – your trusted partner in finding the perfect student accommodation.</p>
                        <div class="row g-3 pb-4">
                            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.1s">
                                <div class="border rounded p-1">
                                    <div class="border rounded text-center p-4">
                                        <i class="fa fa-hotel fa-2x text-primary mb-2"></i>
                                        <h2 class="mb-1" data-toggle="counter-up"><?= getTotalStudios($conn); ?></h2>
                                        <p class="mb-0">Studios</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.3s">
                                <div class="border rounded p-1">
                                    <div class="border rounded text-center p-4">
                                        <i class="fa fa-users-cog fa-2x text-primary mb-2"></i>
                                        <?php $total_users = getTotalUsers($conn);?>
                                        <h2 class="mb-1" data-toggle="counter-up"><?= $total_users['total_agents']; ?></h2>
                                        <p class="mb-0">Agents</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.5s">
                                <div class="border rounded p-1">
                                    <div class="border rounded text-center p-4">
                                        <i class="fa fa-users fa-2x text-primary mb-2"></i>
                                        <h2 class="mb-1" data-toggle="counter-up"><?= $total_users['total_students']; ?></h2>
                                        <p class="mb-0">Students</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="btn btn-primary py-3 px-5 mt-2" href="">Explore More</a>
                    </div>
                    <div class="col-lg-6">
                        <div class="row g-3">
                            <div class="col-6 text-end">
                                <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.1s" src="img/about-1.jpg" style="margin-top: 25%;">
                            </div>
                            <div class="col-6 text-start">
                                <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.3s" src="img/about-2.jpg">
                            </div>
                            <div class="col-6 text-end">
                                <img class="img-fluid rounded w-50 wow zoomIn" data-wow-delay="0.5s" src="img/about-3.jpg">
                            </div>
                            <div class="col-6 text-start">
                                <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.7s" src="img/about-4.jpg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->

        <!-- Place Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase">Famous Locations</h6>
                    <h1 class="mb-5">Explore Our <span class="text-primary text-uppercase">Famous Locations</span></h1>
                </div>
                <div class="row g-4">
                    <?php
                    $result = getFamousLocation();

                    if ($result) {
                        while ($location = mysqli_fetch_assoc($result)) {
                            // Retrieve location details
                            $state = $location['state'];
                            $city = $location['location'];
                            $roomCount = $location['room_count'];
                            $image_cover = $location['image_cover'];

                            // Determine booking status message
                            $bookingMessage = $roomCount > 0 ? $roomCount . ' rooms' : 'No rooms yet';

                    ?>
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="room-item shadow rounded overflow-hidden">
                                    <div class="position-relative">
                                        <!-- Placeholder for location image -->
                                        <img class="img-fluid" src="uploads/<?= $image_cover; ?>" alt="">
                                        <small class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4"><?php echo $bookingMessage; ?></small>
                                    </div>
                                    <div class="p-4 mt-2">
                                        <div class="d-flex justify-content-between mb-3">
                                            <h5 class="mb-0"><?php echo htmlspecialchars($city); ?></h5>
                                            <div class="ps-2">
                                                <!-- Placeholder for stars, can be replaced with actual rating logic -->
                                                <small class="fa fa-star text-primary"></small>
                                                <small class="fa fa-star text-primary"></small>
                                                <small class="fa fa-star text-primary"></small>
                                                <small class="fa fa-star text-primary"></small>
                                                <small class="fa fa-star text-primary"></small>
                                            </div>
                                        </div>
                                        <div class="d-flex mb-3">
                                            <small class="border-end me-3 pe-3"><i class="fa fa-map-marker text-primary me-2"></i><?php echo htmlspecialchars($city); ?></small>
                                            <small><i class="fa fa-building text-primary me-2"></i><?php echo htmlspecialchars($state); ?></small>
                                        </div>
                                        <p class="text-body mb-3">Explore our famous locations in <?php echo htmlspecialchars($city); ?>, <?php echo htmlspecialchars($state); ?>.</p>
                                        <div class="d-flex justify-content-between">
                                            <!-- <a class="btn btn-sm btn-primary rounded py-2 px-4" href="#">View Details</a> -->
                                            <a class="btn btn-sm btn-dark rounded py-2 px-4 w-100" href="<?= $base_url ?>/search-studios?location=<?= $city ?>&search-studios=">View Rooms</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo '<p>No locations available.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Place End -->

        <!-- Room Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase">Our Studios</h6>
                    <h1 class="mb-5">Explore Our <span class="text-primary text-uppercase">Trending Studios</span></h1>
                </div>
                <?php
                $studiosLimitSix = getSixStudios('studios', 6);
                ?>
                <div class="row g-4">
                    <?php
                    if ($studiosLimitSix) {
                        while ($studio = mysqli_fetch_assoc($studiosLimitSix)) {
                            // Retrieve studio details
                            $studio_id = $studio['studio_id'];
                            $studio_name = $studio['studio_name'];
                            $slug = $studio['slug'];
                            $original_monthly_rate = $studio['original_monthly_rate'];  // Assuming original_monthly_rate is in the studios table
                            $monthly_rate = $studio['monthly_rate'];  // Discounted rate
                            $studio_description = $studio['description'];
                            $image_cover = $studio['image_cover'];
                            $state = $studio['state'];  // Assuming state is in the studios table
                            $location = $studio['location'];  // Assuming location is in the studios table
                            $bedCount = $studio['master_bedroom'] + $studio['regular_bedroom'] + $studio['small_bedroom'];
                            $bathCount = $studio['master_bath'] + $studio['regular_bath'] + $studio['small_bath'];
                            $wifiAvailable = stripos($studio['facilities'], 'Wi-Fi') !== false
                                ? '<small><i class="fa fa-wifi text-primary me-2"></i>Wifi</small>'
                                : '<small><i class="fa fa-wifi text-muted me-2"></i>No Wifi</small>';

                            // Fetch the image URL for the studio
                            // $image_query = "SELECT image_url FROM StudioImages WHERE studio_id = $studio_id LIMIT 1";
                            // $image_result = mysqli_query($conn, $image_query);
                            // $image_row = mysqli_fetch_assoc($image_result);
                            // $image_url = $image_row ? $image_row['image_url'] : 'default-image.jpg';
                    ?>
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="room-item shadow rounded overflow-hidden h-100">
                                    <div class="position-relative">
                                        <img class="img-fluid" src="uploads/<?php echo $image_cover; ?>" alt="">
                                        <?php if ($monthly_rate > 0 && $monthly_rate < $original_monthly_rate) { ?>
                                            <small class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4">
                                                <span style="text-decoration: line-through; color: red;">RM <?php echo number_format($original_monthly_rate, 2); ?></span>
                                                RM <?php echo number_format($monthly_rate, 2); ?>/Month
                                            </small>
                                        <?php } else { ?>
                                            <small class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4">
                                                RM <?php echo number_format($original_monthly_rate, 2); ?>/Month
                                            </small>
                                        <?php } ?>
                                    </div>
                                    <div class="p-4 mt-2">
                                        <div class="d-flex justify-content-between mb-3">
                                            <h5 class="mb-0"><?php echo htmlspecialchars(truncateDescription($studio_name, 20)); ?></h5>
                                            <div class="ps-2">
                                                <!-- Placeholder for stars, can be replaced with actual rating logic -->
                                                <small class="fa fa-star text-primary"></small>
                                                <small class="fa fa-star text-primary"></small>
                                                <small class="fa fa-star text-primary"></small>
                                                <small class="fa fa-star text-primary"></small>
                                                <small class="fa fa-star text-primary"></small>
                                            </div>
                                        </div>
                                        <div class="d-flex mb-3">
                                            <small class="border-end me-3 pe-3"><i class="fa fa-bed text-primary me-2"></i><?php echo $bedCount; ?> Bed<?php echo $bedCount > 1 ? 's' : ''; ?></small>
                                            <small class="border-end me-3 pe-3"><i class="fa fa-bath text-primary me-2"></i><?php echo $bathCount; ?> Bath<?php echo $bathCount > 1 ? 's' : ''; ?></small>
                                            <?php echo $wifiAvailable; ?>
                                        </div>
                                        <div class="d-flex mb-3">
                                            <small class="border-end me-3 pe-3"><i class="fa fa-map-marker text-primary me-2"></i><?php echo htmlspecialchars($location); ?></small>
                                            <small><i class="fa fa-building text-primary me-2"></i><?php echo htmlspecialchars($state); ?></small>
                                        </div>
                                        <p class="text-body mb-3"><?php echo htmlspecialchars(truncateDescription($studio_description, 150)); ?></p>
                                        <div class="d-flex justify-content-between">
                                            <a class="btn btn-sm btn-primary rounded py-2 px-4" href="<?= $base_url ?>/details?studio=<?= $slug ?>">View Detail</a>
                                            <a class="btn btn-sm btn-dark rounded py-2 px-4" href="#">Book Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo '<p>No studios available.</p>';
                    }
                    ?>
                </div>


            </div>
        </div>
        <!-- Room End -->


        <!-- Video Start -->
        <!-- <div class="container-xxl py-5 px-0 wow zoomIn" data-wow-delay="0.1s">
            <div class="row g-0">
                <div class="col-md-6 bg-dark d-flex align-items-center">
                    <div class="p-5">
                        <h6 class="section-title text-start text-white text-uppercase mb-3">Luxury Living</h6>
                        <h1 class="text-white mb-4">Discover A Brand Luxurious Hotel</h1>
                        <p class="text-white mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet diam et eos. Clita erat ipsum et lorem et sit, sed stet lorem sit clita duo justo magna dolore erat amet</p>
                        <a href="" class="btn btn-primary py-md-3 px-md-5 me-3">Our Studios</a>
                        <a href="" class="btn btn-light py-md-3 px-md-5">Book A Studio</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="video">
                        <button type="button" class="btn-play" data-bs-toggle="modal" data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videoModal">
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Youtube Video</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- 16:9 aspect ratio -->
                        <div class="ratio ratio-16x9">
                            <iframe class="embed-responsive-item" src="" id="video" allowfullscreen allowscriptaccess="always"
                                allow="autoplay"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Video Start -->


        <!-- Service Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase">Our Services</h6>
                    <h1 class="mb-5">Explore Our <span class="text-primary text-uppercase">Student Rental Services</span></h1>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item rounded">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-hotel fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">Comfortable Studios</h5>
                            <p class="text-body mb-0">Find the perfect studio or apartment tailored for student living, with amenities and facilities that make student life easier and more enjoyable.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="service-item rounded">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-map-marker-alt fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">Prime Locations</h5>
                            <p class="text-body mb-0">Choose from a range of studios located near UITM campuses and other educational institutions, making commuting easy and convenient.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="service-item rounded">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-dollar-sign fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">Affordable Rates</h5>
                            <p class="text-body mb-0">Enjoy budget-friendly rental options designed to fit student budgets, with flexible payment plans to suit your financial needs.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="service-item rounded">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-wifi fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">Modern Amenities</h5>
                            <p class="text-body mb-0">Each studio is equipped with essential modern amenities like high-speed internet and other facilities to make your stay comfortable and connected.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="service-item rounded">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-lock fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">Secure Environment</h5>
                            <p class="text-body mb-0">Enjoy peace of mind with secure, monitored buildings and properties, ensuring a safe and secure living environment for all students.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="service-item rounded">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-user-friends fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">Community Focused</h5>
                            <p class="text-body mb-0">Join a vibrant community of students and enjoy social and networking opportunities, creating connections that enhance your college experience.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Service End -->


        <!-- Testimonial Start -->
        <div class="container-xxl testimonial my-5 py-5 bg-dark wow zoomIn" data-wow-delay="0.1s">
            <div class="container">
                <div class="owl-carousel testimonial-carousel py-5">
                    <div class="testimonial-item position-relative bg-white rounded overflow-hidden">
                        <p>Tempor stet labore dolor clita stet diam amet ipsum dolor duo ipsum rebum stet dolor amet diam stet. Est stet ea lorem amet est kasd kasd et erat magna eos</p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded" src="img/testimonial-1.jpg" style="width: 45px; height: 45px;">
                            <div class="ps-3">
                                <h6 class="fw-bold mb-1">Client Name</h6>
                                <small>Profession</small>
                            </div>
                        </div>
                        <i class="fa fa-quote-right fa-3x text-primary position-absolute end-0 bottom-0 me-4 mb-n1"></i>
                    </div>
                    <div class="testimonial-item position-relative bg-white rounded overflow-hidden">
                        <p>Tempor stet labore dolor clita stet diam amet ipsum dolor duo ipsum rebum stet dolor amet diam stet. Est stet ea lorem amet est kasd kasd et erat magna eos</p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded" src="img/testimonial-2.jpg" style="width: 45px; height: 45px;">
                            <div class="ps-3">
                                <h6 class="fw-bold mb-1">Client Name</h6>
                                <small>Profession</small>
                            </div>
                        </div>
                        <i class="fa fa-quote-right fa-3x text-primary position-absolute end-0 bottom-0 me-4 mb-n1"></i>
                    </div>
                    <div class="testimonial-item position-relative bg-white rounded overflow-hidden">
                        <p>Tempor stet labore dolor clita stet diam amet ipsum dolor duo ipsum rebum stet dolor amet diam stet. Est stet ea lorem amet est kasd kasd et erat magna eos</p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded" src="img/testimonial-3.jpg" style="width: 45px; height: 45px;">
                            <div class="ps-3">
                                <h6 class="fw-bold mb-1">Client Name</h6>
                                <small>Profession</small>
                            </div>
                        </div>
                        <i class="fa fa-quote-right fa-3x text-primary position-absolute end-0 bottom-0 me-4 mb-n1"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Testimonial End -->


        <!-- Agent Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase">Our Agents</h6>
                    <h1 class="mb-5">Explore Our <span class="text-primary text-uppercase">Agents</span></h1>
                </div>
                <div class="agent-carousel">
                    <?php $agentsResult = getAllAgents(); ?>
                    <div class="carousel-container">
                        <?php while ($agent = mysqli_fetch_assoc($agentsResult)) { ?>
                            <div class="agent-item">
                                <div class="rounded shadow overflow-hidden">
                                    <div class="position-relative">
                                        <img class="img-fluid" src="uploads/<?php echo htmlspecialchars($agent['image_profile']); ?>" alt="">
                                        <div class="position-absolute start-50 top-100 translate-middle d-flex align-items-center">
                                            <a class="btn btn-square btn-primary mx-1" href="#"><i class="fab fa-facebook-f"></i></a>
                                            <a class="btn btn-square btn-primary mx-1" href="#"><i class="fab fa-twitter"></i></a>
                                            <a class="btn btn-square btn-primary mx-1" href="#"><i class="fab fa-instagram"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center p-4 mt-3">
                                        <h5 class="fw-bold mb-0"><?php echo htmlspecialchars($agent['full_name']); ?></h5>
                                        <small><?php echo htmlspecialchars($agent['business_name']); ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- Navigation buttons -->
                    <button class="carousel-btn prev-btn btn-primary"><i class="fa-solid fa-arrow-left"></i></button>
                    <button class="carousel-btn next-btn btn-primary"><i class="fa-solid fa-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <!-- Agent End -->


        <!-- Newsletter Start -->
        <!-- <div class="container newsletter mt-5 wow fadeIn" data-wow-delay="0.1s">
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
        </div> -->
        <!-- Newsletter Start -->

        <?php include 'views/components/footer.php'; ?>


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

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.carousel-container');
            const prevBtn = document.querySelector('.prev-btn');
            const nextBtn = document.querySelector('.next-btn');
            const totalItems = container.children.length;
            const itemsToShow = getItemsToShow();
            const itemWidth = container.children[0].offsetWidth;
            let currentIndex = 0;

            function getItemsToShow() {
                if (window.innerWidth >= 992) return 3; // Large screens
                if (window.innerWidth >= 768) return 2; // Medium screens
                return 1; // Small screens
            }

            function updateCarousel() {
                const offset = -currentIndex * itemWidth;
                container.style.transform = `translateX(${offset}px)`;
            }

            function handleResize() {
                const newItemsToShow = getItemsToShow();
                if (newItemsToShow !== itemsToShow) {
                    currentIndex = Math.min(currentIndex, totalItems - newItemsToShow);
                    updateCarousel();
                }
            }

            prevBtn.addEventListener('click', function() {
                currentIndex = Math.max(currentIndex - 1, 0);
                updateCarousel();
            });

            nextBtn.addEventListener('click', function() {
                currentIndex = Math.min(currentIndex + 1, totalItems - getItemsToShow());
                updateCarousel();
            });

            window.addEventListener('resize', handleResize);

            // Initialize the carousel
            updateCarousel();
        });
    </script>


    <!-- CSS -->
    <style>
        .room-item {
            min-height: 550px;
            /* Adjust the height as needed */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border: 1px solid lightgrey;
        }

        .room-item img {
            /* height: 200px; */
            /* Set a fixed height for the images */
            object-fit: cover;
            /* Ensure images cover the entire area without distorting */
        }

        .room-item .p-4 {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        @media (max-width: 768px) {
            .room-item {
                min-height: 600px;
                /* Adjust height for smaller screens */
            }
        }

        .agent-carousel {
            position: relative;
            overflow: hidden;
        }

        .carousel-container {
            display: flex;
            transition: transform 0.5s ease-in-out;
            width: 100%;
        }

        .agent-item {
            box-sizing: border-box;
            padding: 0 10px;
            /* Adjust space between items */
        }

        /* Display 3 items at a time on larger screens */
        @media (min-width: 992px) {

            /* For large screens and up */
            .agent-item {
                flex: 0 0 33.3333%;
                /* Show 3 items at once */
            }
        }

        /* Display 2 items at a time on medium screens */
        @media (min-width: 768px) and (max-width: 991px) {

            /* For medium screens */
            .agent-item {
                flex: 0 0 50%;
                /* Show 2 items at once */
            }
        }

        /* Display 1 item at a time on small screens */
        @media (max-width: 767px) {

            /* For small screens */
            .agent-item {
                flex: 0 0 100%;
                /* Show 1 item at once */
            }
        }

        .agent-item img {
            width: 100%;
            height: 200px;
            /* Fixed height for all images */
            object-fit: cover;
            /* Ensures images cover the dimensions without distortion */
        }

        .carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            z-index: 1;
        }

        .prev-btn {
            left: 10px;
        }

        .next-btn {
            right: 10px;
        }
    </style>
    <script>
    // JavaScript to handle requests
    document.getElementById('testRequest').addEventListener('click', () => {
      fetch('https://6279-60-51-35-159.ngrok-free.app/haluzzu/', {
        method: 'GET',
        headers: {
          'ngrok-skip-browser-warning': 'true'
        }
      })
      .then(response => response.text())
      .then(data => {
        console.log('Response:', data);
        alert('Request successful!');
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Request failed. Check the console for details.');
      });
    });
  </script>
</body>

</html>