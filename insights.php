<?php
include_once 'db.php';

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
    <link rel="stylesheet" href="/tekalgo/assests/css/insights.css">


    <link rel="stylesheet" href="../assests/css/navbar.css" />
   <link rel="stylesheet" href="../assests/css/theme.css" />
   <link rel="stylesheet" href="../assests/css/footer.css" />

  

  


    <!-- AOS CSS CDN for scroll animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

      <!-- Font Awesome CDN for icons -->
      <script src="https://kit.fontawesome.com/cdf9a174a4.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Navigation Bar -->
    <?php 
    include
     "navbar.php"; 
     ?>
    <div class="wrapper">
    <section class="hero">
        <h1>Expert Insights and Trends on Salesforce Solutions</h1>
        <h2>Tips, trends, and strategies to optimize your Salesforce journey.</h2>
    </section>
        <div class="container"  >
        <div class="share-options" data-aos="fade-left" data-aos-duration="1500">
                     
                    
                     <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode("https://salesforceclouds.com/insights/" . $slug); ?>&text=<?php echo urlencode($blog['meta_title']); ?>" target="_blank"><i class="fa-brands fa-square-x-twitter"></i></a>
                     <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode("https://salesforceclouds.com/insights/" . $slug); ?>&title=<?php echo urlencode($blog['meta_title']); ?>" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
                     <a href="https://api.whatsapp.com/send?text=<?php echo urlencode("Check out this blog post: " . "https://salesforceclouds.com/insights/" . $slug); ?>" target="_blank"><i class="fa-brands fa-square-whatsapp"></i></a>
                 </div>
        
    
    
            <!-- Text Content -->
            <div class="text-content">
                <h1><?php echo htmlspecialchars($blog['meta_title']); ?></h1>
                <p ><?php echo htmlspecialchars($blog['summary']); ?></p>
                <div class="image-container">
                <?php 
                    // Fetch the image from the database, check if it's available
                    $featureImage = !empty($blog['social_sharing_image']) ? '/tekalgo/admin/' . htmlspecialchars($blog['social_sharing_image']) : 'default-image.png';
                ?>
                <img src='<?php echo $featureImage; ?>' alt='Feature Image'>
            </div>
                <div><?php echo $blog['content']; ?></div>
                <!-- <a href="blog.php" class="back-button">Back to Blogs</a> -->
            </div>
    
             <!-- Share Options -->
             
             
        </div>

    </div>

   
    

    
    <!-- Footer -->
     <?php include "footer.php";?>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({
                once: true,
            });
        </script>

</body>

</html>
