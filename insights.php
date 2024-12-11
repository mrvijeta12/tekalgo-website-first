<?php
// Capture the current page URL
$current_page_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// Include your database connection file
include 'db.php';

try {
    // Fetch SEO data from the database for the current page
    $query = "SELECT * FROM public_pages_seo_setup WHERE page_url = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $current_page_url);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetched SEO data
    $seo_data = $result->fetch_assoc();

    // Default meta values
    $defaults = [
        'page_title' => 'Default Page Title',
        'meta_description' => 'Default description of the page for SEO.',
        'meta_keywords' => 'default, keywords, seo',
        'meta_robots' => 'index, follow',
        'canonical_url' => $current_page_url,
        'og_title' => 'Default Open Graph Title',
        'og_description' => 'Default Open Graph description.',
        'og_image' => 'default-og-image.jpg',
        'og_url' => $current_page_url,
        'og_type' => 'website',
        'og_site_name' => 'Default Site Name',
        'og_locale' => 'en_US',
        'twitter_card' => 'summary',
        'twitter_site' => '@defaultsite',
        'twitter_creator' => '@defaultcreator',
        'meta_author' => 'Default Author',
        'meta_viewport' => 'width=device-width, initial-scale=1',
        'meta_theme_color' => '#ffffff',
        'meta_charset' => 'UTF-8',
        'schema_markup' => '',
    ];

    // Merge the fetched data with the defaults
    $meta = array_merge($defaults, $seo_data ?: []);
} catch (Exception $e) {
    // Handle errors and fallback to defaults
    $meta = $defaults;
}

// ======= blog =====

// Fetch all published blog posts with slug, summary, and feature image
$sql = "SELECT id, slug, meta_title, author, summary, social_sharing_image,blog_date FROM main_website_blog WHERE blog_status = 'published' ORDER BY id DESC";

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
    $contents[] = ["id" => 0, "slug" => "No content found.", "summary" => "", "social_sharing_image" => "default-image.png", "blog_date" => "", "author" => ""];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($meta['og_locale']); ?>">

