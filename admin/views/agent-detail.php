<?php
// Include your database connection file
include 'controller/dbconnect.php';
include 'controller/functions.php';
include 'config.php';

// require 'function.php';
require_once 'router.php';

// Check if the booking ID is set
if (isset($_GET['id'])) {
    $agent_id = $_GET['id'];
    $agent = getAllAgentById($conn, $agent_id);
    $row = mysqli_fetch_assoc($agent);
    if (isset($row['image_profile'])) {
        $image_profile_page = $row['image_profile'];
    } else {
        $image_profile_page = 'default_profile.jpg';
    }
} else {
    echo "Invalid student ID.";
    exit();
}
?>

<?php include 'admin/views/components/header.php'; ?>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">

        <?php //include 'admin/views/components/spinner.php';
        ?>

        <?php include 'admin/views/components/sidebar.php'; ?>



        <!-- Content Start -->
        <div class="content">

            <?php include 'admin/views/components/navbar.php'; ?>

            <div class="container-fluid pt-4 px-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= $base_url; ?>/<?= $user_type; ?>/dashboard"><i class="fa-solid fa-house" style="margin-right: 5px;"></i>Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= $base_url; ?>/<?= $user_type; ?>/agents-list">All Agents</a></li>
                        <li class="breadcrumb-item"><a href="#"><?php echo htmlspecialchars($row['name']); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Agent Details</li>
                    </ol>
                </nav>
                <div class="row g-4">
                    <div class="col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <div style="display: flex; justify-content: space-between">
                                <h4 class="mb-4">Agent Information</h4>
                                <button class="btn btn-primary mb-3" onclick="window.history.back();">Back</button>
                            </div>

                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th colspan="2"="row"><img class="rounded-circle me-lg-2" src="<?php echo $base_url; ?>/uploads/<?php echo htmlspecialchars($image_profile_page); ?>" alt="Profile Image" style="width: 70px; height: 70px;">
                                        </th>
                                    </tr>
                                    <tr>
                                        <th scope="row">Name</th>
                                        <td><?php echo $row['name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Email</th>
                                        <td><?php echo $row['email']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Phone</th>
                                        <td><?php echo $row['phone_number']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Business Name</th>
                                        <td><?php echo $row['business_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Business Location</th>
                                        <td><?php echo $row['studio_location']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">State</th>
                                        <td><?php echo $row['state']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="container-xxl py-5">
                        <h4 class="mb-4">Agent's Studio</h4>

                            <div class="container">
                                <?php
                                $studios = getAllStudiosByAgentId($conn, $row['agent_id']);
                                ?>
                                <div class="swiper-container" style="overflow: hidden;">
                                    <div class="swiper-wrapper">
                                        <?php
                                        if ($studios) {
                                            while ($studio = mysqli_fetch_assoc($studios)) {
                                                // Retrieve studio details
                                                $studio_id = $studio['studio_id'];
                                                $studio_name = $studio['studio_name'];
                                                $slug = $studio['slug'];
                                                $original_monthly_rate = $studio['original_monthly_rate'];
                                                $monthly_rate = $studio['monthly_rate'];
                                                $studio_description = $studio['description'];
                                                $image_cover = $studio['image_cover'];
                                                $state = $studio['state'];
                                                $location = $studio['location'];
                                                $bedCount = $studio['master_bedroom'] + $studio['regular_bedroom'] + $studio['small_bedroom'];
                                                $bathCount = $studio['master_bath'] + $studio['regular_bath'] + $studio['small_bath'];
                                                $wifiAvailable = stripos($studio['facilities'], 'Wi-Fi') !== false
                                                    ? '<small><i class="fa fa-wifi text-primary me-2"></i>Wifi</small>'
                                                    : '<small><i class="fa fa-wifi text-muted me-2"></i>No Wifi</small>';
                                        ?>
                                                <!-- Swiper slide -->
                                                <div class="swiper-slide">
                                                    <div class="wow fadeInUp" style="margin-bottom: 10px;" data-wow-delay="0.1s">
                                                        <div class="room-item shadow rounded overflow-hidden h-100" style="border: 1px solid grey">
                                                            <div class="position-relative">
                                                                <img class="" src="../uploads/<?php echo $image_cover; ?>" style="height: 400px;" alt="">
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
                                                                        <!-- Placeholder for stars -->
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
                                                                    <a class="btn btn-sm btn-primary rounded py-2 px-4" target="_blank" href="<?= $base_url ?>/details?studio=<?= $slug ?>">View Detail</a>
                                                                </div>
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
                                    <!-- Add Pagination -->
                                    <!-- <div class="swiper-pagination"></div> -->
                                    <!-- Add Navigation -->
                                    <!-- <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <?php include 'admin/views/components/footer.php'; ?>


            <!-- JavaScript Libraries -->
            <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="lib/chart/chart.min.js"></script>
            <script src="lib/easing/easing.min.js"></script>
            <script src="lib/waypoints/waypoints.min.js"></script>
            <script src="lib/owlcarousel/owl.carousel.min.js"></script>
            <script src="lib/tempusdominus/js/moment.min.js"></script>
            <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
            <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

            <!-- Template Javascript -->
            <script src="js/main.js"></script>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

            <script>
                var swiper = new Swiper('.swiper-container', {
                    slidesPerView: 2.5, // Display 2 full slides and part of the 3rd
                    spaceBetween: 20, // Space between slides
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    breakpoints: {
                        // Ensure responsiveness on smaller screens
                        0: {
                            slidesPerView: 1.1, // 1 slide on small screens
                            spaceBetween: 10,
                        },
                        768: {
                            slidesPerView: 1.5, // 2 slides on medium screens
                            spaceBetween: 20,
                        },
                        1024: {
                            slidesPerView: 1.5, // 2.5 slides on larger screens
                            spaceBetween: 20,
                        },
                        1440: {
                            slidesPerView: 2.5, // 2.5 slides on larger screens
                            spaceBetween: 20,
                        }
                    }
                });
            </script>
            <style>
                body {
                    overflow-x: hidden;
                    /* Prevent horizontal scrolling */
                }

                /* Ensure the swiper container doesn't cause overflow */
                .swiper-container {
                    width: 100%;
                    overflow: hidden;
                }

                /* Set the wrapper to stay within bounds */
                .swiper-wrapper {
                    display: flex;
                    flex-wrap: nowrap;
                    transition: transform 0.3s ease-in-out;
                }

                .swiper-slide {
                    flex-shrink: 0;
                    width: auto;
                    max-width: 100%;
                    /* Ensures slides don't overflow */
                    box-sizing: border-box;
                }
            </style>
</body>

</html>