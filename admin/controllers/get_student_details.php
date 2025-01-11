<?php
require 'db_connection.php'; // Include your database connection

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];
    
    // Query to get student details
    $query = "SELECT students.student_id, users.name AS student_name, users.email, students.course, students.faculty 
              FROM students 
              JOIN users ON students.user_id = users.user_id 
              WHERE students.student_id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Return the student details in HTML format
        echo '
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Name:</strong> ' . $row['student_name'] . '</p>
                    <p><strong>Email:</strong> ' . $row['email'] . '</p>
                    <p><strong>Course:</strong> ' . $row['course'] . '</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Faculty:</strong> ' . $row['faculty'] . '</p>
                    <p><strong>Student ID:</strong> ' . $row['student_id'] . '</p>
                </div>
            </div>
        ';
    } else {
        echo '<p class="text-danger">Student details not found.</p>';
    }
} else {
    echo '<p class="text-danger">Invalid student ID.</p>';
}
?>
