<?php
// Include your database connection file
include 'controller/dbconnect.php';
include 'controller/functions.php';
include 'config.php';

// require 'function.php';
require_once 'router.php';

// Check if the booking ID is set
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];
    $students = getAllStudentById($conn, $student_id);
    $row = mysqli_fetch_assoc($students);
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
                        <li class="breadcrumb-item"><a href="<?= $base_url; ?>/<?= $user_type; ?>/students-list">All Students</a></li>
                        <li class="breadcrumb-item"><a href="#"><?php echo htmlspecialchars($row['student_name']); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Student Details</li>
                    </ol>
                </nav>
                <div class="row g-4">
                    <div class="col-lg-6 col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <div style="display: flex; justify-content: space-between">
                                <h4 class="mb-4">Student Information</h4>
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
                                        <td><?php echo $row['student_name']; ?></td>
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
                                        <th scope="row">Student No</th>
                                        <td><?php echo $row['student_no']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Campus</th>
                                        <td><?php echo $row['campus_location']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">State</th>
                                        <td><?php echo $row['state']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="container-xxl py-5">
                            <div class="container">
                                <?php
                                $studios = getAllBookingsByStudentId($conn, $row['student_id']);
                                ?>
                                <div class="w-100">
                                    <?php
                                    if ($studios) {
                                        while ($studio = mysqli_fetch_assoc($studios)) {
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
                                            <div class="wow fadeInUp" style="margin-bottom: 10px;" data-wow-delay="0.1s">
                                                <div class="room-item shadow rounded overflow-hidden" style="border: 1px solid grey">
                                                    <div class="position-relative">
                                                        <img class="" src="../uploads/<?php echo $image_cover; ?>" height="130px" width="100%" style="object-fit: cover;" alt="">

                                                        <small class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4">
                                                            This booking is for RM<?php echo number_format($studio['total_price'], 2); ?>, covering <?= $studio['duration'] ?> Semesters
                                                        </small>
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
                                                        <p class="text-body mb-3"><?php echo htmlspecialchars(truncateDescription($studio_description, 100)); ?></p>
                                                        <div class="d-flex justify-content-between">
                                                            <a class="btn btn-sm btn-primary rounded py-2 px-4" target="_blank" href="<?= $base_url ?>/details?studio=<?= $slug ?>">View Detail</a>
                                                            <!-- <a class="btn btn-sm btn-dark rounded py-2 px-4" href="#">Book Now</a> -->
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


</body>

</html>