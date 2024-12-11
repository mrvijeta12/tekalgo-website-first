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
    <link rel="alternate" href="https://www.salesclouds.com/es" hreflang="es">

    <!-- Sitemap Link -->
    <link rel="sitemap" type="application/xml" title="Sitemap" href="https://www.salesclouds.com/sitemap.xml">
    <!-- External CSS File -->
    <link rel="stylesheet" href="assests/css/home.css">
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
        <?php
        include('navbar.php');
        ?>
        <div class="wrapper" data-aos="fade-right" data-aos-duration="1500">

            <!-- ################################# HERO SECTION ##################################  -->
            <div class="hero">
                <h1>Transform Your Business with Expert Salesforce Solutions</h1>
                <h2>Empowered by a Team of Industry Leaders from Top MNCs</h2>
            </div>

            <!-- ######################################## OUR SERVICES ########################################  -->



            <div class="container" data-aos="zoom-in" data-aos-duration="1500">
                <h2>What We Offer</h2>
                <div class="circle-container">
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="circle"></div>
                </div>
            </div>

            <!-- ########################################## swipper #################################  -->




            <div class="swiper mySwiper">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <a href="salesforce-sales-cloud.php">
                            <div class="swiper-slide-image">
                                <img src="images/3.jpg" alt="">
                            </div>
                            <p>Salesforce Sales Cloud</p>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a href="salesforce-service-cloud.php">
                            <div class="swiper-slide-image">
                                <img src="images/10.jpg" alt="">
                            </div>
                            <p>Salesforce Service Cloud</p>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a href="salesforce-marketing-cloud.php">
                            <div class="swiper-slide-image">
                                <img src="images/marketing.jpg" alt="">
                            </div>
                            <p>Salesforce Marketing Cloud</p>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a href="salesforce-commerce-cloud.php">
                            <div class="swiper-slide-image">
                                <img src="images/commerce.jpg" alt="">
                            </div>
                            <p>Salesforce Commerce Cloud</p>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a href="salesforce-experience-cloud.php">
                            <div class="swiper-slide-image">
                                <img src="images/9.jpg" alt="">
                            </div>
                            <p>Salesforce Experience Cloud</p>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a href="salesforce-financial-cloud.php">
                            <div class="swiper-slide-image">
                                <img src="images/7.jpg" alt="">
                            </div>
                            <p>Salesforce Financial Cloud</p>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a href="salesforce-community-cloud.php">
                            <div class="swiper-slide-image">
                                <img src="images/community-cloud.jpg" alt="">
                            </div>
                            <p>Salesforce Community Cloud</p>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a href="salesforce-healthcare-cloud.php">
                            <div class="swiper-slide-image">
                                <img src="images/healthcare.jpg" alt="">
                            </div>
                            <p>Salesforce Healthcare Cloud</p>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a href="salesforce-education-cloud.php">
                            <div class="swiper-slide-image">
                                <img src="images/education.jpg" alt="">
                            </div>
                            <p>Salesforce Education Cloud</p>
                        </a>
                    </div>

                    <div class="swiper-slide">
                        <a href="salesforce-public-cloud.php">
                            <div class="swiper-slide-image">
                                <img src="images/public.jpg" alt="">
                            </div>
                            <p>Salesforce Public Cloud</p>
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="salesforce-analytic-cloud.php">
                            <div class="swiper-slide-image">
                                <img src="images/anlaytic-service.jpg" alt="">
                            </div>
                            <p>Salesforce Analytic Cloud</p>
                        </a>
                    </div>

                </div>
                <div class="swiper-pagination"></div>
            </div>



            <!-- ############################################# WHY CHOOSE US IMAGE ######################################  -->

            <div class=" hero choose_us" data-aos="flip-down" data-aos-duration="2000">

                <h1>Why Choose Us ??</h1>
            </div>

            <!-- ########################################## WHY CHOOSE US CONTENT ######################################### -->

            <div class="choose_container">
                <div class="choose_content">
                    <div class="choose_image" data-aos="fade-up-right" data-aos-duration="1500">
                        <img src="images/experience-team.jpg" alt="choose us">
                    </div>

                    <div class="choose_data" data-aos="zoom-in" data-aos-duration="1500">
                        <h1>Experienced Teams</h1>
                        <p>Our team brings a wealth of experience in Salesforce development, with over two years of hands-on expertise in crafting customized solutions that drive business success. We excel in optimizing CRM platforms, implementing seamless integrations, and delivering user-friendly interfaces. Our commitment to innovation and client satisfaction ensures that we consistently exceed expectations, helping businesses achieve their goals efficiently and effectively.</p>
                    </div>
                </div>

                <div class="choose_content content_2">

                    <div class="choose_data" data-aos="zoom-in" data-aos-duration="1500">
                        <h1>Customized Solutions</h1>
                        <p>Our team specializes in delivering customized solutions tailored to meet your unique business needs. With over two years of experience in Salesforce development, we excel in creating efficient, user-friendly, and scalable systems. We focus on optimizing your CRM to enhance productivity and drive growth, ensuring that our solutions align perfectly with your objectives and deliver measurable results.</p>
                    </div>
                    <div class="choose_image" data-aos="fade-up-left" data-aos-duration="1500">
                        <img src="images/customize.jpg" alt="choose us">
                    </div>
                </div>

                <div class="choose_content">
                    <div class="choose_image" data-aos="fade-up-right" data-aos-duration="1500">
                        <img src="images/result.jpg" alt="choose us">
                    </div>

                    <div class="choose_data" data-aos="zoom-in" data-aos-duration="1500">
                        <h1>Proven Results</h1>
                        <p>Our team is dedicated to delivering proven results, backed by over two years of experience in Salesforce development. We have a track record of implementing solutions that significantly enhance business processes and drive measurable success. By optimizing CRM systems and ensuring seamless integrations, we help businesses achieve their goals efficiently, consistently delivering outcomes that exceed expectations.</p>
                    </div>
                </div>
            </div>


            <!-- ##################################### animated Counter #########################  -->

            <div class="counter_wrapper" data-aos="flip-up" data-aos-duration="2000">
                <div class="counter" data-target="150">
                    <span class="count">0</span>+
                    <div>
                        <span id="counter-text">Projects Completed</span>
                    </div>
                </div>
                <div class="counter" data-target="250">
                    <span class="count">0</span>+
                    <div>
                        <span id="counter-text">Happy Clients</span>
                    </div>
                </div>
                <div class="counter" data-target="300">
                    <span class="count">0</span>+

                    <div>
                        <span id="counter-text">Members</span>
                    </div>
                </div>
            </div>






        </div>

        <?php
        include('footer.php');
        ?>
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
        // ##### swipper #####

        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 3,
            spaceBetween: 20,
            autoplay: {
                delay: 2500,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {

                768: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                593: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },


                0: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
            },
        });
    </script>

</body>

</html>