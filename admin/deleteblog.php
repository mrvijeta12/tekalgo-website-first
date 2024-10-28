<?php
include_once "session.php";
check_login();
include_once 'database.php';

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "blog";

// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// Fetch all content with slug, summary, and feature image
$sql = "SELECT id, slug, summary ,  social_sharing_image FROM main_website_blog  ORDER BY id DESC";
$result = $conn->query($sql);

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
    <link rel="stylesheet" href="assets/css/deleteblog.css">
    <script>
        function deleteContent(id) {
            // Directly submit the form to delete the content
            document.getElementById('delete-form-' + id).submit();
        }
    </script>
    <style>
       
    </style>
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

        <div class='content-container'>

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
                <p><?= $summary?></p> <!-- Displaying the summary as paragraph -->
              
            </div>

            <!-- Delete Button -->
            <?php if ($id > 0): ?>
                <form id='delete-form-<?= $id ?>' method='POST' action='deletebloglogic.php' style='display: none;'>
                    <input type='hidden' name='delete-id' value='<?= $id ?>'>
                </form>
                <button type='button' onclick='deleteContent(<?= $id ?>)' class='delete-button'>Delete</button>
            <?php endif; ?>

        </div>

    <?php endforeach; ?>
</body>

</html>
