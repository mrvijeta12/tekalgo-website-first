<?php
include_once "session.php";
include_once "database.php";
check_login();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/users.css">
    <title>Users</title>

</head>

<body>
    <?php include_once 'navbar.php'; ?>
    <div class="container">
        <main class="content">
            <div class="wrapper">





                <h1>Other Contribution</h1>

                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>

                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch users from the database
                        $sql = "SELECT id, username, email FROM auth ORDER BY id ASC";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $no = 1; // Counter for No. column
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . htmlspecialchars($row['username']) . "</td>";

                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2'>No users found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>

    </div>
</body>

</html>