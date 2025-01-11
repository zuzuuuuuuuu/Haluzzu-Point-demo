<?php
include 'controller/dbconnect.php';
include 'controller/functions.php';
include 'config.php';


if (isset($_GET['id'])) {
    $coupon_id = $_GET['id'];
    $query = "SELECT * FROM coupons WHERE coupon_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $coupon_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
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
                <div class="bg-light rounded h-100 p-4">
                    <h4 class="mb-4">Coupon Details</h4>

                    <table class="table table-bordered">
                        <tr>
                            <th>Coupon Code</th>
                            <td><?= htmlspecialchars($row['coupon_code']) ?></td>
                        </tr>
                        <tr>
                            <th>Discount Type</th>
                            <td><?= htmlspecialchars($row['discount_type']) ?></td>
                        </tr>
                        <tr>
                            <th>Discount Value</th>
                            <td><?= htmlspecialchars($row['discount_value']) ?></td>
                        </tr>
                        <tr>
                            <th>Start Date</th>
                            <td><?= htmlspecialchars($row['start_date']) ?></td>
                        </tr>
                        <tr>
                            <th>End Date</th>
                            <td><?= htmlspecialchars($row['end_date']) ?></td>
                        </tr>
                        <tr>
                            <th>Active</th>
                            <td><?= $row['is_active'] ? 'Yes' : 'No' ?></td>
                        </tr>
                    </table>

                    <a href="<?= $base_url ?>/<?= $user_type ?>/coupons-list" class="btn btn-secondary">Back to List</a>
                </div>
            </div>

            <?php include 'admin/views/components/footer.php'; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