<head>
    <!-- Primary Meta Tags -->
    <meta charset="<?= htmlspecialchars($meta['meta_charset']); ?>">
    <meta name="viewport" content="<?= htmlspecialchars($meta['meta_viewport']); ?>">
    <title><?= htmlspecialchars($meta['page_title']); ?></title>
    <meta name="robots" content="<?= htmlspecialchars($meta['meta_robots']); ?>">
    <meta name="description" content="<?= htmlspecialchars($meta['meta_description']); ?>">
    <meta name="keywords" content="<?= htmlspecialchars($meta['meta_keywords']); ?>">
    <meta name="author" content="<?= htmlspecialchars($meta['meta_author']); ?>">
    <meta name="googlebot" content="<?= htmlspecialchars($meta['meta_robots']); ?>">
    <meta name="theme-color" content="<?= htmlspecialchars($meta['meta_theme_color']); ?>">

    <!-- Canonical URL -->
    <link rel="canonical" href="<?= htmlspecialchars($meta['canonical_url']); ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="<?= htmlspecialchars($meta['og_title']); ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta['og_description']); ?>">
    <meta property="og:image" content="<?= htmlspecialchars($meta['og_image']); ?>">
    <meta property="og:url" content="<?= htmlspecialchars($meta['og_url']); ?>">
    <meta property="og:type" content="<?= htmlspecialchars($meta['og_type']); ?>">
    <meta property="og:locale" content="<?= htmlspecialchars($meta['og_locale']); ?>">

    <!-- Twitter -->
    <meta name="twitter:card" content="<?= htmlspecialchars($meta['twitter_card']); ?>">
    <meta name="twitter:site" content="<?= htmlspecialchars($meta['twitter_site']); ?>">
    <meta name="twitter:creator" content="<?= htmlspecialchars($meta['twitter_creator']); ?>">

    <meta name="twitter:url" content="<?= htmlspecialchars($meta['og_url']); ?>">
    <meta name="twitter:title" content="<?= htmlspecialchars($meta['og_title']); ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($meta['og_description']); ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($meta['og_image']); ?>">

    <!-- Schema.org Structured Data (JSON-LD) -->


    <?php if (!empty($meta['schema_markup'])): ?>
        <script type="application/ld+json">
            <?= $meta['schema_markup']; ?>
        </script>
    <?php endif; ?>

    <!-- Favicon -->
    <link rel="icon" href="images/fevicon.png" type="image/x-icon">


    <!-- Preconnect for Speed Optimization -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://cdn.salesclouds.com">

    <!-- Alternate for Multilingual Websites (if applicable) -->
    <link rel="alternate" href="https://www.salesclouds.com/es" hreflang="es">

    <!-- Sitemap Link -->
    <link rel="sitemap" type="application/xml" title="Sitemap" href="https://www.salesclouds.com/sitemap.xml">


    <!-- === css links ======  -->
    <link rel="stylesheet" href="assests/css/insights.css">
    <link rel="stylesheet" href="assests/css/theme.css">
    <link rel="stylesheet" href="assests/css/navbar.css">

    <!-- ===== swiper ======  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- ======== aos ======  -->
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

            <!-- Wrap only the latest 4 blogs in a "latest-blog" div -->
            <div class="latest-blog">


                <div class="first-blog">
                    <?php
                    $counter = 0; // Initialize a counter
                    foreach ($contents as $row):
                        if ($counter >= 1) break; // Stop the loop after 4 iterations
                        $slug = htmlspecialchars($row['slug']);
                        $meta_title = htmlspecialchars($row['meta_title']);
                        $author = htmlspecialchars($row['author']);

                        $blog_date = date('F j, Y', strtotime($row['blog_date']));


                        $summary = htmlspecialchars($row['summary']);
                        $id = $row['id'];
                        $featureImage = !empty($row['social_sharing_image']) ? 'admin/' . htmlspecialchars($row['social_sharing_image']) : 'default-image.png';
                    ?>
                        <a href="insight/<?= $slug ?>" class='content-container' data-aos="zoom-in" data-aos-duration="1500">
                            <!-- Image Container -->
                            <div class='image-container'>
                                <img src='<?= $featureImage ?>' alt='Feature Image'>
                            </div>

                            <!-- Text Content -->
                            <div class='text-content'>
                                <h2 class="title"><?= $meta_title ?></h2>
                                <h3 class="date">
                                    <span class="blog-date"><?= $blog_date ?></span>
                                </h3>



                            </div>
                        </a>
                    <?php
                        $counter++; // Increment the counter
                    endforeach;
                    ?>
                </div>

                <div class="other-latest">
                    <div class="second-blog">
                        <?php
                        $counter = 0; // Initialize a counter
                        foreach ($contents as $row):
                            $counter++; // Increment the counter at the start of the loop
                            if ($counter != 2) continue; // Skip blogs until the second one

                            // Fetch blog details
                            $slug = htmlspecialchars($row['slug']);
                            $meta_title = htmlspecialchars($row['meta_title']);
                            $summary = htmlspecialchars($row['summary']);
                            $id = $row['id'];
                            $featureImage = !empty($row['social_sharing_image']) ? 'admin/' . htmlspecialchars($row['social_sharing_image']) : 'default-image.png';
                        ?>
                            <a href="insight/<?= $slug ?>" class='content-container' data-aos="zoom-in" data-aos-duration="1500">
                                <!-- Image Container -->
                                <div class='image-container'>
                                    <img src='<?= $featureImage ?>' alt='Feature Image'>
                                </div>

                                <!-- Text Content -->
                                <div class='text-content'>
                                    <h2 class="title"><?= $meta_title ?></h2>
                                </div>
                            </a>
                        <?php
                            break; // Exit the loop after fetching the second blog
                        endforeach;
                        ?>
                    </div>

                    <div class="third-fourth">
                        <div class="third-blog">
                            <?php
                            $counter = 0; // Initialize a counter
                            foreach ($contents as $row):
                                $counter++; // Increment the counter at the start of the loop
                                if ($counter != 3) continue; // Skip blogs until the second one

                                // Fetch blog details
                                $slug = htmlspecialchars($row['slug']);
                                $meta_title = htmlspecialchars($row['meta_title']);
                                $summary = htmlspecialchars($row['summary']);
                                $id = $row['id'];
                                $featureImage = !empty($row['social_sharing_image']) ? 'admin/' . htmlspecialchars($row['social_sharing_image']) : 'default-image.png';
                            ?>
                                <a href="insight/<?= $slug ?>" class='content-container' data-aos="zoom-in" data-aos-duration="1500">
                                    <!-- Image Container -->
                                    <div class='image-container'>
                                        <img src='<?= $featureImage ?>' alt='Feature Image'>
                                    </div>

                                    <!-- Text Content -->
                                    <div class='text-content'>
                                        <h2 class="title"><?= $meta_title ?></h2>
                                    </div>
                                </a>
                            <?php
                                break; // Exit the loop after fetching the second blog
                            endforeach;
                            ?>
                        </div>
                        <div class="fourth-blog">
                            <?php
                            $counter = 0; // Initialize a counter
                            foreach ($contents as $row):
                                $counter++; // Increment the counter at the start of the loop
                                if ($counter != 4) continue; // Skip blogs until the second one

                                // Fetch blog details
                                $slug = htmlspecialchars($row['slug']);
                                $meta_title = htmlspecialchars($row['meta_title']);
                                $summary = htmlspecialchars($row['summary']);
                                $id = $row['id'];
                                $featureImage = !empty($row['social_sharing_image']) ? 'admin/' . htmlspecialchars($row['social_sharing_image']) : 'default-image.png';
                            ?>
                                <a href="insight/<?= $slug ?>" class='content-container' data-aos="zoom-in" data-aos-duration="1500">
                                    <!-- Image Container -->
                                    <div class='image-container'>
                                        <img src='<?= $featureImage ?>' alt='Feature Image'>
                                    </div>

                                    <!-- Text Content -->
                                    <div class='text-content'>
                                        <h2 class="title"><?= $meta_title ?></h2>
                                    </div>
                                </a>
                            <?php
                                break; // Exit the loop after fetching the second blog
                            endforeach;
                            ?>
                        </div>

                    </div>

                </div>


            </div>

            <div class="remaining-blog">

                <?php
                $counter = 0; // Initialize a counter
                foreach ($contents as $row):
                    if ($counter < 4) {
                        $counter++;
                        continue;
                    }

                    $slug = htmlspecialchars($row['slug']);
                    $meta_title = htmlspecialchars($row['meta_title']);
                    $blog_date = date('F j, Y', strtotime($row['blog_date']));

                    $summary = htmlspecialchars($row['summary']);
                    $id = $row['id'];
                    $featureImage = !empty($row['social_sharing_image']) ? 'admin/' . htmlspecialchars($row['social_sharing_image']) : 'default-image.png';
                ?>
                    <a href="insight/<?= $slug ?>" class='content-container' data-aos="zoom-in" data-aos-duration="1500">
                        <!-- Image Container -->
                        <div class='image-container'>
                            <img src='<?= $featureImage ?>' alt='Feature Image'>
                        </div>

                        <!-- Text Content -->
                        <div class='text-content'>
                            <h2 class="title"><?= $meta_title ?></h2>
                            <p class="blog-date"><?= $blog_date ?></p>



                        </div>
                    </a>
                <?php
                    $counter++; // Increment the counter
                endforeach;
                ?>
            </div>

        </div>

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