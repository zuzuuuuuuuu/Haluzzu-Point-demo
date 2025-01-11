<?php

session_start();
include('dbconnect.php');

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password = $_POST['password'];
$student_no = $_POST['student_no'];
$campus_location = $_POST['campus'];
$state = $_POST['state'];

// Check if the username already exists in the user table
$sql_user = "SELECT * FROM users WHERE email='$email'";
$result_user = mysqli_query($conn, $sql_user);
$row_user = mysqli_fetch_assoc($result_user);

// Check if any row is returned from any of the three tables
if ($row_user) {
    // if(isset($redirect)){
    //     echo "<script>alert('Nama pengguna sudah terdaftar');</script>";
    //     echo "<script>location.href='$redirect'</script>";
    // }else{
    echo "<script>alert('Email is not available');</script>";
    echo "<script>location.href='$base_url/signup'</script>";
    // }

} else {
    // Insert the new record into the user table
    $sql = "INSERT INTO users (name, phone_number, email, password, user_type)
            VALUES ('$name', '$phone', '$email', '$password', 'student')";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        // Jump to indexwrong page
        echo "<script>location.href='../404.html'</script>";
    } else {
        $user_id = mysqli_insert_id($conn);

        // Insert the new record into the students table using the user_id
        $sql = "INSERT INTO students (user_id, student_no, campus_location, state)
                VALUES ('$user_id', '$student_no', '$campus_location', '$state')";
        $result = mysqli_query($conn, $sql);

        $sql = "INSERT INTO user_coupons (user_id, coupon_id)
                VALUES ('$user_id', '1')";
        $result = mysqli_query($conn, $sql);
        // if(isset($redirect)){
        //     echo "<script>alert('Succesfully register');</script>";
        //     echo "<script>location.href='$redirect'</script>";
        // }else{
        echo "<script>alert('Succesfully register your account');</script>";
        echo "<script>location.href='$base_url/log-in'</script>";
        // }

    }
}

mysqli_close($conn);
