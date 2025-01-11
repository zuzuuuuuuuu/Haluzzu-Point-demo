<?php
require_once 'config.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$routes = [
    "$base_url" => 'views/index.php',
    "$base_url/log-in" => 'views/login.php',
    "$base_url/signup" => 'views/signup.php',
    "$base_url/details" => 'views/booking-details.php',
    "$base_url/search-studios" => 'views/search-studios.php',
    "$base_url/submit-login" => 'controller/submit-login.php',
    "$base_url/submit-register" => 'controller/submit-register.php',
    "$base_url/submit-booking" => 'controller/submit-booking.php',


    //students
    "$base_url/homepage" => 'students/views/bookings-list.php',
    "$base_url/logout" => 'students/controllers/logout.php',
    "$base_url/bookingDetail" => 'students/views/booking-detail.php',
    "$base_url/coupons-list" => 'students/views/coupons-list.php',
    "$base_url/couponDetail" => 'students/views/coupon-detail.php',
    "$base_url/booking-delete" => 'students/controllers/booking-delete.php',
    "$base_url/my-profile" => 'students/views/student-detail.php',
    "$base_url/profileEdit" => 'students/views/student-edit.php',


    //admin
    "$base_url/admin/dashboard" => 'admin/views/dashboard.php',
    "$base_url/admin/login" => 'admin/views/login.php',
    "$base_url/admin/logout" => 'admin/controllers/logout.php',
    "$base_url/admin/bookings-list" => 'admin/views/bookings-list.php',
    "$base_url/admin/students-list" => 'admin/views/users-list.php',
    "$base_url/admin/agents-list" => 'admin/views/agents-list.php',
    "$base_url/admin/studios-list" => 'admin/views/studios-list.php',
    "$base_url/admin/studioDetail" => 'admin/views/studio-detail.php',
    "$base_url/admin/studioEdit" => 'admin/views/studio-edit.php',
    "$base_url/admin/studioCreate" => 'admin/views/create-studio.php',
    "$base_url/submit-login-admin" => 'admin/controllers/submit-login.php',
    "$base_url/admin/bookingDetail" => 'admin/views/booking-detail.php',
    "$base_url/admin/studentDetail" => 'admin/views/student-detail.php',
    "$base_url/admin/studentEdit" => 'admin/views/student-edit.php',
    "$base_url/admin/agentDetail" => 'admin/views/agent-detail.php',
    "$base_url/admin/agentEdit" => 'admin/views/agent-edit.php',
    "$base_url/admin/studio-delete" => 'admin/controllers/studio-delete.php',
    "$base_url/admin/coupons-list" => 'admin/views/coupons-list.php',
    "$base_url/admin/couponDetail" => 'admin/views/coupon-detail.php',
    "$base_url/admin/couponEdit" => 'admin/views/coupon-edit.php',
    "$base_url/admin/couponCreate" => 'admin/views/coupon-create.php',
    "$base_url/admin/coupon-delete" => 'admin/controllers/coupon-delete.php',
    "$base_url/admin/booking-delete" => 'admin/controllers/booking-delete.php',


    //agent
    "$base_url/agent/dashboard" => 'agent/views/dashboard.php',
    "$base_url/agent/logout" => 'agent/controllers/logout.php',
    "$base_url/agent/logout" => 'agent/controllers/logout.php',
    "$base_url/agent/bookings-list" => 'agent/views/bookings-list.php',
    "$base_url/agent/bookingDetail" => 'agent/views/booking-detail.php',
    "$base_url/agent/studio-delete" => 'agent/controllers/studio-delete.php',
    "$base_url/agent/booking-delete" => 'agent/controllers/booking-delete.php',
    "$base_url/agent/studios-list" => 'agent/views/studios-list.php',
    "$base_url/agent/studioDetail" => 'agent/views/studio-detail.php',
    "$base_url/agent/studioEdit" => 'agent/views/studio-edit.php',
    "$base_url/agent/studioCreate" => 'agent/views/create-studio.php',

];



function routeToController($uri, $routes, $base_url)
{

    // echo $routes[$uri];
    if (isset($routes[$uri])) {
        $route = $routes[$uri];

        if ($route == "views/booking-details.php") {
            if (isset($_GET['studio'])) {
                // Process the parameter or perform any actions
                // require "views/booking-details.php";

            }
        }
        if ($route == "admin/views/booking-detail.php") {
            if (isset($_GET['id'])) {
                // Process the parameter or perform any actions
                // require "admin/views/booking-details.php";

            }
        }
    }
    if (array_key_exists($uri, $routes)) {

        $file = $routes[$uri];
        if (file_exists($file)) {
            require $file;
        }
    } else if ($uri != $base_url . '/') {
        require "views/error.php";
        die();
    }
}

routeToController($uri, $routes, $base_url);
