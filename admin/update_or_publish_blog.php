<?php
include_once "session.php";
check_login();
include_once "database.php";

// Function to generate a slug from a title
function generate_slug($title)
{
    // Convert to lowercase and replace spaces with hyphens
    $slug = strtolower(trim($title));
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);  // Allow only alphanumeric and hyphens
    $slug = preg_replace('/-+/', '-', $slug);  // Replace multiple hyphens with a single one
    return $slug;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = isset($_POST['slug']) ? $_POST['slug'] : '';
    $meta_title = isset($_POST['meta_title']) ? $_POST['meta_title'] : '';
    $summary = isset($_POST['summary']) ? $_POST['summary'] : '';
    $content = isset($_POST['editorContent']) ? $_POST['editorContent'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $social_sharing_image = isset($_FILES['social_sharing_image']) ? $_FILES['social_sharing_image']['name'] : '';

    // Generate the new slug based on the meta_title
    $new_slug = generate_slug($meta_title);

    // If no new image is uploaded, use the current one (this needs to be handled properly)
    if (empty($social_sharing_image)) {
        // Fetch the current image name from the database if no new image is uploaded
        $stmt = $conn->prepare("SELECT social_sharing_image FROM main_website_blog WHERE slug = ?");
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $stmt->bind_result($current_image);
        if ($stmt->fetch()) {
            $social_sharing_image = $current_image;
        }
        $stmt->close();
    }

    // Check if the slug exists in the database
    $stmt = $conn->prepare("SELECT COUNT(*) FROM main_website_blog WHERE slug = ?");
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $stmt->bind_result($slug_exists);
    $stmt->fetch();
    $stmt->close();

    // If the slug does not exist, show an error and exit
    if ($slug_exists == 0) {
        die('The provided slug does not exist in the database.');
    }

    // Determine the action (Update or Publish)
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    // If the action is 'Update Draft', update the content with 'draft' status
    if ($action === 'Update Draft') {
        // Update the slug along with the rest of the fields
        $stmt = $conn->prepare("UPDATE main_website_blog SET meta_title = ?, summary = ?, content = ?, category = ?, social_sharing_image = ?, slug = ? WHERE slug = ? AND blog_status = 'draft'");
        if ($stmt === false) {
            die('MySQL prepare error: ' . htmlspecialchars($conn->error));
        }

        // Bind the correct number of parameters (7 in total)
        $stmt->bind_param("sssssss", $meta_title, $summary, $content, $category, $social_sharing_image, $new_slug, $slug);

        if (!$stmt->execute()) {
            die('MySQL execute error: ' . htmlspecialchars($stmt->error));
        }

        // Redirect to drafts page after updating the draft
        header("Location: drafts.php");
        exit;
    }

    // If the action is 'Publish', update the content and change status to 'published'
    if ($action === 'Publish') {
        // Update the slug along with the rest of the fields
        $stmt = $conn->prepare("UPDATE main_website_blog SET meta_title = ?, summary = ?, content = ?, category = ?, social_sharing_image = ?, slug = ?, blog_status = 'published' WHERE slug = ? AND blog_status = 'draft'");
        if ($stmt === false) {
            die('MySQL prepare error: ' . htmlspecialchars($conn->error));
        }

        // Bind the correct number of parameters (7 in total)
        $stmt->bind_param("sssssss", $meta_title, $summary, $content, $category, $social_sharing_image, $new_slug, $slug);

        if (!$stmt->execute()) {
            die('MySQL execute error: ' . htmlspecialchars($stmt->error));
        }

        // Redirect to dashboard after publishing the blog
        header("Location: dashboard.php");
        exit;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "No data received.";
}
