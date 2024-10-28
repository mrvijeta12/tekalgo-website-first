<?php
include "database.php";
include_once "session.php"; // Include session management file

if (isset($_POST["signin"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate inputs
    if (empty($email) || empty($password)) {
        echo "All fields are required.";
        exit();
    }

    // Check if email is registered
    $query = "SELECT * FROM auth WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['email'] = $email;

            // Redirect to home page or another protected page
            header("Location: dashboard");
            exit();
        } else {
            $email_error = "Invalid email or password";
        }
    } else {
        $email_error = "Invalid email or password";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/login.css">
    <!-- <link rel="stylesheet" href="./css/responsive.css"> -->
    <title>Document</title>
</head>

<body>
    <section class="form-wrapper">
        <form action="" class="form" method="POST">
            <h2>Sign In</h2>

            <label for="">Email</label>
            <input type="email" name="email" placeholder="Email">

            <label for="">Password</label>
            <input type="password" name="password" placeholder="Password">
            <?php if (isset($email_error)) : ?>
                <p class="error"><?php echo htmlspecialchars($email_error); ?></p>
            <?php endif; ?>
            <input type="submit" value="Sign In" name="signin"></input>
            <span>Do not have an acoount?</span>
            <a href="index">Sign Up</a>

        </form>
    </section>

</body>

</html>