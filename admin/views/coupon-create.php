<?php
include 'controller/dbconnect.php';
include 'controller/functions.php';
include 'config.php';

// Handle form submission for creating a new coupon
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $coupon_code = $_POST['coupon_code'];
    $discount_type = $_POST['discount_type'];
    $discount_value = $_POST['discount_value'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    // Insert the new coupon into the database
    $insert_query = "INSERT INTO coupons (coupon_code, discount_type, discount_value, start_date, end_date, is_active) 
                     VALUES ('$coupon_code', '$discount_type', '$discount_value', '$start_date', '$end_date', '$is_active')";

    if (mysqli_query($conn, $insert_query)) {
        // Redirect to the coupon list after successful creation
        header("Location: coupons-list?status=success-create");
        exit();
    } else {
        // Handle errors if the insertion fails
        echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
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
                <div class="bg-light rounded h-100 p-4">
                    <h4 class="mb-4">Create Coupon</h4>

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="coupon_code" class="form-label">Coupon Code</label>
                            <input type="text" name="coupon_code" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="discount_type" class="form-label">Discount Type</label>
                            <select name="discount_type" class="form-select">
                                <option value="fixed">Fixed</option>
                                <option value="percentage">Percentage</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="discount_value" class="form-label">Discount Value</label>
                            <input type="number" name="discount_value" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active">
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Coupon</button>
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
