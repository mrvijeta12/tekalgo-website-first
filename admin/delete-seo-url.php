<?php
include_once "session.php";
check_login();
include_once 'database.php';



// Check if delete ID is provided
if (isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    echo $id;

    // Prepare and execute delete statement
    $stmt = $conn->prepare("DELETE FROM public_pages_seo_setup WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Successful deletion
        header("Location:basic-details.php");
        exit;
    } else {
        // Error handling
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No ID provided for deletion.";
}

$conn->close();
