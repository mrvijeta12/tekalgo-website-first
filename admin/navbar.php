<?php
include_once "session.php";
check_login();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/navbar.css">

    <title>Document</title>
</head>

<body>
    <?php

    $current_page = basename($_SERVER['PHP_SELF']);
    ?>

    <nav class="navbar">
        <div class="nav_logo"><a href="">TekAlgo</a></div>
        <div class="menu-toggle" id="mobile-menu">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <ul class="nav-links">
            <li><a href="dashboard" class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">Dashboard</a></li>

            <li><a href="addblog" class="nav-link <?php echo ($current_page == 'addblog.php') ? 'active' : ''; ?>">Add Blog</a></li>
            <!-- <li><a href="editblog.php" class="nav-link <?php echo ($current_page == 'editblog.php') ? 'active' : ''; ?>">Edit Blog</a></li> -->
            <li><a href="deleteblog" class="nav-link <?php echo ($current_page == 'deleteblog.php') ? 'active' : ''; ?>">Delete Blog</a></li>
            <li><a href="logout" class="nav-link >">Log Out</a></li>

        </ul>
    </nav>


    <script>
        const menuToggle = document.querySelector("#mobile-menu");
        const navLinks = document.querySelector(".nav-links");

        menuToggle.addEventListener("click", () => {
            navLinks.classList.toggle("active");
            menuToggle.classList.toggle("active");
        });
    </script>

</body>

</html>