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

    // Handle form submission to update the studio details
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $studio_name = $_POST['studio_name'];
        $location = $_POST['location'];
        $state = $_POST['state'];
        $description = $_POST['description'];
        $monthly_rate = $_POST['monthly_rate'];
        $original_monthly_rate = $_POST['original_monthly_rate'];

        $trending = $_POST['trending'];
        $capacity = $_POST['capacity'];
        $availability_status = $_POST['availability_status'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $master_bedroom = $_POST['master_bedroom'];
        $regular_bedroom = $_POST['regular_bedroom'];
        $small_bedroom = $_POST['small_bedroom'];
        $master_bath = $_POST['master_bath'];
        $regular_bath = $_POST['regular_bath'];
        $small_bath = $_POST['small_bath'];
        $slug = $_POST['slug'];
        $type = $_POST['type'];
        $facilities = implode(', ', $_POST['facilities']);

        $update_query = "UPDATE studios SET 
            studio_name = '$studio_name', 
            location = '$location', 
            state = '$state', 
            trending = '$trending', 
            capacity = '$capacity', 
            availability_status = '$availability_status', 
            latitude = '$latitude', 
            longitude = '$longitude', 
            master_bedroom = '$master_bedroom', 
            regular_bedroom = '$regular_bedroom', 
            small_bedroom = '$small_bedroom', 
            master_bath = '$master_bath', 
            regular_bath = '$regular_bath', 
            small_bath = '$small_bath', 
            slug = '$slug', 
            type = '$type', 
            description = '$description', 
            monthly_rate = '$monthly_rate', 
            original_monthly_rate = '$original_monthly_rate', 
            facilities = '$facilities'
            WHERE studio_id = '$id'";

        if (mysqli_query($conn, $update_query)) {
            echo "Studio updated successfully.";
            header("Location: studioDetail?id=$id");
            exit();
        } else {
            echo "Error updating studio: " . mysqli_error($conn);
        }
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
                        <li class="breadcrumb-item active" aria-current="page">Edit Studio Details</li>
                    </ol>
                </nav>

                <div class="row g-4">
                    <div class="col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <div style="display: flex; justify-content: space-between">
                                <h4 class="mb-4">Edit Studio Information</h4>
                                <button class="btn btn-primary mb-3" onclick="window.history.back();">Back</button>
                            </div>

                            <form action="" method="POST">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <th>Studio Name</th>
                                            <td><input type="text" name="studio_name" value="<?= htmlspecialchars($row['studio_name']); ?>" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Location</th>
                                            <td><input type="text" name="location" value="<?= htmlspecialchars($row['location']); ?>" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>State</th>
                                            <td><input type="text" name="state" value="<?= htmlspecialchars($row['state']); ?>" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Description</th>
                                            <td><textarea name="description" class="form-control"><?= htmlspecialchars($row['description']); ?></textarea></td>
                                        </tr>
                                        <tr>
                                            <th>Type</th>
                                            <td>
                                                <select name="type" class="form-control">
                                                    <option value="Apartment" <?= ($row['type'] == 'Apartment') ? 'selected' : '' ?>>Apartment</option>
                                                    <option value="Condominium" <?= ($row['type'] == 'Condominium') ? 'selected' : '' ?>>Condominium</option>
                                                    <option value="Flat" <?= ($row['type'] == 'Flat') ? 'selected' : '' ?>>Flat</option>
                                                    <option value="Semi-D" <?= ($row['type'] == 'Semi-D') ? 'selected' : '' ?>>Semi-D</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                <select name="availability_status" class="form-control">
                                                    <option value="available" <?= ($row['availability_status'] == 'available') ? 'selected' : '' ?>>Available</option>
                                                    <option value="under maintenance" <?= ($row['availability_status'] == 'under maintenance') ? 'selected' : '' ?>>Under Maintenance</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <!-- <tr>
                                            <th>Trending</th>
                                            <td>
                                                <select name="trending" class="form-control">
                                                    <option value="0" <?= ($row['trending'] == '0') ? 'selected' : '' ?>>No</option>
                                                    <option value="1" <?= ($row['trending'] == '1') ? 'selected' : '' ?>>Yes</option>
                                                </select>
                                            </td>
                                        </tr> -->
                                        <tr>
                                            <th>Monthly Rate<br>(After Discount)</th>
                                            <td><input type="number" step="0.01" name="monthly_rate" value="<?= htmlspecialchars($row['monthly_rate']); ?>" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Original Monthly Rate</th>
                                            <td><input type="number" step="0.01" name="original_monthly_rate" value="<?= htmlspecialchars($row['original_monthly_rate']); ?>" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Capacity</th>
                                            <td><input type="number" step="1" name="capacity" value="<?= htmlspecialchars($row['capacity']); ?>" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Slug</th>
                                            <td><input type="text" name="slug" value="<?= htmlspecialchars($row['slug']); ?>" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Master Bedroom</th>
                                            <td><input type="number" step="1" name="master_bedroom" value="<?= htmlspecialchars($row['master_bedroom']); ?>" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Regular Bedroom</th>
                                            <td><input type="number" step="1" name="regular_bedroom" value="<?= htmlspecialchars($row['regular_bedroom']); ?>" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Small Bedroom</th>
                                            <td><input type="number" step="1" name="small_bedroom" value="<?= htmlspecialchars($row['small_bedroom']); ?>" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Master Bath</th>
                                            <td><input type="number" step="1" name="master_bath" value="<?= htmlspecialchars($row['master_bath']); ?>" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Regular Bath</th>
                                            <td><input type="number" step="1" name="regular_bath" value="<?= htmlspecialchars($row['regular_bath']); ?>" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Small Bath</th>
                                            <td><input type="number" step="1" name="small_bath" value="<?= htmlspecialchars($row['small_bath']); ?>" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Facilities</th>
                                            <td>
                                                <?php
                                                $facility_options = ['Wi-Fi', 'Swimming Pool', 'Air Conditioning', '24-hour Security', 'Sea View', 'River View', 'Kitchenette', 'Washing Machine', 'Parking', 'Gym', 'Balcony'];
                                                $selected_facilities = explode(', ', htmlspecialchars($row['facilities']));
                                                foreach ($facility_options as $facility) {
                                                    $checked = in_array($facility, $selected_facilities) ? 'checked' : '';
                                                    echo "<label><input type='checkbox' name='facilities[]' value='$facility' $checked> $facility</label><br>";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Latitude</th>
                                            <td><input type="text" name="latitude" value="<?= htmlspecialchars($row['latitude']); ?>" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Longitude</th>
                                            <td><input type="text" name="longitude" value="<?= htmlspecialchars($row['longitude']); ?>" class="form-control"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-success">Save Changes</button>
                            </form>
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
</body>

</html>