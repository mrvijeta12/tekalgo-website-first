<?php
include_once "session.php";
check_login();
include_once 'database.php';

// Get the slug from the URL
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

// Prepare and execute the query
$sql = "SELECT id, meta_title, summary, content, social_sharing_image FROM main_website_blog WHERE slug = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();

$blog = null;
if ($result->num_rows > 0) {
    $blog = $result->fetch_assoc();
    // Decode HTML entities in summary to avoid extra encoding issues
    $blog['summary'] = html_entity_decode($blog['summary']);
} else {
    echo "No content found.";
    exit;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($blog['meta_title']); ?></title>
    <link rel="stylesheet" href="assets/css/viewContent.css">
</head>

<body>
    <!-- Navigation Bar -->
    <?php include "navbar.php"; ?>

    <div class="container">
        <main class="content">
            <!-- Image Container -->
            <div class="image-container">
                <?php
                $imagePath = htmlspecialchars($blog['social_sharing_image']); // Get the image path
                ?>
                <?php if ($imagePath): ?>
                    <img src="<?php echo $imagePath; ?>" alt="Feature Image">
                <?php else: ?>
                    <img src="default-image.png" alt="Default Image"> <!-- Optional default image -->
                <?php endif; ?>
            </div>

            <!-- Text Content -->
            <div class="text-content">
                <h1><?php echo htmlspecialchars($blog['meta_title']); ?></h1>
                <!-- Displaying summary with raw HTML (line breaks preserved) -->
                <p><?php echo $blog['summary']; ?></p>

                <!-- Display content with raw HTML (line breaks and other tags preserved) -->
                <div><?php echo $blog['content']; ?></div>
            </div>

        </main>
    </div>

</body>

</html>