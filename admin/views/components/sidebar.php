 <?php




    ?>

 <!-- Sidebar Start -->
 <div class="sidebar pe-4 pb-3">
     <nav class="navbar bg-light navbar-light">
         <a href="<?= $base_url ?>" class="navbar-brand mx-4 mb-3">
             <h3 class="text-primary"><?= $system_name ?></h3>
         </a>
         <div class="d-flex align-items-center ms-4 mb-4">
             <div class="position-relative">
                 <img class="rounded-circle me-lg-2" src="<?php echo $base_url; ?>/uploads/<?php echo htmlspecialchars($image_profile); ?>" alt="Profile Image" style="width: 40px; height: 40px;">
                 <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
             </div>
             <div class="ms-3">
                 <h6 class="mb-0"><?= ucwords($current_user['name']) ?></h6>
                 <span><?= $current_user['user_type'] ?></span>
             </div>
         </div>
         <div class="navbar-nav w-100">
             <?php
                $current_url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // Get the current URL path

                // Check for active navigation items based on keywords
                $is_dashboard = strpos($current_url, 'dashboard') !== false;
                $is_bookings = strpos($current_url, 'booking') !== false;
                $is_users = strpos($current_url, 'student') !== false;
                $is_agents = strpos($current_url, 'agent') !== false;
                $is_studios = strpos($current_url, 'studio') !== false;
                $is_coupons = strpos($current_url, 'coupon') !== false;
                ?>

             <nav>
                 <a href="<?= $base_url; ?>/<?= $user_type ?>/dashboard" class="nav-item nav-link <?= $is_dashboard ? 'active' : ''; ?>">
                     <i class="fa fa-tachometer-alt me-2"></i>Dashboard
                 </a>
                 <a href="<?= $base_url; ?>/<?= $user_type ?>/bookings-list" class="nav-item nav-link <?= $is_bookings ? 'active' : ''; ?>">
                     <i class="fa-solid fa-book"></i>All Bookings
                 </a>
                 <a href="<?= $base_url; ?>/<?= $user_type ?>/students-list" class="nav-item nav-link <?= $is_users ? 'active' : ''; ?>">
                     <i class="fa-solid fa-user-graduate"></i>Students
                 </a>
                 <a href="<?= $base_url; ?>/<?= $user_type ?>/agents-list" class="nav-item nav-link <?= $is_agents ? 'active' : ''; ?>">
                     <i class="fa-solid fa-user-ninja"></i>Agents
                 </a>
                 <a href="<?= $base_url; ?>/<?= $user_type ?>/studios-list" class="nav-item nav-link <?= $is_studios ? 'active' : ''; ?>">
                     <i class="fa-solid fa-house"></i>Studios
                 </a>
                 <a href="<?= $base_url; ?>/<?= $user_type ?>/coupons-list" class="nav-item nav-link <?= $is_coupons ? 'active' : ''; ?>">
                     <i class="fa-solid fa-ticket"></i>Coupon
                 </a>
             </nav>
         </div>
     </nav>
 </div>
 <!-- Sidebar End -->