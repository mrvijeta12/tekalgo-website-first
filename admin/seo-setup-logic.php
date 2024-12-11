<?php
include_once "session.php";
check_login(); // Ensure the user is logged in

include_once 'database.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $page_url = isset($_POST['page_url']) ? $conn->real_escape_string($_POST['page_url']) : '';
    // Prepare the SQL query using prepared statements
    $stmt = $conn->prepare("INSERT INTO public_pages_seo_setup (
        page_url
     
    ) 
    VALUES (?)");

    // Bind parameters (added author)
    $stmt->bind_param("s", $page_url);

    // Execute the query
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "The SEO URL has been added successfully!";
        // Redirect to dashboard after successful operation
        header("Location: basic-details.php");
        exit; // Ensure no further code is executed after redirection
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
