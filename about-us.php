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

    <!-- Alternate for Multilingual Websites (if applicable) -->
    <link rel="alternate" href="https://www.salesclouds.com/es/about-us" hreflang="es">

    <!-- Sitemap Link -->
    <link rel="sitemap" type="application/xml" title="Sitemap" href="https://www.salesclouds.com/sitemap.xml">

    <!-- External CSS File -->
    <link rel="stylesheet" href="assests/css/about.css">
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
            <div class="about">
                <h1>Who We Are</h1>
                <h2>A Dedicated Team Committed to Your Success</h2>
            </div>

            <!-- ########################## our mission ###################### -->

            <div class=" about_choose_container">
                <div class="about_choose_content ">
                    <div class="about_choose_image" data-aos="fade-up-right" data-aos-duration="1500">
                        <img src="images/our-mission.jpg" alt="choose us">
                    </div>

                    <div class="about_choose_data" data-aos="zoom-in" data-aos-duration="1500">
                        <h1>Our Mission</h1>
                        <p>Our mission is to empower businesses through innovative solutions, driving growth and success with integrity, commitment, and excellence. We strive to create value for our clients, employees, and communities, focusing on delivering exceptional service, fostering a collaborative culture, and continually evolving to meet the challenges of tomorrow.</p>
                    </div>
                </div>


            </div>

            <!-- ######################################## OUR SERVICES ########################################  -->



            <div class="about_container" data-aos="zoom-in" data-aos-duration="1500">
                <h2>Our Team</h2>
                <div class="circle-container">
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="circle"></div>
                </div>
            </div>

            <!-- ########################################## swipper #################################  -->

            <!-- <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="swiper-slide-image">
                            <img src="images/t10.jpg" alt="">

                        </div>
                        <p>Tony</p>
                        <p>Salesforce Developer</p>
                    </div>
                    <div class="swiper-slide">
                        <div class="swiper-slide-image">
                            <img src="images/t8.jpg" alt="">

                        </div>
                        <p>Tony</p>
                        <p>Salesforce Developer</p>
                    </div>
                    <div class="swiper-slide">
                        <div class="swiper-slide-image">
                            <img src="images/t1.jpg" alt="">

                        </div>
                        <p>Tony</p>
                        <p>Salesforce Developer</p>
                    </div>
                    <div class="swiper-slide">
                        <div class="swiper-slide-image">
                            <img src="images/t5.jpg" alt="">

                        </div>
                        <p>Tony</p>
                        <p>Salesforce Developer</p>
                    </div>
                    <div class="swiper-slide">
                        <div class="swiper-slide-image">
                            <img src="images/t9.jpg" alt="">

                        </div>
                        <p>Tony</p>
                        <p>Salesforce Developer</p>
                    </div>
                    <div class="swiper-slide">
                        <div class="swiper-slide-image">
                            <img src="images/t4.jpg" alt="">

                        </div>
                        <p>Tony</p>
                        <p>Salesforce Developer</p>
                    </div>
                    <div class="swiper-slide">
                        <div class="swiper-slide-image">
                            <img src="images/t3.jpg" alt="">

                        </div>
                        <p>Tony</p>
                        <p>Salesforce Developer</p>
                    </div>
                    <div class="swiper-slide">
                        <div class="swiper-slide-image">
                            <img src="images/t6.jpg" alt="">

                        </div>
                        <p>Tony</p>
                        <p>Salesforce Developer</p>
                    </div>









                </div>
                <div class="swiper-pagination"></div>
            </div> -->

            <div class="swiper mySwiper">

                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="swiper-slide-image">
                            <img src="./images/t1.jpg" alt="">

                        </div>
                        <div class="swiper-slide-data">
                            <h2>Tony</h2>
                            <p>Salesforce Developer</p>


                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="swiper-slide-image">
                            <img src="./images/t10.jpg" alt="">

                        </div>
                        <div class="swiper-slide-data">
                            <h2>Tony</h2>
                            <p>Salesforce Developer</p>


                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="swiper-slide-image">
                            <img src="./images/t8.jpg" alt="">

                        </div>
                        <div class="swiper-slide-data">
                            <h2>Tony</h2>
                            <p>Salesforce Developer</p>

                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="swiper-slide-image">
                            <img src="./images/t4.jpg" alt="">

                        </div>
                        <div class="swiper-slide-data">
                            <h2>Tony</h2>
                            <p>Salesforce Developer</p>

                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="swiper-slide-image">
                            <img src="./images/t9.jpg" alt="">

                        </div>
                        <div class="swiper-slide-data">
                            <h2>Tony</h2>
                            <p>Salesforce Developer</p>

                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="swiper-slide-image">
                            <img src="./images/t6.jpg" alt="">

                        </div>
                        <div class="swiper-slide-data">
                            <h2>Tony</h2>
                            <p>Salesforce Developer</p>

                        </div>
                    </div>

                </div>
                <div class="swiper-pagination"></div>
            </div>


            <!-- ############################################# WHY CHOOSE US IMAGE ######################################  -->

            <div class="hero choose_us" style="margin-bottom: 0px;" data-aos="flip-down" data-aos-duration="2000">
                <h1>Why Salesforce??</h1>
            </div>

            <!-- ########################################## WHY CHOOSE US CONTENT ######################################### -->

            <div class=" about_choose_container about_choose_bottom_container">
                <div class="about_choose_content about_choose_bottom_content ">


                    <div class="about_choose_data about_choose_bottom_data " data-aos="zoom-in" data-aos-duration="1500">
                        <h1>Expert Team</h1>
                        <p>Our team is made up of highly skilled professionals with years of experience in the industry, ensuring top-notch service and support.</p>
                        <h1>Quality Assurance</h1>
                        <p>We are committed to delivering high-quality products and services that exceed your expectations every time.</p>
                        <h1>Customer Satisfaction</h1>
                        <p>Your satisfaction is our priority. We work closely with you to understand your needs and provide personalized solutions.</p>
                    </div>
                    <div class="about_choose_image about_choose_bottom_image" data-aos="fade-up-left" data-aos-duration="1500">
                        <img src="images/about-choose.jpg" alt="choose us">
                    </div>
                </div>
            </div>
        </div>



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
    <script>
        // ################ swipper ###############

        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 3, // Default number of slides for larger screens
            spaceBetween: 20,
            autoplay: {
                delay: 2500,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                // When the screen is <= 768px
                1000: {
                    slidesPerView: 4, // Show 2 slides for screens smaller than or equal to 768px
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3, // Show 2 slides for screens smaller than or equal to 768px
                    spaceBetween: 20,
                },
                500: {
                    slidesPerView: 2, // Show 2 slides for screens smaller than or equal to 768px
                    spaceBetween: 20,
                },

                // When the screen is <= 480px
                0: {
                    slidesPerView: 1, // Show 1 slide for screens smaller than or equal to 480px
                    spaceBetween: 20,
                },
            },
        });
    </script>

</body>

</html>