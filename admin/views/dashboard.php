<?php
include 'controller/dbconnect.php';
include 'controller/functions.php';
include 'config.php';

// require 'function.php';
require_once 'router.php';

// Usage
$total_users = getTotalUsers($conn);

$sales_data = getMonthlySales($conn);
$sales = $sales_data['sales'];
$months = $sales_data['months'];

$sales_state_data = getSalesByState($conn);
$states = $sales_state_data['states'];
$total_rents = $sales_state_data['total_rents'];
$bookings = getAllBookingButLimit($conn, 10);
?>

<?php include 'admin/views/components/header.php'; ?>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">

        <?php include 'admin/views/components/spinner.php';
        ?>

        <?php include 'admin/views/components/sidebar.php'; ?>



        <!-- Content Start -->
        <div class="content">

            <?php include 'admin/views/components/navbar.php'; ?>


            <!-- Sale & Revenue Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-line fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Today Sales</p>
                                <h6 class="mb-0">RM<?= getTodaySales($conn); ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-bar fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Sales</p>
                                <h6 class="mb-0">RM<?= getTotalSales($conn); ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa-solid fa-users fa-2xl text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Users</p>
                                <h6 class="mb-0"><?= $total_users['total_users']; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa-solid fa-house fa-2xl text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Studios</p>
                                <h6 class="mb-0"><?= getTotalStudios($conn); ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sale & Revenue End -->


            <!-- Sales Chart Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light text-center rounded p-4">
                            <h6 class="mb-4">Sales by Month (<?= date('Y'); ?>)</h6>
                            <canvas id="salesChart" style="width: 100%; height: 400px;"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light text-center rounded p-4">
                            <h6 class="mb-4">Sales by State (<?= date('Y'); ?>)</h6>
                            <canvas id="rentChart"" style=" width: 100%; height: 400px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sales Chart End -->



            <!-- Recent Sales Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Recent Bookings</h6>
                        <a href="">Show All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col"><input class="form-check-input" type="checkbox"></th>
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
                                    <?php while ($row = mysqli_fetch_assoc($bookings)) : ?>
                                        <tr>
                                            <td><input class="form-check-input" type="checkbox"></td>
                                            <td><?php echo date('d M Y', strtotime($row['booking_date'])); ?></td>
                                            <td><?php echo 'INV-' . str_pad($row['booking_id'], 4, '0', STR_PAD_LEFT); ?></td>
                                            <td><?php echo $row['student_name']; ?></td>
                                            <td><?php echo $row['studio_name']; ?></td>
                                            <td>RM<?php echo $row['total_price']; ?></td>
                                            <td><?php if ($row['status'] == 'confirmed') : ?>
                                                    <span class="badge bg-success">Confirmed</span>
                                                <?php elseif ($row['status'] == 'pending') : ?>
                                                    <span class="badge bg-warning">Pending</span>
                                                <?php else : ?>
                                                    <span class="badge bg-danger">Cancelled</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><a class="btn btn-sm btn-primary" href="bookingDetail?id=<?php echo $row['booking_id']; ?>">Detail</a></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No recent bookings found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Sales End -->


            <!-- Widgets Start -->
            <!-- <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="mb-0">Messages</h6>
                                <a href="">Show All</a>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-3">
                                <img class="rounded-circle flex-shrink-0" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-0">Jhon Doe</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                    <span>Short message goes here...</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-3">
                                <img class="rounded-circle flex-shrink-0" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-0">Jhon Doe</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                    <span>Short message goes here...</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-3">
                                <img class="rounded-circle flex-shrink-0" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-0">Jhon Doe</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                    <span>Short message goes here...</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center pt-3">
                                <img class="rounded-circle flex-shrink-0" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-0">Jhon Doe</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                    <span>Short message goes here...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Calender</h6>
                                <a href="">Show All</a>
                            </div>
                            <div id="calender"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">To Do List</h6>
                                <a href="">Show All</a>
                            </div>
                            <div class="d-flex mb-2">
                                <input class="form-control bg-transparent" type="text" placeholder="Enter task">
                                <button type="button" class="btn btn-primary ms-2">Add</button>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-2">
                                <input class="form-check-input m-0" type="checkbox">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <span>Short task goes here...</span>
                                        <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-2">
                                <input class="form-check-input m-0" type="checkbox">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <span>Short task goes here...</span>
                                        <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-2">
                                <input class="form-check-input m-0" type="checkbox" checked>
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <span><del>Short task goes here...</del></span>
                                        <button class="btn btn-sm text-primary"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-2">
                                <input class="form-check-input m-0" type="checkbox">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <span>Short task goes here...</span>
                                        <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center pt-2">
                                <input class="form-check-input m-0" type="checkbox">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <span>Short task goes here...</span>
                                        <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- Widgets End -->


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
                document.addEventListener('DOMContentLoaded', function() {
                    // Assuming this is your sales data from PHP
                    const salesData = <?= json_encode($sales_data['sales']); ?>; // This is your sales object
                    const labels = <?= json_encode($sales_data['months']); ?>; // Array of month names

                    // Convert sales object to an array
                    const sales = [];
                    for (let i = 1; i <= 12; i++) {
                        sales.push(salesData[i] || 0); // Default to 0 if no sales
                    }

                    const formattedSales = sales.map(amount => amount > 0 ? amount.toFixed(2) : '0.00');

                    const data = {
                        labels: labels,
                        datasets: [{
                            label: 'Total Sales (RM)',
                            data: formattedSales,
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    };

                    const config = {
                        type: 'line',
                        data: data,
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Total Sales (RM)'
                                    },
                                    ticks: {
                                        callback: function(value) {
                                            return 'RM' + value;
                                        }
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Months'
                                    }
                                }
                            }
                        }
                    };

                    // Render the chart
                    const salesChart = new Chart(
                        document.getElementById('salesChart'),
                        config
                    );
                });
            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const states = <?= json_encode($sales_state_data['states']); ?>; // Array of states
                    const totalRents = <?= json_encode($sales_state_data['total_rents']); ?>; // Array of total rents

                    const formattedRents = totalRents.map(amount => amount > 0 ? amount.toFixed(2) : '0.00');

                    const data = {
                        labels: states,
                        datasets: [{
                            label: 'Total Rent (RM)',
                            data: formattedRents,
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    };

                    const config = {
                        type: 'bar',
                        data: data,
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Total Rent (RM)'
                                    },
                                    ticks: {
                                        callback: function(value) {
                                            return 'RM' + value;
                                        }
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'States'
                                    }
                                }
                            }
                        }
                    };

                    // Render the chart
                    const rentChart = new Chart(
                        document.getElementById('rentChart'),
                        config
                    );
                });
            </script>




</body>

</html>