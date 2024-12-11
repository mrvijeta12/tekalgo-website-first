<?php
include_once "session.php";
check_login();
include_once "database.php";

// Fetch draft blogs from the database
$sql = "SELECT id, slug, category, blog_date, blog_status FROM main_website_blog WHERE blog_status = 'draft' ORDER BY id DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Draft Blogs</title>
    <link rel="stylesheet" href="./assets/css/drafts.css">
</head>

<body>

    <?php include_once "navbar.php"; ?>
    <div class="container">
        <main class="content">
            <div class="wrapper">
                <h1>Draft</h1>


                <!-- Table to Display Draft Blogs -->
                <table class="blog-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th colspan="2" style="text-align: center;">Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            $count = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $count++ . "</td>";
                                echo "<td>" . $row['slug'] . "</td>";
                                echo "<td>" . $row['blog_status'] . "</td>";
                                echo "
                                <td>
                                    <div class='action-content'>
                                        <a href='edit_and_publish_blog.php?slug=" . $row['slug'] . "'class='edit-button'><i class='fa-solid fa-pen-to-square'></i></a>
                                    </div>
                                </td>
                                <td>
                                    <div class='action-content'>
                                        <form method='POST' action='publish_blog.php' style='display:inline;'>
                                            <input type='hidden' name='blog_id' value='" . $row['id'] . "'>
                                            <button type='submit' class='publish-button'><i class='fa-solid fa-upload'></i></button>
                                        </form>
                                    </div>
                                </td>
                            ";


                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No draft blogs found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </main>
    </div>


</body>

</html>