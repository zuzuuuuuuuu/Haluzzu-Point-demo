<?php
// Include your database connection file
echo "2222";

include 'dbconnect.php';
echo "2222";
// Check if the ID is set
if (isset($_POST['id'])) {
    // Get the studio ID from the form
    $studio_id = $_POST['id'];

    // Prepare the SQL DELETE query
    $delete_query = "DELETE FROM studios WHERE studio_id = ?";

    // Prepare a statement for safe execution
    if ($stmt = mysqli_prepare($conn, $delete_query)) {
        // Bind the parameters (s for string, i for integer, etc.)
        mysqli_stmt_bind_param($stmt, "i", $studio_id);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // If the delete is successful, redirect to the studio list page with a success message
            header("Location: studios-list");
        } else {
            // If something goes wrong, redirect with an error message
            header("Location: studios-list");
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // If the query couldn't be prepared, redirect with an error message
        header("Location: studios-list");
    }
} else {
    // If the studio ID is not set, redirect with an error message
    header("Location: studios-list");
}

// Close the database connection
mysqli_close($conn);
?>
