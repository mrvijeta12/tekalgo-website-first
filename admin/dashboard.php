<?php
include_once "session.php";
check_login();
include_once 'database.php';


// Fetch all blog posts with slug, summary, and feature image
$sql = "SELECT id, slug, summary, social_sharing_image FROM main_website_blog ORDER BY id DESC";
$result = $conn->query($sql);

// Check if the query was successful
if ($result === false) {
    die("SQL Error: " . $conn->error); // Output the error message
}

$contents = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $contents[] = $row;
    }
} else {
    $contents[] = ["id" => 0, "slug" => "No content found.", "summary" => "", "social_sharing_image" => ""];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Content Layout</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <script>
        function handleContainerClick(event, slug) {
            if (!event.target.classList.contains('edit-button')) {
                // Redirecting to viewContent.php with the slug
                window.location.href = 'insights?slug=' + encodeURIComponent(slug);
            }
        }
    </script>
    
</head>

<body>
    <?php include "navbar.php"; ?>

    <?php foreach ($contents as $row): ?>
        <?php
        $slug = htmlspecialchars($row['slug']);
        $summary = htmlspecialchars($row['summary']);
        $id = $row['id'];
        $featureImage = htmlspecialchars($row['social_sharing_image']);
        ?>

        <div class='content-container' onclick='handleContainerClick(event, "<?= $slug ?>")'>
            <!-- Image Container -->
            <div class='image-container'>
                <?php if ($featureImage): ?>
                    <img src='<?= $featureImage ?>' alt='Feature Image'>
                <?php else: ?>
                    <img src='default-image.png' alt='Default Image'> <!-- Optional default image -->
                <?php endif; ?>
            </div>

            <!-- Text Content -->  
            <div class='text-content'>
                <h2><?= $slug ?></h2> <!-- Displaying the slug as meta_title -->
                <p><?= $summary ?></p>
            </div>

            <!-- Edit Button -->
            <?php if ($id > 0): ?>
                <form method='GET' action='editblog' class='edit-form'>
                    <input type='hidden' name='slug' value='<?= $slug ?>'>
                    <button type='submit' class='edit-button'>Edit</button>
                </form>
            <?php endif; ?>
        </div>

    <?php endforeach; ?>
</body>

</html>
