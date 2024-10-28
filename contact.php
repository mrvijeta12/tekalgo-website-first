
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Primary Meta Tags -->
    <meta charset="UTF-8">
    <title>Contact Us | Get in Touch | SalesClouds</title>
    <meta name="description" content="Connect with SalesClouds for any inquiries, support, or questions. Our team is ready to provide timely responses to all your Salesforce needs. Reach out to us at our office in Saket, New Delhi, or contact us via email or phone.">
    <meta name="keywords" content="Contact SalesClouds, Salesforce inquiries, Salesforce support, New Delhi office, Salesforce technical support, contact form, Salesforce service provider, reach SalesClouds">
    <meta name="author" content="SalesClouds">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://www.salesclouds.com/contact">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.salesclouds.com/contact">
    <meta property="og:title" content="Contact Us | Get in Touch | SalesClouds">
    <meta property="og:description" content="Have questions or need support? Contact SalesClouds today for all Salesforce-related inquiries. Reach out via phone, email, or our contact form, and our team will provide timely and helpful responses.">
    <meta property="og:image" content="https://www.salesclouds.com/images/contact-us-thumbnail.jpg">
    <meta property="og:locale" content="en_US">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="https://www.salesclouds.com/contact">
    <meta name="twitter:title" content="Contact Us | Get in Touch | SalesClouds">
    <meta name="twitter:description" content="Reach out to SalesClouds for Salesforce inquiries and support. Our dedicated team is here to assist with all your questions. Get in touch with us today!">
    <meta name="twitter:image" content="https://www.salesclouds.com/images/contact-us-thumbnail.jpg">

    <!-- Schema.org Structured Data (JSON-LD) -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "ContactPage",
            "name": "Contact SalesClouds",
            "description": "Contact SalesClouds for inquiries, support, or questions related to Salesforce services. Reach us via phone, email, or our contact form.",
            "url": "https://www.salesclouds.com/contact",
            "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "+91 9118618111",
                "email": "sales@tekalgo.com",
                "contactType": "Customer Service",
                "areaServed": "IN",
                "availableLanguage": "English"
            },
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "Saket",
                "addressLocality": "New Delhi",
                "addressCountry": "India"
            }
        }
    </script>

    <!-- Favicon -->
    <link rel="icon" href="https://www.salesclouds.com/favicon.ico" type="image/x-icon">

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
                        <img src="images/krakenimages-376KN_ISplE-unsplash.jpg" alt="">
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