<?php
// Include your database connection file
include 'dbconnect.php';

// Check if the agent ID is set
if (isset($_POST['id'])) {
    $student_id = $_POST['id'];

    // Start a transaction
    mysqli_begin_transaction($conn);

    try {
        // Prepare the SQL DELETE query for students
        $delete_query_agent = "DELETE FROM students WHERE student_id = ?";
        $delete_query_user = "DELETE FROM users WHERE user_id = ?"; // Assuming 'user_id' is the correct column in the users table

        // Prepare statement for agent deletion
        if ($stmt_agent = mysqli_prepare($conn, $delete_query_agent)) {
            // Bind the agent ID
            mysqli_stmt_bind_param($stmt_agent, "i", $student_id);

            // Execute the statement
            mysqli_stmt_execute($stmt_agent);
            mysqli_stmt_close($stmt_agent);
        } else {
            throw new Exception("Failed to prepare agent delete query.");
        }

        // Prepare statement for user deletion
        if ($stmt_user = mysqli_prepare($conn, $delete_query_user)) {
            // Bind the agent ID (assuming it matches with user_id)
            mysqli_stmt_bind_param($stmt_user, "i", $student_id);

            // Execute the statement
            mysqli_stmt_execute($stmt_user);
            mysqli_stmt_close($stmt_user);
        } else {
            throw new Exception("Failed to prepare user delete query.");
        }

        // Commit the transaction if both queries succeeded
        mysqli_commit($conn);
        
        // Redirect with a success message
        header("Location: students-list?status=success-delete");
    } catch (Exception $e) {
        // Rollback the transaction in case of any error
        mysqli_rollback($conn);

        // Redirect with an error message
        header("Location: students-list.php");
    }
} else {
    // If the agent ID is not set, redirect with an error message
    header("Location: students-list");
}

// Close the database connection
mysqli_close($conn);
?>
