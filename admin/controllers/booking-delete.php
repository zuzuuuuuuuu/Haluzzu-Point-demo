<?php
// Include your database connection file
echo "2222";

include 'dbconnect.php';
echo "2222";
// Check if the ID is set
if (isset($_POST['id'])) {
    // Get the studio ID from the form
    $id = $_POST['id'];

    // Prepare the SQL DELETE query
    $delete_query = "DELETE FROM bookings WHERE booking_id = ?";

    // Prepare a statement for safe execution
    if ($stmt = mysqli_prepare($conn, $delete_query)) {
        // Bind the parameters (s for string, i for integer, etc.)
        mysqli_stmt_bind_param($stmt, "i", $id);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // If the delete is successful, redirect to the studio list page with a success message
            header("Location: bookings-list?status=success-delete");
        } else {
            // If something goes wrong, redirect with an error message
            header("Location: bookings-list");
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // If the query couldn't be prepared, redirect with an error message
        header("Location: bookings-list");
    }
} else {
    // If the studio ID is not set, redirect with an error message
    header("Location: studios-list");
}

// Close the database connection
mysqli_close($conn);
?>
