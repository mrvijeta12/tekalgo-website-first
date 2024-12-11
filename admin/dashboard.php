<?php
include_once "session.php";
check_login();
include_once "database.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TekAlgo</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>

<body>
    <?php include 'navbar.php';

    // Function to count rows in a table based on a condition
    function getCount($conn, $tableName, $condition = "")
    {
        $query = "SELECT COUNT(id) AS total FROM $tableName";

        // Append the condition if provided
        if (!empty($condition)) {
            $query .= " WHERE $condition";
        }

        $stmt = $conn->prepare($query);

        if (!$stmt) {
            die("Query preparation failed: " . $conn->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            die("Query execution failed: " . $stmt->error);
        }

        $count = $result->fetch_assoc()['total'] ?? 0;
        $stmt->close();
        return $count;
    }

    // Get the counts
    $blogCount = getCount($conn, "main_website_blog", "blog_status = 'published'"); // Count only published blogs
    $userCount = getCount($conn, "webdev_auth"); // Count users
    $draftCount = getCount($conn, "main_website_blog", "blog_status = 'draft'"); // Count draft blogs
    ?>

    <div class="container">
        <main class="content">
            <h1 class="dashboard">Dashboard</h1>

            <div class="dashboard-cards">
                <div class="cards">
                    <div>
                        <h3>Blogs</h3>
                    </div>
                    <div class="cards-image">
                        <img src="../images/blog.png" alt="blog-image">
                        <span><?php echo $blogCount; ?></span>
                    </div>
                </div>

                <div href="users" class="cards">
                    <div>
                        <h3>Users</h3>
                    </div>
                    <div class="cards-image">
                        <img src="../images/user.png" alt="user-image">
                        <span><?php echo $userCount; ?></span>
                    </div>
                </div>

                <div href="drafts" class="cards">
                    <div>
                        <h3>Draft</h3>
                    </div>
                    <div class="cards-image">
                        <img src="../images/draft.png" alt="draft-image">
                        <span><?php echo $draftCount; ?></span>
                    </div>
                </div>
            </div>


            <div class="graph-wrapper">

                <div class="graph graph-child">
                    <h1>Graph</h1>
                </div>
                <div class="category-lists graph-child">
                    <p>Home</p>
                    <p>About Us</p>
                    <p>Our Services</p>
                    <p>Insights</p>
                    <p>Successes</p>
                    <p>Contact Us</p>
                    <p>Salesforce Sales Cloud</p>
                    <p>Salesforce Service Cloud</p>
                    <p>Salesforce Marketing Cloud</p>
                    <p>Salesforce Analytic Cloud</p>
                    <p>Salesforce Education Cloud</p>
                    <p>Salesforce Heathcare Cloud</p>
                    <p>Salesforce Public Cloud</p>
                    <p>Salesforce Financial Cloud</p>
                    <p>Salesforce Community Cloud</p>
                    <p>Salesforce Experience Cloud</p>
                    <p>Salesforce Commerce Cloud</p>




                </div>
            </div>



        </main>
    </div>

</body>

</html>