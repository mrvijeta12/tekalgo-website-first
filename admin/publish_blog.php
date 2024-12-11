<?php
include_once "session.php";
check_login();
include_once "database.php";

// Check if the blog ID is passed
if (isset($_POST['blog_id'])) {
    $blog_id = $_POST['blog_id'];

    // Update the blog status to 'published'
    $sql = "UPDATE main_website_blog SET blog_status = 'published' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $blog_id);

    if ($stmt->execute()) {
        // Redirect back to the drafts page after publishing
        header("Location: drafts.php");
        exit;
    } else {
        echo "Error publishing blog.";
    }

    $stmt->close();
}

$conn->close();
