<?php
// Include your database connection file
include 'controller/dbconnect.php';
include 'controller/functions.php';
include 'config.php';

// require 'function.php';
require_once 'router.php';

// Check if the booking ID is set
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $students = getAllStudentByUserId($conn, $user_id);
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

<?php include 'students/views/components/header.php'; ?>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">

        <?php //include 'students/views/components/spinner.php';
        ?>

        <?php include 'students/views/components/sidebar.php'; ?>



        <!-- Content Start -->
        <div class="content">

            <?php include 'students/views/components/navbar.php'; ?>

            <div class="container-fluid pt-4 px-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= $base_url; ?>/homepage"><i class="fa-solid fa-house" style="margin-right: 5px;"></i>Home</a></li>
                        <!-- <li class="breadcrumb-item"><a href="<?= $base_url; ?>/<?= $user_type; ?>/students-list">All Students</a></li> -->
                        <!-- <li class="breadcrumb-item"><a href="#"><?php echo htmlspecialchars($row['student_name']); ?></a></li> -->
                        <li class="breadcrumb-item active" aria-current="page">My Profile</li>
                    </ol>
                </nav>
                <div class="row g-4">
                    <div class="col-lg-6 col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <div style="display: flex; justify-content: space-between">
                                <h4 class="mb-4">Student Information</h4>
                                <a class="btn btn-primary mb-3" href="<?= $base_url ?>/profileEdit">Edit</a>
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

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>