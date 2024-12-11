<?php
include 'database.php';
include_once 'session.php';

// Check if form is submitted
if (isset($_POST["signup"])) {

    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];

    // Validate inputs
    if (empty($email) || empty($password) || empty($username)) {
        echo "All fields are required.";
        exit();
    }

    // Check if email is already registered
    $check_query = "SELECT * FROM auth  WHERE email = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Email is already registered
        $email_error = "Email is already registered";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and execute SQL statement to insert new user
        $insert_query = "INSERT INTO auth (email, password,username) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("sss", $email, $hashed_password, $username);

        if ($insert_stmt->execute()) {
            // Set session variables
            $_SESSION['email'] = $email;

            // Redirect to addblog.php
            header("Location: dashboard.php");
            exit(); // Ensure no further code is executed
        } else {
            echo "Error: " . $insert_stmt->error;
        }

        // Close insert statement
        $insert_stmt->close();
    }

    // Close check statement
    $check_stmt->close();

    // Close database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/index.css">
    <!-- <link rel="stylesheet" href="./css/responsive.css"> -->
    <title>Document</title>
</head>

<body>
    <section class="form-wrapper">
        <form action="" method="POST" class="form">
            <h2>Register</h2>
            <label for="">Name</label>
            <input type="text" name="username" placeholder="Enter Your Name" required>

            <label for="">Email</label>
            <input type="email" name="email" placeholder="Email" required>
            <?php if (isset($email_error)) : ?>
                <p class="error"><?php echo htmlspecialchars($email_error); ?></p>
            <?php endif; ?>

            <label for="">Password</label>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Sign Up" name="signup">
            <span>Already have an account?</span>
            <a href="login">Log In</a>
        </form>
    </section>
</body>

</html>