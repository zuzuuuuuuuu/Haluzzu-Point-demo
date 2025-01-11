<?php
// Include your database connection and necessary functions
include 'controller/dbconnect.php';
include 'controller/functions.php';
include 'config.php';
require_once 'router.php';

// Check if the agent ID is set
if (isset($_GET['id'])) {
    $agent_id = $_GET['id'];
    $agent = getAllAgentById($conn, $agent_id);
    $row = mysqli_fetch_assoc($agent);
    
    // Set default image if no profile image is available
    $image_profile_page = !empty($row['image_profile']) ? $row['image_profile'] : 'default_profile.jpg';
} else {
    echo "Invalid agent ID.";
    exit();
}

// Update logic for the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $business_name = $_POST['business_name'];
    $studio_location = $_POST['studio_location'];
    $state = $_POST['state'];

    // Image handling logic
    if (!empty($_FILES['profile_image']['name'])) {
        $target_dir = "uploads/";
        $profile_image = basename($_FILES["profile_image"]["name"]);
        $target_file = $target_dir . $profile_image;

        // Move the uploaded file to the target directory
        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);

        // Update the profile image in the database
        $image_profile_page = $profile_image;
    }

    // Update the agents and users table
    $update_users_query = "UPDATE users SET 
                            name='$name', 
                            email='$email', 
                            phone_number='$phone_number', 
                            image_profile='$image_profile_page' 
                          WHERE user_id='{$row['user_id']}'";

    $update_agents_query = "UPDATE agents SET 
                            business_name='$business_name', 
                            studio_location='$studio_location', 
                            state='$state' 
                          WHERE agent_id='$agent_id'";

    mysqli_query($conn, $update_users_query);
    mysqli_query($conn, $update_agents_query);

    // Redirect to agent details page after successful update
    header("Location: agentDetail?id=" . $agent_id);
    exit();
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
                <div class="row g-4">
                    <div class="col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h4 class="mb-4">Edit Agent Information</h4>

                            <form method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="profile_image" class="form-label">Profile Image</label>
                                    <div>
                                        <img id="preview" src="<?= $base_url; ?>/uploads/<?php echo htmlspecialchars($image_profile_page); ?>" alt="Profile Image" style="width: 70px; height: 70px; margin-bottom: 10px; " class="rounded-circle">
                                    </div>
                                    <input type="file" name="profile_image" id="profile_image" class="form-control" onchange="previewImage(event)">
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Phone Number</label>
                                    <input type="text" name="phone_number" class="form-control" value="<?php echo htmlspecialchars($row['phone_number']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="business_name" class="form-label">Business Name</label>
                                    <input type="text" name="business_name" class="form-control" value="<?php echo htmlspecialchars($row['business_name']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="studio_location" class="form-label">Business Location</label>
                                    <input type="text" name="studio_location" class="form-control" value="<?php echo htmlspecialchars($row['studio_location']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <input type="text" name="state" class="form-control" value="<?php echo htmlspecialchars($row['state']); ?>" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Update Agent</button>
                                <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php include 'admin/views/components/footer.php'; ?>

            <script>
                // Preview image before uploading
                function previewImage(event) {
                    var reader = new FileReader();
                    reader.onload = function(){
                        var output = document.getElementById('preview');
                        output.src = reader.result;
                    };
                    reader.readAsDataURL(event.target.files[0]);
                }
            </script>
        </div>
    </div>
</body>

</html>
