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

// Get the total number of studios
$total = getTotalTable($conn, 'studios');

// Fetch studios with pagination
$studios = getAllStudio($conn, $limit, $offset);

// Calculate the total number of pages
$total_pages = ceil($total / $limit);


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


            <!-- Table Start -->
            <div class="container-fluid pt-4 px-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= $base_url; ?>/<?= $user_type; ?>/dashboard"><i class="fa-solid fa-house" style="margin-right: 5px;"></i>Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All Studios</li>
                        <!-- <li class="breadcrumb-item"><a href="#"><?php echo htmlspecialchars($studio_name); ?></a></li> -->
                        <!-- <li class="breadcrumb-item active" aria-current="page">Booking Details</li> -->
                    </ol>
                </nav>
                <div class="row g-4">
                    <div class="col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Studios List</h6>
                            <table class="table table-striped">
                                <thead>
                                    <tr class="text-dark">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">State</th>
                                        <th scope="col">Monthly Rate</th>
                                        <th scope="col">Agent Name</th>
                                        <th scope="col">Business Name</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Trending</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (mysqli_num_rows($studios) > 0) : ?>
                                        <?php
                                        $counter = $offset + 1;
                                        ?>
                                        <?php while ($row = mysqli_fetch_assoc($studios)) : ?>
                                            <tr>
                                                <td><?php echo $counter++; ?></td>
                                                <td><?php echo $row['studio_name']; ?></td>
                                                <td><?php echo $row['location']; ?></td>
                                                <td><?php echo $row['state']; ?></td>
                                                <?php
                                                $original_monthly_rate = $row['original_monthly_rate'];
                                                $monthly_rate = $row['monthly_rate'];
                                                ?>
                                                <td><?php if ($monthly_rate > 0 && $monthly_rate < $original_monthly_rate) { ?>
                                                        <small>
                                                            <span style="text-decoration: line-through; color: red;">RM <?php echo number_format($original_monthly_rate, 2); ?></span>
                                                            <br>RM <?php echo number_format($monthly_rate, 2); ?>
                                                        </small>
                                                    <?php } else { ?>
                                                        <small>
                                                            RM <?php echo number_format($original_monthly_rate, 2); ?>
                                                        </small>
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['business_name']; ?></td>
                                                <td>
                                                    <?php
                                                    if ($row['availability_status'] == 'available') {
                                                        echo '<span class="badge bg-success">Available</span>';
                                                    } else if ($row['availability_status'] == 'under maintenance') {
                                                        echo '<span class="badge bg-danger">Under Maintenance</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($row['trending'] == 1) {
                                                        echo '<span class="badge bg-success">Yes</span>';
                                                    } else {
                                                        echo '<span class="badge bg-warning">No</span>';
                                                    }
                                                    ?>
                                                </td>

                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="<?= $base_url ?>/<?= $user_type ?>/studioDetail?id=<?php echo $row['studio_id']; ?>">View</a></li>
                                                            <li><a class="dropdown-item" href="<?= $base_url ?>/<?= $user_type ?>/studioEdit?id=<?php echo $row['studio_id']; ?>">Edit</a></li>
                                                            <li>
                                                                <form action="<?= $base_url?>/<?= $user_type ?>/studio-delete" method="POST" onsubmit="return confirm('Are you sure you want to delete this studio?');">
                                                                    <input type="hidden" name="id" value="<?php echo $row['studio_id']; ?>">
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
                                            <td colspan="8" class="text-center">No recent studios found</td>
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
</body>



</html>