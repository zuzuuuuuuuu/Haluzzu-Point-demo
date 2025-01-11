<?php
include 'controller/dbconnect.php';
include 'controller/functions.php';
include 'config.php';

$query = "SELECT * FROM coupons ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
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
                    <h4 class="mb-4">Coupons List</h4>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Coupon Code</th>
                                <th>Discount Type</th>
                                <th>Discount Value</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $status = ($row['is_active'] && strtotime($row['end_date']) >= time()) ? 'Active' : 'Expired';
                            ?>
                                <tr>
                                    <td><?= $count++ ?></td>
                                    <td><?= htmlspecialchars($row['coupon_code']) ?></td>
                                    <td><?= htmlspecialchars($row['discount_type']) ?></td>
                                    <td><?= htmlspecialchars($row['discount_value']) ?></td>
                                    <td><?= htmlspecialchars($row['start_date']) ?></td>
                                    <td><?= htmlspecialchars($row['end_date']) ?></td>
                                    <td><?= $status ?></td>
                                    <td>
                                        <a href="couponDetail?id=<?= $row['coupon_id'] ?>" class="btn btn-info btn-sm">View</a>
                                        <a href="couponEdit?id=<?= $row['coupon_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="coupon-delete" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                                            <input type="hidden" name="id" value="<?= $row['coupon_id'] ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php include 'admin/views/components/footer.php'; ?>
        </div>
    </div>

    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
