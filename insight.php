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

// Get the slug from the URL
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

// Prepare and execute the query
$sql = "SELECT id, meta_title, author,blog_date, summary, content, social_sharing_image FROM main_website_blog WHERE slug = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();

$blog = null;
if ($result->num_rows > 0) {
    $blog = $result->fetch_assoc();
    $blog['summary'] = html_entity_decode($blog['summary']);
} else {
    echo "No content found.";
    exit;
}

$stmt->close();
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
    <link rel="icon" href="../images/fevicon.png" type="image/x-icon">


    <!-- Preconnect for Speed Optimization -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://cdn.salesclouds.com">

    <!-- Alternate for Multilingual Websites (if applicable) -->
    <link rel="alternate" href="https://www.salesclouds.com/es" hreflang="es">

    <!-- Sitemap Link -->
    <link rel="sitemap" type="application/xml" title="Sitemap" href="https://www.salesclouds.com/sitemap.xml">



    <!-- ======== External CSS File =====  -->
    <link rel="stylesheet" href="../assests/css/insight.css">
    <link rel="stylesheet" href="../assests/css/navbar.css" />
    <link rel="stylesheet" href="../assests/css/theme.css" />
    <link rel="stylesheet" href="../assests/css/footer.css" />

    <!-- AOS CSS CDN for scroll animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- AOS CSS CDN for scroll animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Font Awesome CDN for icons -->
    <script src="https://kit.fontawesome.com/cdf9a174a4.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Navigation Bar -->
    <?php
    $base_url = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/';
    include "navbar.php"; ?>

    <div class="wrapper">
        <div class="image-container">
            <?php
            // Fetch the image from the database, check if it's available
            $featureImage = !empty($blog['social_sharing_image'])
                ? $base_url . 'admin/' . htmlspecialchars(ltrim($blog['social_sharing_image'], '/'))
                : 'default-image.png';

            ?>
            <img src='<?php echo $featureImage; ?>' alt='Feature Image'>
            <div class="title-wrapper">
                <h1 class="title"><?php echo htmlspecialchars($blog['meta_title']); ?></h1>
                <h3 class="date"><i class="fa-solid fa-calendar-days"></i><?php echo htmlspecialchars($blog['blog_date']); ?></h3>
                <h3 class="author"><i class="fa-solid fa-pencil"></i><?php echo htmlspecialchars($blog['author']); ?></h3>



            </div>
        </div>

        <div class="container">
            <div class="share-options" data-aos="zoom-in" data-aos-duration="1000">
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode("https://salesforceclouds.com/insights/" . $slug); ?>&text=<?php echo urlencode($blog['meta_title']); ?>" target="_blank"><i class="fa-brands fa-square-x-twitter"></i></a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode("https://salesforceclouds.com/insights/" . $slug); ?>&title=<?php echo urlencode($blog['meta_title']); ?>" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
                <a href="https://api.whatsapp.com/send?text=<?php echo urlencode("Check out this blog post: " . "https://salesforceclouds.com/insights/" . $slug); ?>" target="_blank"><i class="fa-brands fa-square-whatsapp"></i></a>
            </div>

            <!-- Text Content -->
            <div class="text-content">
                <p><?php echo $blog['summary']; ?></p>
                <?php
                // Fetch the image from the database, check if it's available
                $featureImage = !empty($blog['social_sharing_image'])
                    ? $base_url . 'admin/' . htmlspecialchars(ltrim($blog['social_sharing_image'], '/'))
                    : 'default-image.png';

                $blogContent = $blog['content'];

                // Using regex to find all image tags and update their src attribute
                $blogContent = preg_replace_callback('/<img[^>]+src="([^"]+)"/', function ($matches) use ($base_url) {
                    $imageUrl = $matches[1]; // Extract the current `src` value

                    // Check if the image path doesn't already start with the base path
                    if (strpos($imageUrl, $base_url . 'admin/') !== 0) {
                        // Prepend the base URL and /admin/ to the image path
                        $imageUrl = $base_url . 'admin/' . ltrim($imageUrl, '/');
                    }

                    // Replace the original `src` with the updated URL
                    return str_replace($matches[1], htmlspecialchars($imageUrl), $matches[0]);
                }, $blogContent);
                ?>

                <div><?php echo $blogContent; ?></div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include "footer.php"; ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
        });
    </script>
    <script src="swiper.js"></script>
</body>

</html>