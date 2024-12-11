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
    <link rel="stylesheet" href="assests/css/contact.css">
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
            <div class="about">
                <h1>Get in Touch</h1>
                <h2>Let’s connect. We’re just a message away</h2>
            </div>

            <div class="contact_wrapper">
                <div class="contact_child">
                    <div class="services_container">
                        <div class="services_child" data-aos="zoom-in" data-aos-duration="1500">
                            <img src="images/homegif.gif" alt="">
                            <h3>OUR MAIN OFFICE</h3>
                            <p>Saket, New Delhi, India</p>
                        </div>
                        <div class="services_child" data-aos="zoom-in" data-aos-duration="1500">
                            <img src="images/email.gif" alt="">
                            <h3>EMAIL</h3>
                            <p>sales@tekalgo.com</p>
                        </div>
                        <div class="services_child" data-aos="zoom-in" data-aos-duration="1500">
                            <img src="images/call.gif" alt="">
                            <h3>PHONE NUMBER</h3>
                            <p>+91 9118618111</p>
                        </div>
                    </div>
                </div>

                <div class="contact_data">
                    <div class="contact_data_item" data-aos="zoom-in" data-aos-duration="1500">
                        <h1>Connect with Us: We’re here to answer your questions, provide support, and assist with all your inquiries and needs.</h1>
                        <p>Reach out to us for any questions, support, or inquiries you may have. Our dedicated team is here to provide timely and helpful responses, ensuring you receive the assistance you need. Whether you’re seeking information or need technical support, we’re committed to making your experience seamless and efficient.</p>
                        <!-- <img src="images/krakenimages-376KN_ISplE-unsplash.jpg" alt=""> -->
                    </div>
                    <div class="contact_data_item" data-aos="fade-up-left" data-aos-duration="1500">
                        <div>
                            <form id="contactForm" method="post">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" placeholder="Enter Your Name" required>

                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" placeholder="Enter Your Email" required>

                                <label for="message">Message:</label>
                                <textarea name="message" id="message" placeholder="Enter Your Message"></textarea>

                                <input type="submit" value="Submit" name="submit">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <?php include('footer.php'); ?>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="swiper.js"></script>


    <?php include('sendMail.php'); ?>








</body>

</html>