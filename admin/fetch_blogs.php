<?php
include_once "session.php";
include_once "database.php";

check_login();

// Get the category from the AJAX request
$category = isset($_GET['category']) ? trim($_GET['category']) : 'insights';

// Fetch blogs based on the selected category and ensure only published blogs are retrieved
$sql = "SELECT id, slug, summary,social_sharing_image 
        FROM main_website_blog
        WHERE category = ? AND blog_status = 'published' 
        ORDER BY id DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $category);
$stmt->execute();
$result = $stmt->get_result();

$blogs = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $blogs[] = $row;
    }
}

// Return the results as JSON
header("Content-Type: application/json");
echo json_encode($blogs);

$stmt->close();
$conn->close();
