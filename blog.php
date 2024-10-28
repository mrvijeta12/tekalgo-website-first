<?php

include_once 'db.php';


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
    <title>Blog</title>
    <link rel="stylesheet" href="assests/css/blog.css">
    <link rel="stylesheet" href="assests/css/theme.css">
    <link rel="stylesheet" href="assests/css/navbar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
      <!-- Font Awesome CDN for icons -->
      <script src="https://kit.fontawesome.com/cdf9a174a4.js" crossorigin="anonymous"></script>
</head>

<body>
    <div>
        <?php include('navbar.php'); ?>
        <div class="wrapper" data-aos="fade-right" data-aos-duration="1500">
            <div class="about">
                <h1> Building Smarter on Salesforce</h1>
                <h2>Explore Powerful Development Techniques, Solutions, and Industry Insights</h2>
            </div>
           

            <div class="about_container" data-aos="zoom-in" data-aos-duration="1500">
                <h2>Our Blog</h2>
                <div class="circle-container">
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="circle"></div>
                </div>
                
            </div>
            <?php foreach ($contents as $row): ?>
    <?php
    $slug = htmlspecialchars($row['slug']);
    $summary = htmlspecialchars($row['summary']);
    $id = $row['id'];
    $featureImage = !empty($row['social_sharing_image']) ? 'admin/' . htmlspecialchars($row['social_sharing_image']) : 'default-image.png';
    ?>
 <div class='content-container'  data-aos="zoom-in" data-aos-duration="1500">
        <!-- Image Container -->
        <div class='image-container'>
            <img src='<?= $featureImage ?>' alt='Feature Image'>
        </div>

        <!-- Text Content -->  
        <div class='text-content'>
            <h2><?= $slug ?></h2> <!-- Displaying the slug as meta_title -->
            <p><?= $summary ?></p>
            <a href="insights/<?= $slug ?>" class="read-more">Read More <img src="images/right-arrow.svg" alt="" id="arrow"></a>
        </div>

    </div>
   
<?php endforeach; ?>


            
            <?php include "footer.php"; ?>
           
          
        </div>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({
                once: true,
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="swiper.js"></script>
    </div>
</body>

</html>