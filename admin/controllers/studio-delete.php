<?php
// Include your database connection file
echo "2222";

include 'dbconnect.php';
echo "2222";
// Check if the ID is set
if (isset($_POST['id'])) {

    $studio_id = $_POST['id']; // Define $studio_id

    // Get the studio ID from the form
    // Start a transaction to ensure atomic operations
    mysqli_begin_transaction($conn);

    try {
        // Step 1: Delete images related to the studio
        $delete_image_query = "DELETE FROM studioimages WHERE studio_id = ?";
        if ($stmt_images = mysqli_prepare($conn, $delete_image_query)) {
            mysqli_stmt_bind_param($stmt_images, "i", $studio_id);
            mysqli_stmt_execute($stmt_images);
            mysqli_stmt_close($stmt_images);
        }

        // Step 2: Delete the studio record
        $delete_query = "DELETE FROM studios WHERE studio_id = ?";
        if ($stmt_studio = mysqli_prepare($conn, $delete_query)) {
            mysqli_stmt_bind_param($stmt_studio, "i", $studio_id);
            mysqli_stmt_execute($stmt_studio);
            mysqli_stmt_close($stmt_studio);
        }

        // Commit the transaction if everything is successful
        mysqli_commit($conn);

        // echo "success";
        // $_SESSION['status_message'] = 'Studio successfully delete!';
        // Redirect to the studio list with a success message
        header("Location: studios-list?status=success-delete");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction on any error
        mysqli_rollback($conn);

        // Log the error for debugging
        error_log("Error deleting studio: " . $e->getMessage());

        // Redirect with an error message
        header("Location: studios-list?status=error");
        exit();
    }
} else {
    // If the studio ID is not set, redirect with an error message
    header("Location: studios-list");
}

// Close the database connection
mysqli_close($conn);
