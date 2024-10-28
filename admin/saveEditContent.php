<?php
include_once "session.php";
check_login();
include_once 'database.php';

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "blog";

// $conn = new mysqli($servername, $username, $password, $dbname);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// Get the form data
$meta_title = isset($_POST['meta_title']) ? $_POST['meta_title'] : '';
$summary = isset($_POST['summary']) ? $_POST['summary'] : '';
$content = isset($_POST['editorContent']) ? $_POST['editorContent'] : '';
$slug = isset($_POST['slug']) ? $_POST['slug'] : '';

// Handle feature image upload if a new one is provided
$social_sharing_image = '';
if (isset($_FILES['social_sharing_image']) && $_FILES['social_sharing_image']['error'] == UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/'; // Directory where images will be uploaded
    $uploadFile = $uploadDir . basename($_FILES['social_sharing_image']['name']);
    
    // Move the uploaded file to the specified directory
    if (move_uploaded_file($_FILES['social_sharing_image']['tmp_name'], $uploadFile)) {
        $social_sharing_image = $uploadFile; // Set the feature image to the new upload
    }
}

// Prepare the SQL update statement
if ($social_sharing_image) {
    $stmt = $conn->prepare("UPDATE  main_website_blog SET meta_title=?, summary=?, content=?, social_sharing_image=? WHERE slug=?");
    $stmt->bind_param("sssss", $meta_title, $summary, $content, $social_sharing_image, $slug);
} else {
    $stmt = $conn->prepare("UPDATE  main_website_blog SET meta_title=?, summary=?, content=? WHERE slug=?");
    $stmt->bind_param("ssss", $meta_title, $summary, $content, $slug);
}

// Execute the statement
if ($stmt->execute()) {
    echo "Blog post updated successfully.";
    header("Location: dashboard.php"); // Redirect to the dashboard after updating
    exit;
} else {
    echo "Error updating record: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
