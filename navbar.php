<?php

echo $current_page = basename($_SERVER['PHP_SELF']);

?>
<nav class="navbar">

    <a href="../home" class="logo-link">
        <img src="../images/logo1.png" alt="Logo" class="logo" />
    </a>

    </a>

    <div class="menu-icon" id="menu-toggle">
        <!-- Hamburger icon -->
        <i class="fas fa-bars"></i>
    </div>
    <ul class="nav-links" id="nav-links">
        <!-- Close Button for mobile/tablet view -->
        <span class="close-btn" id="close-btn">
            <!-- Cross icon -->
            <i class="fas fa-times"></i>
        </span>

        <li><a href="../home" class="nav-link <?php echo ($current_page == 'home.php') ? 'current' : ''; ?>">Home</a></li>
        <li><a href="../about" class="nav-link <?php echo ($current_page == 'about.php') ? 'current' : ''; ?>">About</a></li>

        <li class="dropdown">
            <a href="../services" class="dropbtn nav-link <?php echo ($current_page == 'services.php') ? 'current' : ''; ?> ">Services</a>
            <span class="dropdown-icon" id="dropdown-toggle"><i class="fa-solid fa-caret-down"></i></span>

            <ul class="dropdown-content" id="dropdown-menu">
                <li>
                    <a href="../salesforce-sales-cloud">Salesforce Sales Cloud</a>
                </li>
                <li>
                    <a href="../salesforce-service-cloud">Salesforce Service Cloud</a>
                </li>
                <li>
                    <a href="../salesforce-marketing-cloud">Salesforce Marketing Cloud</a>
                </li>
                <li>
                    <a href="../salesforce-commerce-cloud">Salesforce Commerce Cloud</a>
                </li>
                <li>
                    <a href="../salesforce-experience-cloud">Salesforce Experience Cloud</a>
                </li>
                <li>
                    <a href="../salesforce-financial-cloud">Salesforce Financial Cloud</a>
                </li>
                <li>
                    <a href="../salesforce-community-cloud">Salesforce Community Cloud</a>
                </li>
                <li>
                    <a href="../salesforce-healthcare-cloud">Salesforce Healthcare Cloud</a>
                </li>
                <li>
                    <a href="../salesforce-education-cloud">Salesforce Education Cloud</a>
                </li>
                <li>
                    <a href="../salesforce-public-cloud">Salesforce Public Cloud</a>
                </li>
                <li>
                    <a href="../salesforce-analytic-cloud">Salesforce Analytic Cloud</a>
                </li>
            </ul>
        </li>

        <li><a href="../contact" class="nav-link <?php echo ($current_page == 'contact.php') ? 'current' : ''; ?>">Contact</a></li>
        <li><a href="../blog" class="nav-link <?php echo ($current_page == 'blog.php') ? 'current' : ''; ?>">Blog</a></li>
        <li><a href="../success" class="nav-link <?php echo ($current_page == 'success.php') ? 'current' : ''; ?>">Success</a></li>


    </ul>

</nav>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Toggle menu for mobile and tablet view
        document.getElementById("menu-toggle").onclick = function() {
            document.getElementById("nav-links").classList.add("active");
        };

        // Close the nav-links when clicking the close button
        document.getElementById("close-btn").onclick = function() {
            document.getElementById("nav-links").classList.remove("active");
            document.getElementById("dropdown-menu").classList.remove("show"); // Close dropdown when closing nav
        };

        // New added function to handle dropdown behavior
        function handleDropdown() {
            const dropdownToggle = document.getElementById("dropdown-toggle");
            const dropdownMenu = document.getElementById("dropdown-menu");

            let isDropdownHovered = false;
            let isToggleHovered = false;

            // Remove previous event listeners to avoid duplication during resize
            dropdownToggle.onmouseenter = null;
            dropdownToggle.onmouseleave = null;
            dropdownMenu.onmouseenter = null;
            dropdownMenu.onmouseleave = null;
            dropdownToggle.onclick = null;

            // Clear document click listener
            document.removeEventListener('click', documentClickHandler);

            // Hover behavior for larger screens
            if (window.innerWidth > 850) {
                dropdownToggle.onmouseover = function(e) {
                    isToggleHovered = true;
                    showDropdown();
                };

                dropdownToggle.onmouseout = function(e) {
                    isToggleHovered = false;
                    hideDropdownIfNecessary();
                };

                dropdownMenu.onmouseover = function(e) {
                    isDropdownHovered = true;
                    showDropdown();
                };

                dropdownMenu.onmouseout = function(e) {
                    isDropdownHovered = false;
                    hideDropdownIfNecessary();
                };

                function showDropdown() {
                    dropdownMenu.classList.add("show");
                    dropdownMenu.style.display = "flex";
                }

                function hideDropdownIfNecessary() {
                    if (!isDropdownHovered && !isToggleHovered) {
                        dropdownMenu.classList.remove("show");
                        dropdownMenu.style.display = "none";
                    }
                }

            } else {
                // Click behavior for smaller screens
                dropdownToggle.onclick = function(e) {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle("show");
                    dropdownMenu.style.display = dropdownMenu.classList.contains("show") ? "flex" : "none";
                };

                // Close dropdown when clicking outside on smaller screens
                document.addEventListener('click', documentClickHandler);
            }

            // Document click handler for closing the dropdown when clicking outside
            function documentClickHandler(e) {
                if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.remove("show");
                    dropdownMenu.style.display = "none";
                }
            }
        }

        // Call the function on page load and on window resize
        handleDropdown();
        window.onresize = handleDropdown;
    });
</script>