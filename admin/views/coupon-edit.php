<?php
include 'controller/dbconnect.php';
include 'controller/functions.php';
include 'config.php';

// Check if coupon ID is set
if (isset($_GET['id'])) {
    $coupon_id = $_GET['id'];
    $coupon_query = "SELECT * FROM coupons WHERE coupon_id = ?";
    $stmt = mysqli_prepare($conn, $coupon_query);
    mysqli_stmt_bind_param($stmt, "i", $coupon_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

// Update the coupon if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $coupon_code = $_POST['coupon_code'];
    $discount_type = $_POST['discount_type'];
    $discount_value = $_POST['discount_value'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    // echo $end_date;

    $update_query = "UPDATE coupons SET 
    coupon_code='$coupon_code', 
    discount_type='$discount_type', 
    discount_value='$discount_value', 
    is_active='$is_active', 
    end_date='$end_date', 
    start_date='$start_date' 
  WHERE coupon_id=$coupon_id";

    // $update_query = "UPDATE coupons SET coupon_code = ?, discount_type = ?, discount_value = ?, start_date = ?, end_date = ?, is_active = ? WHERE coupon_id = ?";
    // $stmt = mysqli_prepare($conn, $update_query);
    // mysqli_stmt_bind_param($stmt, "ssdsdii", $coupon_code, $discount_type, $discount_value, $start_date, $end_date, $is_active, $coupon_id);
    // if (mysqli_stmt_execute($stmt)) {
    //     header("Location: coupons-list");
    // }
    // mysqli_stmt_close($stmt);
    mysqli_query($conn, $update_query);

    // Redirect to agent details page after successful update
    header("Location: coupons-list");
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
                <div class="bg-light rounded h-100 p-4">
                    <h4 class="mb-4">Edit Coupon</h4>

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="coupon_code" class="form-label">Coupon Code</label>
                            <input type="text" name="coupon_code" class="form-control" value="<?= htmlspecialchars($row['coupon_code']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="discount_type" class="form-label">Discount Type</label>
                            <select name="discount_type" class="form-select">
                                <option value="fixed" <?= $row['discount_type'] == 'fixed' ? 'selected' : '' ?>>Fixed</option>
                                <option value="percentage" <?= $row['discount_type'] == 'percentage' ? 'selected' : '' ?>>Percentage</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="discount_value" class="form-label">Discount Value</label>
                            <input type="number" name="discount_value" class="form-control" value="<?= htmlspecialchars($row['discount_value']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" name="start_date" class="form-control" value="<?= htmlspecialchars($row['start_date']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" name="end_date" class="form-control" value="<?= htmlspecialchars($row['end_date']) ?>" required>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" <?= $row['is_active'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Coupon</button>
                    </form>
                </div>
            </div>

            <?php include 'admin/views/components/footer.php'; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
