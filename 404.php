<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assests/css/404.css">
    <link rel="stylesheet" href="assests/css/navbar.css">
    <link rel="stylesheet" href="assests/css/footer.css">
    <link rel="stylesheet" href="assests/css/theme.css">
    <!-- Font Awesome CDN for icons -->
    <script src="https://kit.fontawesome.com/cdf9a174a4.js" crossorigin="anonymous"></script>

    <title>404 Page</title>
</head>

<body>
    <?php include('navbar.php'); ?>
    <div class="wrapper">
        <div class="wrapper-child wrapper-child-text">
            <strong> <span>Sorry</span>, The Page You Are Looking For Is Not Available</strong>
            <p>The link you followed may be broken, or the page may have been removed. Go back to <a href="./home.php">homepage.</a> </p>

        </div>
        <div class="wrapper-child">

            <img src="images/sorry.png" alt="">
        </div>



    </div>
    <?php include('footer.php'); ?>

</body>

</html>