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

    <!-- Sitemap Link -->
    <link rel="sitemap" type="application/xml" title="Sitemap" href="https://www.salesclouds.com/sitemap.xml">

    <!-- External CSS File -->
    <link rel="stylesheet" href="assests/css/success.css">
    <link rel="stylesheet" href="assests/css/theme.css">
    <link rel="stylesheet" href="assests/css/navbar.css">

    <!-- Swiper CSS CDN for carousel/slider functionality -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- AOS CSS CDN for scroll animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Font Awesome CDN for icons -->
    <script src="https://kit.fontawesome.com/cdf9a174a4.js" crossorigin="anonymous"></script>
</head>


<body>
    <div>
        <?php include('navbar.php'); ?>
        <div class="wrapper" data-aos="fade-right" data-aos-duration="1500">

            <!-- ################################# HERO SECTION ##################################  -->
            <div class="success_hero">
                <h1>Turning Vision into Reality</h1>
                <h2>Discover how we’ve turned challenges into opportunities and dreams into success stories</h2>
            </div>

            <!-- ######################################## success projects ########################################  -->

            <div class="service_choose_us">
                <!-- <h5>WHY CHOOSE US</h5> -->
                <h2 data-aos="zoom-in" data-aos-duration="1500">Our Successful Projects</h2>

                <div class="services_container">
                    <div class="services_child" data-aos="fade-up" data-aos-duration="1500">
                        <img src="images/thisisengineering-Bg0Geue-cY8-unsplash.jpg" alt="">
                        <h1>Global CRM Implementation</h1>
                        <p>

                            Successfully deployed Salesforce CRM across multiple international offices.</p>
                    </div>
                    <div class="services_child" data-aos="fade-up" data-aos-duration="1500">
                        <img src="images/thisisengineering-nwifBnhRcP8-unsplash.jpg" alt="">
                        <h1>Salesforce Lightning Migration</h1>
                        <p>Upgraded from Classic to Lightning, enhancing user experience.</p>
                    </div>
                    <div class="services_child" data-aos="fade-up" data-aos-duration="1500">
                        <img src="images/rubaitul-azad-FPK6K5OUFVA-unsplash.jpg" alt="">
                        <h1>Custom API Integration</h1>
                        <p>Integrated third-party applications with Salesforce for seamless operations.</p>
                    </div>
                    <div class="services_child" data-aos="fade-up" data-aos-duration="1500">
                        <img src="images/jakub-zerdzicki-p2zR1G1ry20-unsplash.jpg" alt="">
                        <h1>Automated Workflow Solutions</h1>
                        <p>Developed custom workflows to automate business processes efficiently.</p>
                    </div>
                    <div class="services_child" data-aos="fade-up" data-aos-duration="1500">
                        <img src="images/marvin-meyer-SYTO3xs06fU-unsplash.jpg" alt="">
                        <h1>Salesforce Community Portal</h1>
                        <p>Built a customer portal to enhance self-service and engagement.</p>
                    </div>
                    <div class="services_child" data-aos="fade-up" data-aos-duration="1500">
                        <img src="images/thisisengineering-sCgQPQZAeO4-unsplash.jpg" alt="">
                        <h1>Data Cleanup and Optimization</h1>
                        <p>Executed data cleansing and optimization for better reporting and accuracy.</p>
                    </div>


                </div>

            </div>


            <!-- ########################################## WHY CHOOSE US CONTENT ######################################### -->

            <div class="choose_container">
                <div class="choose_content check">
                    <div class="choose_image" data-aos="fade-up-right" data-aos-duration="1500">
                        <img src="images/studio-republic-fotKKqWNMQ4-unsplash.jpg" alt="choose us">
                    </div>

                    <div class="choose_data check" data-aos="zoom-in" data-aos-duration="1500">
                        <h1>Custom Partner Portal Development</h1>
                        <p>We developed a custom Salesforce Partner Portal for a manufacturing client, enabling seamless collaboration with distributors and resellers. The portal provided real-time access to sales data, order tracking, and marketing resources. This solution enhanced partner engagement, streamlined communication, and increased sales by 25% within the first quarter of implementation.</p>
                    </div>
                </div>

                <div class="choose_content content_2">

                    <div class="choose_data" data-aos="zoom-in" data-aos-duration="1500">
                        <h1>Salesforce Einstein Analytics Integration</h1>
                        <p>We integrated Salesforce Einstein Analytics to empower a client with advanced data insights and predictive analytics. The solution provided a comprehensive view of key performance metrics, enabling data-driven decision-making. With customized dashboards and AI-driven insights, the client achieved a 30% improvement in sales forecasting accuracy and strategic planning.</p>
                    </div>
                    <div class="choose_image" data-aos="fade-up-left" data-aos-duration="1500">
                        <img src="images/jakub-zerdzicki-LNnmSumlwO4-unsplash.jpg" alt="choose us">
                    </div>
                </div>

                <div class="choose_content">
                    <div class="choose_image" data-aos="fade-up-right" data-aos-duration="1500">
                        <img src="images/firmbee-com-gcsNOsPEXfs-unsplash.jpg" alt="choose us">
                    </div>

                    <div class="choose_data" data-aos="zoom-in" data-aos-duration="1500">
                        <h1>Salesforce CPQ Implementation</h1>
                        <p>We successfully implemented Salesforce CPQ (Configure, Price, Quote) to streamline the quoting process for a client. By automating product configurations and pricing, we reduced quote generation time by 50% and improved accuracy. The solution also provided real-time insights, enabling the sales team to close deals faster and with greater confidence.</p>
                    </div>
                </div>
            </div>


            <!-- ##################################### animated Counter #########################  -->







        </div>

        <?php include('footer.php'); ?>
    </div>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script src="swiper.js"></script>

</body>

</html>