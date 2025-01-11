<?php
// Include your database connection file
include 'controller/dbconnect.php';
include 'controller/functions.php';
include 'config.php';



// Handle form submission to update the studio details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $studio_name = $_POST['studio_name'];
    $location = $_POST['location'];
    $state = $_POST['state'];
    $description = $_POST['description'];
    $address = $_POST['address'];
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

    $insert_query = "INSERT INTO studios (
        studio_name, 
        location, 
        state, 
        trending, 
        capacity, 
        availability_status, 
        latitude, 
        longitude, 
        master_bedroom, 
        regular_bedroom, 
        small_bedroom, 
        master_bath, 
        regular_bath, 
        small_bath, 
        slug, 
        type, 
        description, 
        address,
        monthly_rate, 
        original_monthly_rate, 
        facilities,
        agent_id
    ) VALUES (
        '$studio_name', 
        '$location', 
        '$state', 
        '$trending', 
        '$capacity', 
        '$availability_status', 
        '$latitude', 
        '$longitude', 
        '$master_bedroom', 
        '$regular_bedroom', 
        '$small_bedroom', 
        '$master_bath', 
        '$regular_bath', 
        '$small_bath', 
        '$slug', 
        '$type', 
        '$description', 
        '$address', 
        '$monthly_rate', 
        '$original_monthly_rate', 
        '$facilities',
        '14'
    )";

    if (mysqli_query($conn, $insert_query)) {
        $studio_id = mysqli_insert_id($conn); // Get the ID of the newly created studio

        // Handle Multiple Image Uploads
        if (!empty($_FILES['images']['name'][0])) {
            $upload_directory = "uploads/";
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

            foreach ($_FILES['images']['name'] as $key => $image_name) {
                $image_tmp_name = $_FILES['images']['tmp_name'][$key];
                $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

                if (in_array($image_ext, $allowed_extensions)) {
                    // Rename image to avoid conflicts
                    $new_image_name = uniqid('studio_img_', true) . '.' . $image_ext;
                    $upload_path = $upload_directory . $new_image_name;

                    // Move uploaded file to the uploads directory
                    if (move_uploaded_file($image_tmp_name, $upload_path)) {
                        // Insert image details into the images table
                        $caption = "Image for studio $studio_name"; // Default caption
                        $insert_image = "INSERT INTO studioimages (caption, studio_id, image_path, created_at) 
                                     VALUES ('$caption', '$studio_id', '$new_image_name', NOW())";

                        mysqli_query($conn, $insert_image);
                    } else {
                        echo "Failed to upload image: $image_name<br>";
                    }
                } else {
                    echo "Invalid file type for image: $image_name<br>";
                }
            }
        }
        echo "Studio created successfully with images.";
        header("Location: studios-list");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<?php include 'admin/views/components/header.php'; ?>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <?php include 'admin/views/components/sidebar.php'; ?>

        <!-- Content Start -->
        <div class="content">
            <?php include 'admin/views/components/navbar.php'; ?>

            <div class="container-fluid pt-4 px-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= $base_url; ?>/<?= $user_type; ?>/dashboard"><i class="fa-solid fa-house" style="margin-right: 5px;"></i>Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= $base_url; ?>/<?= $user_type; ?>/studios-list">All Studios</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Studio</li>
                    </ol>
                </nav>

                <div class="row g-4">
                    <div class="col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <div style="display: flex; justify-content: space-between">
                                <h4 class="mb-4">Create Studio Information</h4>
                                <button class="btn btn-primary mb-3" onclick="window.history.back();">Back</button>
                            </div>

                            <form action="" method="POST" enctype="multipart/form-data">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <th>Studio Name*</th>
                                            <td><input type="text" name="studio_name" class="form-control" required></td>
                                        </tr>
                                        <tr>
                                            <th for="images">Upload Images (Multiple):</th>
                                            <td><input type="file" name="images[]" id="images" multiple accept="image/*" required></td>
                                        </tr>
                                        <tr>
                                            <th>Location*</th>
                                            <td><input type="text" name="location" class="form-control" required></td>
                                        </tr>
                                        <tr>
                                            <th>State*</th>
                                            <td>
                                                <select name="state" class="form-control" required>
                                                    <option value="">Select State</option>
                                                    <?php
                                                    $malaysian_states = [
                                                        'Johor',
                                                        'Kedah',
                                                        'Kelantan',
                                                        'Melaka',
                                                        'Negeri Sembilan',
                                                        'Pahang',
                                                        'Perak',
                                                        'Perlis',
                                                        'Pulau Pinang',
                                                        'Sabah',
                                                        'Sarawak',
                                                        'Selangor',
                                                        'Terengganu',
                                                        'Kuala Lumpur',
                                                        'Labuan',
                                                        'Putrajaya'
                                                    ];

                                                    foreach ($malaysian_states as $state) {
                                                        echo "<option value='$state'>$state</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Address*</th>
                                            <td><textarea name="address" class="form-control" required></textarea></td>
                                        </tr>
                                        <tr>
                                            <th>Description*</th>
                                            <td><textarea name="description" class="form-control" required></textarea></td>
                                        </tr>
                                        <tr>
                                            <th>Type*</th>
                                            <td>
                                                <select name="type" class="form-control" required>
                                                    <option value="">Select Type</option>
                                                    <option value="Apartment">Apartment</option>
                                                    <option value="Condominium">Condominium</option>
                                                    <option value="Flat">Flat</option>
                                                    <option value="Semi-D">Semi-D</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status*</th>
                                            <td>
                                                <select name="availability_status" class="form-control" required>
                                                    <option value="available">Available</option>
                                                    <option value="under maintenance">Under Maintenance</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Trending*</th>
                                            <td>
                                                <select name="trending" class="form-control">
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Monthly Rate<br>(After Discount)*</th>
                                            <td>RM <input type="number" step="0.01" name="monthly_rate" class="form-control" required></td>
                                        </tr>
                                        <tr>
                                            <th>Original Monthly Rate*</th>
                                            <td>RM <input type="number" step="0.01" name="original_monthly_rate" class="form-control" required></td>
                                        </tr>
                                        <tr>
                                            <th>Capacity*</th>
                                            <td><input type="number" step="1" name="capacity" class="form-control" required></td>
                                        </tr>
                                        <tr>
                                            <th>Slug*</th>
                                            <td><input type="text" name="slug" class="form-control" placeholder="name-studio" required></td>
                                        </tr>
                                        <tr>
                                            <th>Master Bedroom*</th>
                                            <td><input type="number" step="1" name="master_bedroom" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Regular Bedroom*</th>
                                            <td><input type="number" step="1" name="regular_bedroom" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Small Bedroom*</th>
                                            <td><input type="number" step="1" name="small_bedroom" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Master Bath*</th>
                                            <td><input type="number" step="1" name="master_bath" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Regular Bath*</th>
                                            <td><input type="number" step="1" name="regular_bath" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Small Bath*</th>
                                            <td><input type="number" step="1" name="small_bath" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <th>Facilities*</th>
                                            <td>
                                                <?php
                                                $facility_options = ['Wi-Fi', 'Swimming Pool', 'Air Conditioning', '24-hour Security', 'Sea View', 'River View', 'Kitchenette', 'Washing Machine', 'Parking', 'Gym', 'Balcony'];
                                                foreach ($facility_options as $facility) {
                                                    echo "<label><input type='checkbox' name='facilities[]' value='$facility'> $facility</label><br>";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Latitude*</th>
                                            <td><input type="text" name="latitude" class="form-control" required></td>
                                        </tr>
                                        <tr>
                                            <th>Longitude*</th>
                                            <td><input type="text" name="longitude" class="form-control" required></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-success">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php include 'admin/views/components/footer.php'; ?>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>