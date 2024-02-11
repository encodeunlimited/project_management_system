<?php
include 'db_connect.php';

// Check if the discussion ID is provided in the request
if (isset($_GET['id'])) {
    // Get the discussion ID from the request
    $discussionId = $_GET['id'];

    // Perform the deletion
    $sql = "DELETE FROM discussion_list WHERE id = $discussionId";

    if ($conn->query($sql) === TRUE) {
        echo "Discussion deleted successfully";
    } else {
        echo "Error deleting discussion: " . $conn->error;
    }
} else {
    echo "Discussion ID is not provided";
}

// Close the database connection
$conn->close();
?>
