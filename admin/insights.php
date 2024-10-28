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
    <style>
        .container {
            display: flex;
            justify-content: space-between;
            margin: 20px;
        }

        .text-content {
            flex: 1; /* Take the remaining space */
            padding-right: 20px; /* Add space between text and image */
        }

        .image-container {
            width: 300px; /* Set width for the feature image */
        }

        .image-container img {
            width: 100%;
            height: auto;
        }

        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <?php include "navbar.php"; ?>
    
    <div class="container">
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
            <p><?php echo htmlspecialchars($blog['summary']); ?></p>
            <div><?php echo $blog['content']; ?></div>
        </div>
        <a href="dashboard.php" class="back-button">Back to Dashboard</a>
    </div>

</body>

</html>
