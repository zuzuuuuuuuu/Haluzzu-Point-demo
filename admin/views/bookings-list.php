<?php
include 'controller/dbconnect.php';
include 'controller/functions.php';
include 'config.php';

// require 'function.php';
require_once 'router.php';

$limit = 10;

// Get the current page number
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the query
$offset = ($page - 1) * $limit;

// Get the total number of bookings
$total_bookings = getTotalTable($conn, 'bookings');

// Fetch bookings with pagination
$bookings = getAllBooking($conn, $limit, $offset);

// Calculate the total number of pages
$total_pages = ceil($total_bookings / $limit);


?>

<?php include 'admin/views/components/header.php'; ?>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <?php //include 'admin/views/components/spinner.php'; 
        ?>

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
        Booking successfully delete!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="closeAlert()"></button>
    </div>';
            }

            ?>

            <!-- Table Start -->
            <div class="container-fluid pt-4 px-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= $base_url; ?>/<?= $user_type; ?>/dashboard"><i class="fa-solid fa-house" style="margin-right: 5px;"></i>Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All Bookings</li>
                        <!-- <li class="breadcrumb-item"><a href="#"><?php echo htmlspecialchars($studio_name); ?></a></li> -->
                        <!-- <li class="breadcrumb-item active" aria-current="page">Booking Details</li> -->
                    </ol>
                </nav>
                <div class="row g-4">
                    <div class="col-12">
                        <div class="bg-light rounded h-100 p-4 table-responsive">
                            <h6 class="mb-4">All Bookings List</h6>
                            <table class="table table-striped">
                                <thead>
                                    <tr class="text-dark">
                                        <th scope="col">#</th>
                                        <th scope="col">Booking Date</th>
                                        <th scope="col">Invoice</th>
                                        <th scope="col">Student</th>
                                        <th scope="col">Studio</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (mysqli_num_rows($bookings) > 0) : ?>
                                        <?php
                                        $counter = $offset + 1;
                                        ?>
                                        <?php while ($row = mysqli_fetch_assoc($bookings)) : ?>
                                            <tr>
                                                <td><?php echo $counter++; ?></td>
                                                <td><?php echo date('d M Y', strtotime($row['booking_date'])); ?></td>
                                                <td><?php echo 'INV-' . str_pad($row['booking_id'], 4, '0', STR_PAD_LEFT); ?></td>
                                                <td><?php echo $row['student_name']; ?></td>
                                                <td><?php echo $row['studio_name']; ?></td>
                                                <td>RM<?php echo $row['total_price']; ?></td>
                                                <td class="text-center">
                                                    <?php if ($row['status'] == 'confirmed') : ?>
                                                        <span class="badge bg-success">Confirmed</span>
                                                    <?php elseif ($row['status'] == 'pending') : ?>
                                                        <span class="badge bg-warning">Pending</span>
                                                    <?php else : ?>
                                                        <span class="badge bg-danger">Cancelled</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="<?= $base_url ?>/<?= $user_type ?>/bookingDetail?id=<?php echo $row['booking_id']; ?>">View</a></li>
                                                            <!-- <li><a class="dropdown-item" href="booking_edit.php?id=<?php echo $row['booking_id']; ?>">Edit</a></li> -->
                                                            <li>
                                                                <form action="booking-delete" method="POST" onsubmit="return confirm('Are you sure you want to delete this booking?');">
                                                                    <input type="hidden" name="id" value="<?php echo $row['booking_id']; ?>">
                                                                    <button type="submit" class="dropdown-item">Delete</button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="8" class="text-center">No recent bookings found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>

                            <!-- Pagination Controls -->
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <?php if ($page > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                                        </li>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($page < $total_pages): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Table End -->


            <?php include 'admin/views/components/footer.php'; ?>


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