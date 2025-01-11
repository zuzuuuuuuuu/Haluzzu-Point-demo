<?php
// Include your database connection and other necessary files
include 'controller/dbconnect.php';
include 'controller/functions.php';
include 'config.php';

// Check if the student ID is set
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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_name = $_POST['student_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $student_no = $_POST['student_no'];
    $campus_location = $_POST['campus_location'];
    $state = $_POST['state'];
    $profile_path_new = $image_profile_page;  // Default image if no upload is done

    // Check if an image file was uploaded
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $profile_image = $_FILES['profile_image'];
        $image_ext = pathinfo($profile_image['name'], PATHINFO_EXTENSION);
        $allowed_exts = array("jpg", "jpeg", "png", "gif");

        if (in_array($image_ext, $allowed_exts)) {
            $profile_path_new = uniqid() . '.' . $image_ext;
            move_uploaded_file($profile_image['tmp_name'], 'uploads/' . $profile_path_new);
        } else {
            echo "Invalid file format. Only JPG, PNG, and GIF are allowed.";
        }
    }

    // Start transaction to update both tables
    mysqli_begin_transaction($conn);

    try {
        // Update the users table
        $update_users = "UPDATE users SET 
                            name='$student_name', 
                            email='$email', 
                            phone_number='$phone_number', 
                            image_profile='$profile_path_new'
                        WHERE user_id=(SELECT user_id FROM students WHERE student_id='$student_id')";

        // Update the students table
        $update_students = "UPDATE students SET 
                            student_no='$student_no', 
                            campus_location='$campus_location', 
                            state='$state'
                        WHERE student_id='$student_id'";

        // Execute both queries
        mysqli_query($conn, $update_users);
        mysqli_query($conn, $update_students);

        // Commit transaction
        mysqli_commit($conn);

        echo "Student details updated successfully.";
        header("Location: students-list"); // Redirect after updating
        exit();
    } catch (Exception $e) {
        // Rollback transaction if something goes wrong
        mysqli_rollback($conn);
        echo "Error updating student details: " . $e->getMessage();
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
                <div class="row g-4">
                    <div class="col-lg-6 col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h4 class="mb-4">Edit Student Information</h4>
                            <form method="POST" enctype="multipart/form-data">
                                <div class="form-group mb-3">
                                    <label for="profile_image">Profile Image</label>
                                    <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*" onchange="previewImage(event)">
                                    <?php
                                    // Check if the image profile is set, otherwise default to 'noimage.jpg'
                                    $image_profile_page = isset($row['image_profile']) && !empty($row['image_profile']) ? $row['image_profile'] : 'noimage.jpg';
                                    ?>

                                    <img id="preview" src="<?= $base_url; ?>/uploads/<?php echo htmlspecialchars($image_profile_page); ?>" alt="Profile Image" style="max-width: 100px; margin-top: 10px;">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="student_name">Name</label>
                                    <input type="text" class="form-control" id="student_name" name="student_name" value="<?php echo htmlspecialchars($row['student_name']); ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="phone_number">Phone</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($row['phone_number']); ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="student_no">Student No</label>
                                    <input type="text" class="form-control" id="student_no" name="student_no" value="<?php echo htmlspecialchars($row['student_no']); ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="campus_location">Campus</label>
                                    <input type="text" class="form-control" id="campus_location" name="campus_location" value="<?php echo htmlspecialchars($row['campus_location']); ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="state">State</label>
                                    <input type="text" class="form-control" id="state" name="state" value="<?php echo htmlspecialchars($row['state']); ?>" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Update Student Details</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php include 'admin/views/components/footer.php'; ?>
        </div>
    </div>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>