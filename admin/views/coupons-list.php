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
            <?php
            // Check if the 'status' query parameter exists
            $status = isset($_GET['status']) ? $_GET['status'] : '';

            if ($status === 'success-delete') {
                echo '
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Coupon successfully delete!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="closeAlert()"></button>
    </div>';
            }

            if ($status === 'success-create') {
                echo '
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Coupon successfully create!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="closeAlert()"></button>
    </div>';
            }

            ?>
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded h-100 p-4">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-4">Coupons List</h6>
                        <a href="<?= $base_url; ?>/<?= $user_type; ?>/couponCreate">
                            <div class="btn btn-primary mb-4">Create Coupon</div>
                        </a>
                    </div>

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
    <script>
        // Function to close the alert and remove the status from the URL
        function closeAlert() {
            // Remove the 'status' query parameter from the URL
            const url = new URL(window.location.href);
            url.searchParams.delete('status');
            window.history.pushState({}, '', url);
        }
    </script>
</body>

</html>