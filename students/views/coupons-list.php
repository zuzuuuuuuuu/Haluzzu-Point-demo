<?php
include 'controller/dbconnect.php';
include 'controller/functions.php';
include 'config.php';

$student_data = getStudentByUserId($conn, $_SESSION['user_id']);
$student_id = $student_data['student_id'] ?? null; // Use null if 'agent_id' is not found
$query = "SELECT c.* 
          FROM coupons c 
          JOIN user_coupons uc ON c.coupon_id = uc.coupon_id 
          WHERE uc.user_id = ? AND c.end_date > NOW()";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);  // "i" denotes an integer type
$stmt->execute();
$result = $stmt->get_result();
?>

<?php include 'students/views/components/header.php'; ?>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <?php include 'students/views/components/sidebar.php'; ?>

        <!-- Content Start -->
        <div class="content">
            <?php include 'students/views/components/navbar.php'; ?>

            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded h-100 p-4">
                    <h4 class="mb-4">Coupons List<?= $_SESSION['user_id'] ?></h4>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Coupon Code</th>
                                <th>Discount Value</th>
                                <!-- <th>Start Date</th> -->
                                <th>End Date</th>
                                <th>Status</th>
                                <!-- <th>Actions</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $status = ($row['is_active'] && strtotime($row['end_date']) >= time()) ? 'Active' : 'Deactive';
                            ?>
                                <tr>
                                    <td><?= $count++ ?></td>
                                    <td><?= htmlspecialchars($row['coupon_code']) ?></td>
                                    <td>
                                        <?php if ($row['discount_type'] != "percentage") { ?>
                                            RM<?= htmlspecialchars($row['discount_value']) ?>
                                        <?php } else { ?>
                                            <?= intval($row['discount_value']) ?>%
                                        <?php } ?>
                                    </td>
                                    <td><?= htmlspecialchars($row['end_date']) ?></td>
                                    <td><?= $status ?></td>
                                    <!-- <td>
                                        <a href="couponDetail?id=<?= $row['coupon_id'] ?>" class="btn btn-info btn-sm">View</a>
                                        <a href="couponEdit?id=<?= $row['coupon_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="coupon-delete" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                                            <input type="hidden" name="id" value="<?= $row['coupon_id'] ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td> -->
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php include 'students/views/components/footer.php'; ?>
        </div>
    </div>

    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>