<?php

// session_start();
include('dbconnect.php');
include 'controller/functions.php';


if (isset($_POST['booked'])) {
    $student_id = $_POST['student_id'];
    $studio_id = $_POST['studio_id'];
    $duration = $_POST['duration'];
    $start_date = $_POST['start_date'];
    $studio_price = $_POST['studio_price'];

    // Calculate the end date based on the start date and duration
    $end_date = date('Y-m-d', strtotime("$start_date + $duration days"));

    // SQL query to check if the studio is available for the selected dates
    $query = "
        SELECT * FROM bookings
        WHERE studio_id = ? 
        AND status = 'confirmed' 
        AND (
            (start_date <= ? AND end_date >= ?) OR 
            (start_date <= ? AND end_date >= ?) OR 
            (start_date >= ? AND end_date <= ?)
        )
    ";

    // Prepare and bind parameters
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issssss", $studio_id, $start_date, $start_date, $end_date, $end_date, $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there is any conflicting booking
    if ($result->num_rows > 0) {
        echo "<script>alert('The studio is not available for the selected dates.');</script>";
        echo "<script>location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
    } else {
        echo "The studio is available. Proceeding with booking...";

        // Calculate end date based on start date and duration
        $end_date = date('Y-m-d', strtotime("$start_date + $duration days"));

        $months = $duration * 6;  // Each semester is 6 months
        $total_price = $studio_price * $months;

        // Prepare the SQL insert statement for the booking
        $insertQuery = "
        INSERT INTO bookings (student_id, studio_id, booking_date, duration, start_date, end_date, status, total_price, payment_status, created_at)
        VALUES (?, ?, NOW(), ?, ?, ?, 'confirmed', ?, 'paid', NOW())
    ";

        // Prepare and execute the statement
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("iiissd", $student_id, $studio_id, $duration, $start_date, $end_date, $total_price);


        $student_data = getStudentByStudentId($conn, $student_id);

        // Now, $student_data is an associative array, so you can access values by keys
        $student_name = $student_data['name'];

        $studio_data = getSpecificStudioById($conn, $studio_id);
        // print_r($studio_data);

        $studio_name = $studio_data['studio_name'];
        // echo $studio_name;

        if ($stmt->execute()) {
            // Telegram Bot Notification
            $botToken = "7685430904:AAEfm6EkuXDG3KOAOS-lyKJGnOJxDDHagB4";
            $chatId = "762651953";
            $message = "New booking confirmed for Student Name: $student_name and Studio Name: $studio_name. Duration: $duration semester.";

            // cURL setup
            $telegramUrl = "https://api.telegram.org/bot$botToken/sendMessage";
            $data = [
                'chat_id' => $chatId,
                'text' => $message
            ];

            $ch = curl_init($telegramUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

            // Execute the cURL request
            $response = curl_exec($ch);
            if ($response === false) {
                echo 'Error sending Telegram notification: ' . curl_error($ch);
                echo $response;
            } else {
                echo $response;
                echo 'Telegram notification sent successfully!';
                header("Location: homepage?status=success-booked");
            }

            // Close cURL
            curl_close($ch);
            // echo "<script>location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
        } else {
            echo "<script>alert('Error in booking. Please try again later.');</script>";
            echo "<script>location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
        }
    }
    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
