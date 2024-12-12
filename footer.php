<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assests/css/footer.css">
    <link rel="stylesheet" href="assests/css/footer.css">

    <title>Document</title>

</head>

<body>

    <?php

    // Automatically detect the base URL
    $base_url = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/';


    $current_page = basename($_SERVER['PHP_SELF']);

    ?>
    <div class="footer_wrapper">


        <!-- ######## Footer Data ###########  -->

        <div class="footer_data">
            <div class="footer_data_box">
                <img src="<?php echo $base_url; ?>images/salesforce-footer.png" alt="">
            </div>

            <div class="footer_data_box">
                <h2>USA</h2>
                <h4>Los Angeles City Hall</h4>
                <p>200 N Spring St,</p>
                <p> Los Angeles, CA 90012, USA</p>





            </div>
            <div class="footer_data_box">
                <h2>UK</h2>
                <h4>10 Downing Street</h4>
                <p>Westminster,</p>
                <p> London SW1A 2AA,
                    United Kingdom</p>


            </div>
            <div class="footer_data_box">
                <h2>Hydrabad</h2>
                <h4>Hitech City</h4>
                <p>Madhapur,</p>
                <p>Hyderabad, Telangana 500081,
                    India</p>


            </div>
            <div class="footer_data_box">
                <h2>New Delhi</h2>
                <h4>XYZ Building</h4>
                <p>Saket,</p>
                <p>New Delhi, India</p>


            </div>




        </div>

        <div class="footer_data">

            <div class="footer_data_box">
                <h2>Quick Links</h2>
                <ul>
                    <li><a href="<?php echo $base_url; ?>home" class="nav-link <?php echo ($current_page == 'home.php') ? 'current' : ''; ?>">Home</a></li>
                    <li><a href="<?php echo $base_url; ?>about-us" class="nav-link <?php echo ($current_page == 'about-us.php') ? 'current' : ''; ?>">About Us</a></li>
                    <li><a href="<?php echo $base_url; ?>our-services" class="dropbtn nav-link <?php echo ($current_page == 'our-services.php') ? 'current' : ''; ?> ">Our Services</a></li>
                    <li><a href="<?php echo $base_url; ?>insights" class="nav-link <?php echo ($current_page == 'insights.php') ? 'current' : ''; ?>">Insights</a></li>
                    <li><a href="<?php echo $base_url; ?>successes" class="nav-link <?php echo ($current_page == 'successes.php') ? 'current' : ''; ?>">Successes</a></li>
                    <li><a href="<?php echo $base_url; ?>contact-us" class="nav-link <?php echo ($current_page == 'contact-us.php') ? 'current' : ''; ?>">Contact Us</a></li>
                </ul>

            </div>
            <div class="footer_data_box">
                <h2>What We Do</h2>
                <ul>

                    <li><a href="#">Customer Relationship Management (CRM)</a></li>
                    <li><a href="#">Sales Automation</a></li>
                    <li><a href="#">Marketing Solutions</a></li>
                    <li><a href="#">Customer Service & Support</a></li>
                    <li><a href="#">Analytics and Insights</a></li>
                    <li><a href="#">Enterprise Applications</a></li>
                    <li><a href="#">Industry-Specific Solutions</a></li>
                    <li><a href="#">AI and Automation</a></li>
                    <li><a href="#">Digital Transformation</a></li>
                    <li><a href="#">Commerce Solutions</a></li>
                </ul>

            </div>
            <div class="footer_data_box">
                <h2>Sectors</h2>
                <ul>
                    <li><a href="#">Salesforce for Healthcare and Life Sciences</a></li>
                    <li><a href="#">Salesforce for Financial Services</a></li>
                    <li><a href="#">Salesforce for Retail and Consumer Goods</a></li>
                    <li><a href="#">Salesforce for Manufacturing</a></li>
                    <li><a href="#">Salesforce for Education</a></li>
                    <li><a href="#">Salesforce for Government and Public Sector</a></li>
                    <li><a href="#">Salesforce for Media and Communications</a></li>
                    <li><a href="#">Salesforce for Nonprofit Organizations</a></li>
                </ul>

            </div>
            <div class="footer_data_box">
                <h2>Capabilites</h2>
                <ul>
                    <li><a href="#">Salesforce Scalability</a></li>
                    <li><a href="#">Salesforce Data Management</a></li>
                    <li><a href="#">Salesforce Scalability</a></li>
                    <li><a href="#">Salesforce Mobile Solutions</a></li>
                    <li><a href="#">Salesforce Customer Support</a></li>
                    <li><a href="#">Salesforce App Development</a></li>
                </ul>

            </div>
            <div class="footer_data_box">
                <h2>Important Links</h2>
                <ul>
                    <li><a href="#">Salesforce Login</a></li>
                    <li><a href="#">Salesforce Trailhead</a></li>
                    <li><a href="#">Salesforce Help Center</a></li>
                    <li><a href="#">About Salesforce</a></li>
                </ul>

            </div>



        </div>

        <div class="footer_data copyright">
            <div class="footer_data_box ">
                <img src="<?php echo $base_url; ?>images/certified-warranty-guarantee-insurance-assurance-concept.jpg" class="certification" alt="">
            </div>

            <div class="footer_data_box">
                <p>© Copyright <strong>Salesforce Clouds </strong> || All Rights Reserved</p>





            </div>
            <div class="footer_data_box social-icons">
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-square-x-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-square-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-linkedin"></i></a>


            </div>





        </div>


    </div>

</body>

</html>