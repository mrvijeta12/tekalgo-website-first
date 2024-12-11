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
    <link rel="stylesheet" href="assests/css/service.css">
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
                <h1>Comprehensive Salesforce Services Tailored for Your Business</h1>
                <h2>Unlock the Full Potential of Salesforce with Our Expertise</h2>
            </div>

            <!-- ########################## service animated counter ###################### -->
            <div class="serive_counter_wrapper" data-aos="zoom-in" data-aos-duration="1500">
                <div class="service_counter_child service_content ">
                    <h1>Innovative Services Designed to Elevate and Transform Your Business Success</h1>
                    <p>Our comprehensive range of services is crafted to meet your unique business needs. We combine innovation with expertise to deliver solutions that drive growth, enhance efficiency, and create lasting impact. Whether you’re looking to optimize processes or innovate new strategies, we’re here to help you achieve your goals.</p>
                </div>
                <div class="service_counter_child service_counter ">
                    <div class="counter_wrapper_service">
                        <div class="counter " data-target="150">
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
            </div>





            <!-- ######################################## OUR SERVICES ########################################  -->



            <div class="about_container">
                <h2 data-aos="zoom-in" data-aos-duration="1500">Salesforce Services</h2>
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

            <div class="service_choose_us">
                <h1 data-aos="zoom-in" data-aos-duration="1500">WHY CHOOSE US</h1>


                <div class="services_container">
                    <div class="services_child" data-aos="fade-up" data-aos-duration="1500">
                        <img src="images/s-app.gif" alt="">
                        <h1>Salesforce Application</h1>
                        <p>Comprehensive Salesforce services for custom CRM solutions and seamless implementation.</p>
                    </div>
                    <div class="services_child" data-aos="fade-up" data-aos-duration="1500">
                        <img src="images/s-customsation.gif" alt="">
                        <h1>Salesforce Customisation Services</h1>
                        <p>Customized Salesforce solutions to enhance CRM functionality and business processes.</p>
                    </div>
                    <div class="services_child" data-aos="fade-up" data-aos-duration="1500">
                        <img src="images/s-integration.gif" alt="">
                        <h1>Salesforce Integration Services</h1>
                        <p>Seamless Salesforce integration services to unify systems and boost productivity.</p>
                    </div>
                    <div class="services_child" data-aos="fade-up" data-aos-duration="1500">
                        <img src="images/s-analytic.gif" alt="">
                        <h1> Salesforce CRM Analytics Services</h1>
                        <p>Advanced Salesforce CRM analytics services for data-driven insights and growth.</p>
                    </div>
                    <div class="services_child" data-aos="fade-up" data-aos-duration="1500">
                        <img src="images/s-ai.gif" alt="">
                        <h1>Salesforce AI Solutions</h1>
                        <p>Salesforce AI solutions for smarter insights, automation, and business growth.</p>
                    </div>
                    <div class="services_child" data-aos="fade-up" data-aos-duration="1500">
                        <img src="images/s-data-cloud.gif" alt="">
                        <h1>Salesforce Data Cloud</h1>
                        <p>Advanced Salesforce Data Cloud services for secure, scalable data management solutions.</p>
                    </div>


                </div>

            </div>



            <!-- ############## testimonial ############# -->

            <section class="testimonial_wrapper">
                <h1 data-aos="zoom-in" data-aos-duration="1500">Testimonials</h1>
                <div class="testimonial_slider" data-aos="zoom-in" data-aos-duration="2500">
                    <div class="testimonial_item">
                        <img src="images/t1.jpg" alt="">
                        <p>TekAlgo’s Salesforce expertise boosted our sales efficiency and team productivity. Their tailored solutions made a significant difference. Highly recommended!</p>
                        <h5>John Doe</h5>
                        <p>CEO, Company</p>
                    </div>
                    <div class="testimonial_item testimonial_item2">
                        <img src="images/t4.jpg" alt="">
                        <p>TekAlgo transformed our CRM with seamless Salesforce integration. Exceptional service, knowledgeable team, and tangible results. We’re extremely satisfied! </p>
                        <h5>John Doe</h5>
                        <p>CEO, Company</p>
                    </div>
                    <div class="testimonial_item">
                        <img src="images/t10.jpg" alt="">
                        <p>TekAlgo’s Salesforce solutions enhanced our customer management. The team is responsive, professional, and delivered beyond our expectations. Outstanding experience! </p>
                        <h5>John Doe</h5>
                        <p>CEO, Company</p>
                    </div>
                </div>
            </section>


        </div>



    </div>

    <?php include('footer.php'); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
        });
    </script>


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