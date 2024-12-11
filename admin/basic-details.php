<?php
include_once "session.php";
check_login();
include_once "database.php";


// Check if a success message is set in the session
if (isset($_SESSION['success_message'])) {
    echo "<div id='success-message' class='success-message'>" . htmlspecialchars($_SESSION['success_message']) . "</div>";
    // Unset the message after displaying it
    unset($_SESSION['success_message']);
}

// Fetch draft blogs from the database
$sql = "SELECT id, page_url FROM public_pages_seo_setup  ORDER BY id DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Details</title>
    <link rel="stylesheet" href="./assets/css/drafts.css">
</head>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .wrapper h1 {
        margin-bottom: 20px;
    }

    .wrapper label {
        display: block;
        margin-bottom: 10px;
    }

    input[type="text"] {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
    }

    input[type="submit"] {
        padding: 10px 20px;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
    }

    .url-table {
        margin-top: 30px;
    }

    /* Styling for success message */
    .success-message {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        padding: 10px;
        /* margin-bottom: 15px; */
        border-radius: 5px;
        font-size: 14px;
        position: absolute;
        animation: fadeOut 10s forwards;
        z-index: 100;
        top: 10%;
        left: 50%;
        transform: translate(-50%, -50%);

        /* Optional fade-out effect */
    }

    /* Optional fade-out effect */
    @keyframes fadeOut {
        0% {
            opacity: 1;
        }

        100% {
            opacity: 0;
        }
    }
</style>


<body>

    <?php include_once "navbar.php"; ?>
    <div class="container">
        <main class="content">
            <div class="wrapper">
                <h1>SEO Setup</h1>
                <form action="seo-setup-logic.php" method="POST">
                    <label for="">Enter a complete URL</label>
                    <input type="text" name="page_url">
                    <input type="submit" value="Add">
                </form>

            </div>

            <div class="wrapper url-table">
                <h4>Pages</h4>


                <!-- Table to Display Draft Blogs -->
                <table class="blog-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Title</th>

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
                                echo "<td>" . $row['page_url'] . "</td>";

                                echo "
                                <td>
                                    <div class='action-content'>
                                        <a href='proceed-seo-url.php?id=" . $row['id'] . "'class='edit-button'><i class='fa-solid fa-arrow-right'></i></a>
                                    </div>
                                </td>
                                <td>
                                    <div class='action-content'>
                                        <form method='POST' action='delete-seo-url.php' style='display:inline;' onsubmit='return confirmDelete();'>
                                            <input type='hidden' name='id' value='" . $row['id'] . "'>
                                            <button type='submit' class='delete-button'><i class='fa-solid fa-trash-can'></i></button>
                                        </form>
                                    </div>
                                </td>
                            ";


                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No URL Found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </main>
    </div>



    <script>
        setTimeout(function() {
            var message = document.getElementById('success-message');
            if (message) {
                message.style.display = 'none'; // Hide the message
            }
        }, 10000);


        // JavaScript function for delete confirmation
        function confirmDelete() {
            return confirm("Are you sure you want to delete this record?");
        }
    </script>


</body>

</html>