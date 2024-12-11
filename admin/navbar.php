<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
        src="https://kit.fontawesome.com/cdf9a174a4.js"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/navbar.css" />

    <title>Admin Panel</title>
</head>

<body>
    <?php

    $current_page = basename($_SERVER['PHP_SELF']);

    ?>
    <!-- Header with Logo -->
    <header class="header">
        <h1>TekAlgo</h1>
    </header>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <!-- Menu Icon for Small Screens -->
        <div class="menu-icon" id="menu-icon">
            <!-- Hamburger Icon -->
            <span class="menu-open"><i class="fa-solid fa-bars"></i></span>
            <!-- Close Icon -->
            <span class="menu-close"><i class="fa-solid fa-x"></i></span>
        </div>
        <ul class="nav-links">
            <li>
                <a
                    href="dashboard.php"
                    class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'current' : ''; ?>"><i class="fa-solid fa-house"></i> Dashboard
                </a>
            </li>

            <li class="dropdown">
                <a
                    href=""
                    class="nav-link <?php echo ($current_page == 'blogs.php') ? 'current' : ''; ?>"><i class="fa-regular fa-newspaper"></i>My Blogs <span><i class="fa-solid fa-caret-right dropbtn"></i></span>
                </a>


                <ul class="dropdown-content">
                    <li>
                        <a href="addblog" class="nav-link <?php echo ($current_page == 'addblog.php') ? 'current' : ''; ?>">Add New

                        </a>
                    </li>
                    <li><a href="blogs" class="nav-link <?php echo ($current_page == 'blogs.php') ? 'current' : ''; ?>">View All</a></li>

                </ul>
            </li>
            <li>
                <a
                    href="users.php"
                    class="nav-link <?php echo ($current_page == 'users.php') ? 'current' : ''; ?>"><i class="fa-regular fa-newspaper"></i>Other Contributions</a>
            </li>
            <li>
                <a
                    href="drafts.php"
                    class="nav-link <?php echo ($current_page == 'drafts.php') ? 'current' : ''; ?>"><i class="fa-regular fa-newspaper"></i> Draft</a>
            </li>

            <li class="dropdown">
                <a
                    href=""
                    class="nav-link <?php echo ($current_page == 'blogs.php') ? 'current' : ''; ?>"><i class="fa-regular fa-newspaper"></i>SEO Setup <span><i class="fa-solid fa-caret-right dropbtn"></i></span>
                </a>


                <ul class="dropdown-content">
                    <li>
                        <a href="basic-details" class="nav-link <?php echo ($current_page == 'basic-details.php') ? 'current' : ''; ?>">Basic Details

                        </a>
                    </li>
                    <li><a href="analytics" class="nav-link <?php echo ($current_page == 'analytics.php') ? 'current' : ''; ?>">Analytics</a></li>

                </ul>
            </li>

            <li>
                <a href="logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            </li>
        </ul>
    </nav>
</body>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const menuIcon = document.getElementById("menu-icon"); // Menu icon container
        const sidebar = document.getElementById("sidebar"); // Sidebar element

        // Toggle sidebar visibility on menu icon click
        menuIcon.addEventListener("click", () => {
            sidebar.classList.toggle("active"); // Toggle 'active' class on sidebar
            menuIcon.classList.toggle("open"); // Toggle 'open' class on menu icon
        });
    });


    // dropdown
    // clear if  already added eventlistener possibly when screen size change from hover to click and getting dropdowns parameter from below
    function clearDropdownEventListeners(dropdowns) {
        dropdowns.forEach((dropdown) => {
            const newDropdown = dropdown.cloneNode(true);
            dropdown.parentNode.replaceChild(newDropdown, dropdown);
        });
    }

    // add event listener to dropdowns
    function addDropdownListener() {
        const dropdowns = document.querySelectorAll(".dropdown");
        clearDropdownEventListeners(dropdowns);

        const updatedDropdowns = document.querySelectorAll(".dropdown");
        if (window.innerWidth >= 768) {
            updatedDropdowns.forEach((dropdown) => {
                dropdown.addEventListener("mouseenter", () => {
                    dropdown.classList.add("show");
                });

                dropdown.addEventListener("mouseleave", () => {
                    dropdown.classList.remove("show");
                });
            });
        } else {
            updatedDropdowns.forEach((dropdown) => {
                // targeting only dropdown anchor beacuse service and industry are anchor tag that refresh the page and prevent the dropdown-content  from opening
                const dropdownLink = dropdown.querySelector("a");
                const dropdownContent = dropdown.querySelector(".dropdown-content");

                dropdownLink.addEventListener("click", (event) => {
                    event.preventDefault();

                    // close other dropdowns when current dropdown is clicked
                    updatedDropdowns.forEach((otherDropdown) => {
                        if (otherDropdown !== dropdown) {
                            otherDropdown.classList.remove("show");
                        }
                    });

                    // open or close dropdown when current dropdown is clicked
                    dropdown.classList.toggle("show");
                });

                // Basically for desktop user interface
                dropdown.addEventListener("mouseleave", () => {
                    dropdown.classList.remove("show");
                });
                dropdownContent.addEventListener("mouseleave", () => {
                    dropdown.classList.remove("show");
                });
            });
        }
    }

    // Initial Setup: addDropdownListener() is called immediately when the page loads to set up the event listeners based on the current viewport size.
    addDropdownListener();

    //     window.addEventListener("resize", addDropdownListener) ensures that the dropdown functionality adapts dynamically if the user resizes the browser window.

    // Every time the window is resized, it will clear the existing event listeners and reattach them based on the new viewport size.
    window.addEventListener("resize", addDropdownListener);
</script>

</html>