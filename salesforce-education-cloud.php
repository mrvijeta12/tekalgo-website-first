<?php

include_once 'db.php';

// Pagination settings
$blogsPerPage = 3; // Number of blogs per page
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$offset = ($currentPage - 1) * $blogsPerPage; // Offset calculation

// Fetch blogs with pagination
$sql = "SELECT id, slug, summary, social_sharing_image FROM main_website_blog 
        WHERE category = 'salesforce-education-cloud' AND blog_status = 'published' 
        ORDER BY id DESC 
        LIMIT $blogsPerPage OFFSET $offset";
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
    $contents[] = ["id" => 0, "slug" => "No content found.", "summary" => "", "social_sharing_image" => ""]; // Empty placeholder
}

// Count total blogs for pagination
$totalBlogsResult = $conn->query("SELECT COUNT(*) AS total FROM main_website_blog WHERE category = 'salesforce-education-cloud' AND blog_status = 'published'");
$totalBlogs = $totalBlogsResult->fetch_assoc()['total'];
$totalPages = ceil($totalBlogs / $blogsPerPage); // Total number of pages

$conn->close();

// Check if it's an AJAX request to return only the blog wrapper and pagination
if (isset($_GET['ajax']) && $_GET['ajax'] === '1') {
    echo json_encode([
        'content' => renderBlogs($contents),
        'pagination' => renderPagination($currentPage, $totalPages)
    ]);
    exit();
}
// Helper function to render the blogs
function renderBlogs($blogs)
{
    $html = '';
    foreach ($blogs as $row) {
        $slug = htmlspecialchars($row['slug']);
        $summary = htmlspecialchars($row['summary']);
        $featureImage = !empty($row['social_sharing_image']) ? 'admin/' . htmlspecialchars($row['social_sharing_image']) : 'default-image.png';

        $html .= "<div class='content-container'>
                    <div class='image-container'>
                        <img src='{$featureImage}' alt='Feature Image'>
                    </div>
                    <div class='text-content'>
                        <h2>{$slug}</h2>
                        <a href='insight/{$slug}' class='read-more'>Read More <img src='images/right-arrow.svg' alt='' id='arrow'></a>
                    </div>
                </div>";
    }

    return $html;
}

// Helper function to render the pagination
function renderPagination($currentPage, $totalPages)
{
    $pagination = '';

    if ($currentPage > 1) {
        $pagination .= "<a href='#' class='prev' data-page='" . ($currentPage - 1) . "'>Previous</a>";
    }

    for ($i = 1; $i <= $totalPages; $i++) {
        $pagination .= "<a href='#' class='" . ($i === $currentPage ? 'active' : '') . "' data-page='{$i}'>{$i}</a>";
    }

    if ($currentPage < $totalPages) {
        $pagination .= "<a href='#' class='next' data-page='" . ($currentPage + 1) . "'>Next</a>";
    }

    return $pagination;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Primary Meta Tags -->
    <meta charset="UTF-8">
    <title>Salesforce Education Cloud Services | Empower Educational Institutions | SalesClouds</title>
    <meta name="description" content="Enhance student engagement and streamline educational operations with Salesforce Education Cloud from SalesClouds. From K-12 schools to higher education, deliver personalized support, track student success, and manage recruitment and alumni relations. Book your free consultation today.">
    <meta name="keywords" content="Salesforce Education Cloud, student engagement, recruitment and admissions, K-12 school management, higher education CRM, alumni and donor management, student success tools, LMS integration, educational cloud, SalesClouds services">
    <meta name="author" content="SalesClouds">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://www.salesclouds.com/services/salesforce-education-cloud">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.salesclouds.com/services/salesforce-education-cloud">
    <meta property="og:title" content="Salesforce Education Cloud Services | Empower Educational Institutions | SalesClouds">
    <meta property="og:description" content="Learn how SalesClouds can help educational institutions enhance student engagement, streamline recruitment, and manage alumni relations with Salesforce Education Cloud. Book your free consultation today!">
    <meta property="og:image" content="https://www.salesclouds.com/images/salesforce-education-cloud-thumbnail.jpg">
    <meta property="og:locale" content="en_US">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="https://www.salesclouds.com/services/salesforce-education-cloud">
    <meta name="twitter:title" content="Salesforce Education Cloud Services | Empower Educational Institutions | SalesClouds">
    <meta name="twitter:description" content="Transform education with Salesforce Education Cloud from SalesClouds. Streamline operations and engage students, faculty, and staff with AI-powered insights and personalized communications. Book your free consultation today!">
    <meta name="twitter:image" content="https://www.salesclouds.com/images/salesforce-education-cloud-thumbnail.jpg">

    <!-- Schema.org Structured Data (JSON-LD) -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Service",
            "serviceType": "Salesforce Education Cloud Implementation",
            "provider": {
                "@type": "Organization",
                "name": "SalesClouds",
                "url": "https://www.salesclouds.com",
                "logo": "https://www.salesclouds.com/images/salesclouds-logo.jpg"
            },
            "description": "SalesClouds offers Salesforce Education Cloud services for K-12 schools and higher education institutions. Enhance student engagement, manage recruitment, and support student success with AI-powered tools and seamless LMS integration.",
            "offers": {
                "@type": "Offer",
                "url": "https://www.salesclouds.com/services/salesforce-education-cloud",
                "priceCurrency": "USD",
                "price": "0",
                "eligibleRegion": "Worldwide",
                "availability": "InStock",
                "validFrom": "2024-09-20"
            }
        }
    </script>

    <!-- Favicon -->
    <link rel="icon" href="https://www.salesclouds.com/favicon.ico" type="image/x-icon">

    <!-- Preconnect for Speed Optimization -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://cdn.salesclouds.com">

    <!-- Alternate for Multilingual Websites (if applicable) -->
    <link rel="alternate" href="https://www.salesclouds.com/es/services/salesforce-education-cloud" hreflang="es">

    <!-- Sitemap Link -->
    <link rel="sitemap" type="application/xml" title="Sitemap" href="https://www.salesclouds.com/sitemap.xml">

    <!-- External CSS File -->
    <link rel="stylesheet" href="assests/css/theme.css">
    <link rel="stylesheet" href="assests/css/commonServicePage.css">
    <link rel="stylesheet" href="assests/css/navbar.css">

    <!-- AOS CSS CDN for scroll animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Font Awesome CDN for icons -->
    <script src="https://kit.fontawesome.com/cdf9a174a4.js" crossorigin="anonymous"></script>
