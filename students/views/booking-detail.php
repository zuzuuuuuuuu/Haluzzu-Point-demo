<?php
// Include your database connection file
include 'controller/dbconnect.php';
include 'controller/functions.php';
include 'config.php';

// require 'function.php';
require_once 'router.php';

// Check if the booking ID is set
if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    // Prepare and execute your query to get booking details
    $query = "
        SELECT bookings.booking_id, bookings.booking_date, bookings.total_price, bookings.payment_status, 
               students.student_id, users.name AS student_name, studios.studio_name AS studio_name, students.*, bookings.*, users.*, studios.*
        FROM bookings 
        JOIN students ON bookings.student_id = students.student_id
        JOIN users ON students.user_id = users.user_id
        JOIN studios ON bookings.studio_id = studios.studio_id
        WHERE bookings.booking_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the booking details
    if ($row = $result->fetch_assoc()) {
        // Store the data in variables for display
        $booking_date = date('d M Y', strtotime($row['booking_date']));
        $invoice = 'INV-' . str_pad($row['booking_id'], 4, '0', STR_PAD_LEFT);
        $student_name = $row['student_name'];
        $campus = $row['campus_location'];
        $state = $row['state'];
        $duration = $row['duration'];
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];
        $status = $row['status'];
        $created_at = $row['created_at'];
        $studio_name = $row['studio_name'];
        $total_price = $row['total_price'];
        $payment_status = $row['payment_status'];
        $email = $row['email'];
        $phone_number = $row['phone_number'];
        $studio_id = $row['studio_id'];

        $latitude = $row['latitude'];
        $longtitude = $row['longitude'];
    } else {
        echo "No booking found.";
        exit();
    }
} else {
    echo "Invalid booking ID.";
    exit();
}
?>

<?php include 'students/views/components/header.php'; ?>
<script>
    function initMap() {
        // Coordinates and studio name
        var latitude = <?php echo $latitude; ?>;
        var longitude = <?php echo $longtitude; ?>;
        var studioName = '<?php echo $studio_name; ?>';

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
    <div class="container-fluid position-relative bg-white d-flex p-0">

        <?php include 'students/views/components/spinner.php';
        ?>

        <?php include 'students/views/components/sidebar.php'; ?>



        <!-- Content Start -->
        <div class="content">

            <?php include 'students/views/components/navbar.php'; ?>

            <div class="container-fluid pt-4 px-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= $base_url; ?>/<?= $user_type; ?>/dashboard"><i class="fa-solid fa-house" style="margin-right: 5px;"></i>Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= $base_url; ?>/<?= $user_type; ?>/bookings-list">All Bookings</a></li>
                        <li class="breadcrumb-item"><a href="#"><?php echo htmlspecialchars($studio_name); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Booking Details</li>
                    </ol>
                </nav>
                <div class="row g-4">
                    <div class="col-lg-6 col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <div style="display: flex; justify-content: space-between">
                                <h4 class="mb-4">Booking Details</h4>
                                <button class="btn btn-primary mb-3" onclick="window.history.back();">Back</button>
                            </div>

                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th scope="row">Invoice</th>
                                        <td><?php echo $invoice; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Created At</th>
                                        <td><?php echo $created_at; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Booking Date</th>
                                        <td><?php echo $booking_date; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Duration</th>
                                        <td><?php echo $duration; ?> Semester</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Start Time</th>
                                        <td><?php echo $start_date; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">End Time</th>
                                        <td><?php echo $end_date; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Status</th>
                                        <td><?php if ($status == 'confirmed') : ?>
                                                <span class="badge bg-success">Confirmed</span>
                                            <?php elseif ($status == 'pending') : ?>
                                                <span class="badge bg-warning">Pending</span>
                                            <?php else : ?>
                                                <span class="badge bg-danger">Cancelled</span>
                                            <?php endif; ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Student Name</th>
                                        <td><?php echo $student_name; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Email</th>
                                        <td><?php echo $email; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Phone Number</th>
                                        <td><?php echo $phone_number; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Campus</th>
                                        <td><?php echo $campus; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">State</th>
                                        <td><?php echo $state; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Studio</th>
                                        <td><?php echo $studio_name; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Amount</th>
                                        <td>RM<?php echo $total_price; ?></td>
                                    </tr>
                                    <!-- <tr>
                                        <th scope="row">Payment Status</th>
                                        <td>
                                            <?php if ($payment_status == 'paid') : ?>
                                                <span class="badge bg-success">Paid</span>
                                            <?php else : ?>
                                                <span class="badge bg-danger">Unpaid</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="container-xxl py-5">
                            <div class="container">
                                <?php
                                $studios = getStudioById($conn, $studio_id);
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
                                            <div class="wow fadeInUp" data-wow-delay="0.1s">
                                                <div class="room-item shadow rounded overflow-hidden h-100" style="border: 1px solid grey">
                                                    <div class="position-relative">
                                                        <img class="img-fluid" src="<?= $base_url ?>/uploads/<?php echo $image_cover; ?>" alt="">

                                                        <small class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4">
                                                            This booking is for RM<?php echo number_format($total_price, 2); ?>, covering <?= $duration ?> Semesters
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
                                                        <p class="text-body mb-3"><?php echo htmlspecialchars(truncateDescription($studio_description, 150)); ?></p>
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
                <div class="col-lg-8 mt-5">
                    <h3 class="fw-bold mb-3">Map</h3>
                    <div id="map" class=""></div>
                </div>
            </div>


            <?php include 'students/views/components/footer.php'; ?>


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
            <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDq9mlFO2ZAGNad047X3YaGtJc_3a5FkXY&callback=initMap">
            </script>
            <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDq9mlFO2ZAGNad047X3YaGtJc_3a5FkXY&callback=initMap" async defer></script> -->

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>
<style>
    #map {
        height: 400px;
        width: 100%;
    }
</style>

</html>