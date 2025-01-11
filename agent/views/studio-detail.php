<?php
// Include your database connection file
include 'controller/dbconnect.php';
include 'controller/functions.php';
include 'config.php';

// Check if the studio ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $studio = getAllStudioById($conn, $id); // Fetch studio details by slug
    $row = mysqli_fetch_assoc($studio);

    if (isset($row['image_cover'])) {
        $image_cover_page = $row['image_cover'];
    } else {
        $image_cover_page = 'default_image.jpg'; // default image if no cover image is available
    }
} else {
    echo "Invalid studio ID.";
    exit();
}
?>

<?php include 'agent/views/components/header.php'; ?>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <?php include 'agent/views/components/sidebar.php'; ?>

        <!-- Content Start -->
        <div class="content">
            <?php include 'agent/views/components/navbar.php'; ?>

            <div class="container-fluid pt-4 px-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= $base_url; ?>/<?= $user_type; ?>/dashboard"><i class="fa-solid fa-house" style="margin-right: 5px;"></i>Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= $base_url; ?>/<?= $user_type; ?>/studios-list">All Studios</a></li>
                        <li class="breadcrumb-item"><a href="#"><?php echo htmlspecialchars($row['studio_name']); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Studio Details</li>
                    </ol>
                </nav>

                <div class="row g-4">
                    <div class="col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <div style="display: flex; justify-content: space-between">
                                <h4 class="mb-4">Studio Information</h4>
                                <a href="<?= $base_url ?>/<?= $user_type ?>/studios-list"><button class="btn btn-primary mb-3">Back</button></a>
                            </div>

                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th colspan="2"="row">
                                            <div class="row">

                                                <?php
                                                // Fetch additional images for the studio
                                                $studio_id = $row['studio_id'];
                                                $images = getStudioImages($conn, $studio_id);

                                                if (mysqli_num_rows($images) > 0) {
                                                    while ($image = mysqli_fetch_assoc($images)) {
                                                ?>
                                                        <div class="col-6">
                                                            <div class="border rounded mb-2">
                                                                <img src="<?= $base_url ?>/uploads/<?= $image['image_path'] ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($image['caption']) ?>">
                                                            </div>
                                                        </div>
                                                <?php
                                                    }
                                                } else {
                                                    echo '<p>No additional images available.</p>';
                                                }
                                                ?>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th scope="row">Studio Name</th>
                                        <td><?php echo htmlspecialchars($row['studio_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Location</th>
                                        <td><?php echo htmlspecialchars($row['location']); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">State</th>
                                        <td><?php echo htmlspecialchars($row['state']); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Description</th>
                                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Type</th>
                                        <td><?php echo htmlspecialchars($row['type']); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Status</th>
                                        <td><?php
                                            if ($row['availability_status'] == 'available') {
                                                echo '<span class="badge bg-success">Available</span>';
                                            } else if ($row['availability_status'] == 'under maintenance') {
                                                echo '<span class="badge bg-danger">Under Maintenance</span>';
                                            }
                                            ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Trending</th>
                                        <td><?php
                                            if ($row['trending'] == 1) {
                                                echo '<span class="badge bg-success">Yes</span>';
                                            } else {
                                                echo '<span class="badge bg-warning">No</span>';
                                            }
                                            ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Monthly Rate</th>
                                        <td>
                                            <?php if ($row['monthly_rate'] < $row['original_monthly_rate']) { ?>
                                                <span style="text-decoration: line-through; color: red;">RM <?php echo number_format($row['original_monthly_rate'], 2); ?></span>
                                                RM <?php echo number_format($row['monthly_rate'], 2); ?>/Month
                                            <?php } else { ?>
                                                RM <?php echo number_format($row['monthly_rate'], 2); ?>/Month
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Capacity</th>
                                        <td><?php echo htmlspecialchars($row['capacity']); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Slug</th>
                                        <td><?php echo htmlspecialchars($row['slug']); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Beds</th>
                                        <td><?php echo ($row['master_bedroom'] + $row['regular_bedroom'] + $row['small_bedroom']) . ' Beds'; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Baths</th>
                                        <td><?php echo ($row['master_bath'] + $row['regular_bath'] + $row['small_bath']) . ' Baths'; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Facilities</th>
                                        <td>
                                            <?php
                                            // Convert facilities string into an array
                                            $facilities = explode(',', htmlspecialchars($row['facilities']));
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
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php include 'agent/views/components/footer.php'; ?>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
        function showImage(src) {
            document.getElementById('modalImage').src = src;
        }
    </script>
</body>

</html>