</head>




<body>

    <?php include_once('navbar.php'); ?>
    <section class="service-wrapper ">
        <div class="hero">
            <h1>Salesforce Education Cloud</h1>

        </div>
        <section class="service-content-wrapper">
            <section class="service-content-image service" data-aos="fade-up-right" data-aos-duration="1500">
                <img src="images/secondary-choose.jpg" alt="">
            </section>
            <section class="service-content-data service " data-aos="fade-left" data-aos-duration="1500">

                <p><strong>Salesforce Education Cloud</strong> is a comprehensive platform designed to meet the unique needs of educational institutions, from K-12 schools to higher education universities. It helps institutions streamline operations, enhance student engagement, and provide a connected experience for students, faculty, and staff. By leveraging CRM, automation, and AI, Education Cloud enables educational organizations to build stronger relationships and support student success. Here are some key features of Salesforce Education Cloud:-</p>

                <ul>
                    <li> <strong>360-Degree Student View:</strong> Gain a comprehensive view of each student's academic journey, including records, engagement, and goals.</li>
                    <li> <strong> Student Recruitment and Admissions:</strong> Automate recruitment processes and manage admissions pipelines effectively. </li>
                    <li> <strong> Personalized Student Engagement:</strong> Deliver personalized communications and support to students based on their needs and preferences. </li>
                    <li> <strong> Alumni and Donor Management:</strong> Track alumni relationships and engage donors to build strong, long-term connections. </li>
                    <li> <strong> Faculty and Staff Collaboration:</strong> Improve collaboration among faculty and staff with tools for communication and data sharing. </li>
                    <li> <strong> K-12 School Management:</strong> Support K-12 schools with features for student tracking, enrollment management, and family engagement. </li>
                    <li> <strong> Student Success Tools:</strong> Provide support with academic advising, tutoring, and early intervention based on predictive analytics. </li>
                    <li> <strong> Integration with Learning Management Systems (LMS):</strong> Seamlessly integrate with LMS platforms to track academic progress and student participation. </li>
                    <li> <strong> Mobile Accessibility:</strong> Enable students, faculty, and staff to access important information and tools from any device. </li>
                    <li> <strong> AI-Powered Insights:</strong> Leverage AI and data analytics to identify trends and opportunities for improving student success and operational efficiency. </li>
                </ul>
            </section>


        </section>
        <div class="book" data-aos="zoom-in" data-aos-duration="1500">
            <a href="https://calendly.com/salesfocesclouds/30min" class="book">Book Your Free Consultation</a>

        </div>

        <!-- ####### blog #####  -->

        <div class="container" data-aos="zoom-in" data-aos-duration="1000">
            <h1>Exploring Industry Trends, Ideas, and Real-World Solutions</h1>

        </div>

        <div class="blog-wrapper" id="blog-wrapper" data-aos="fade-up" data-aos-duration="1000">
            <!-- Blog content will be injected dynamically -->
            <?php echo renderBlogs($contents); ?>
        </div>

        <!-- Pagination Links -->
        <div class="pagination" id="pagination">
            <?php echo renderPagination($currentPage, $totalPages); ?>
        </div>

    </section>

    <?php
    include('footer.php');
    ?>


    <script src=" https://unpkg.com/aos@2.3.1/dist/aos.js">
    </script>
    <script>
        AOS.init({
            once: true,
        });
    </script>

</body>

</html>