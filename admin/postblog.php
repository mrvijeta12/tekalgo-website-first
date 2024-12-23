<?php
include_once "session.php";
check_login(); // Ensure the user is logged in

include_once 'database.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize input fields
    $meta_title = isset($_POST['meta_title']) ? $conn->real_escape_string($_POST['meta_title']) : '';
    $summary = isset($_POST['summary']) ? $_POST['summary'] : ''; // Don't sanitize summary, keep line breaks intact
    $content = isset($_POST['editorContent']) ? $_POST['editorContent'] : '';
    $category = isset($_POST['category']) ? $conn->real_escape_string($_POST['category']) : '';

    // ** Convert newlines to <br> for proper line breaks in summary **
    $summary = nl2br($summary); // Converts \r\n and \n to <br> tags for display purposes

    // ** Don't escape HTML entities here as we're dealing with raw HTML input**
    // Directly use the content as it is from the editor (TinyMCE handles escaping internally)
    $content = stripslashes($content); // Remove any backslashes added by real_escape_string

    // Retrieve the user's email from session (which indicates the user is logged in)
    $user_email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

    if (empty($user_email)) {
        echo "User not logged in!";
        exit; // If there's no email in session, exit the script
    }

    // Query the database to get the user_id and username from the auth table using the user's email
    $stmt = $conn->prepare("SELECT id, username FROM auth WHERE email = ?");
    $stmt->bind_param("s", $user_email);  // Assuming email is stored as a string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the user_id and username of the logged-in user
        $row = $result->fetch_assoc();
        $author = $row['username']; // Store the username
    } else {
        echo "User not found in the database.";
        exit;
    }

    // Handle feature image upload
    $featureImagePath = '';
    if (isset($_FILES['social_sharing_image']) && $_FILES['social_sharing_image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpName = $_FILES['social_sharing_image']['tmp_name'];
        $imageName = $_FILES['social_sharing_image']['name'];

        // Get the image file extension
        $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        // Define allowed file types
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageExt, $allowed)) {
            // Define a new unique name for the image file
            $imageNewName = uniqid('', true) . '.' . $imageExt;
            $imageDestination = 'uploads/' . $imageNewName;

            // Move the uploaded file to the desired folder
            if (move_uploaded_file($imageTmpName, $imageDestination)) {
                // File successfully uploaded, set the path
                $featureImagePath = $imageDestination;
            } else {
                echo "Error uploading the file.";
                exit;
            }
        } else {
            echo "Invalid file type.";
            exit;
        }
    } else {
        echo "Image upload error: " . $_FILES['social_sharing_image']['error'];
        exit;
    }

    // Generate slug from meta_title
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $meta_title)));
    $slug = ltrim($slug, '-'); // Remove leading dashes if present

    // Get current date, time, and datetime
    date_default_timezone_set('Asia/Kolkata');
    $currentDate = date('Y-m-d'); // Current date in YYYY-MM-DD format
    $currentTime = date('H:i:s'); // Current time in HH:MM:SS format
    $currentDatetime = date('Y-m-d H:i:s'); // Current datetime in YYYY-MM-DD HH:MM:SS format

    // Determine the blog status based on the button clicked
    $blog_status = isset($_POST['addToDraft']) ? 'draft' : 'published';

    // Prepare the SQL query using prepared statements
    $stmt = $conn->prepare("INSERT INTO main_website_blog (
                meta_title, 
                summary, 
                content, 
                category, 
                social_sharing_image, 
                slug, 
                blog_status, 
                blog_date, 
                blog_time, 
                created_at, 
                author
            ) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters (added author)
    $stmt->bind_param("sssssssssss", $meta_title, $summary, $content, $category, $featureImagePath, $slug, $blog_status, $currentDate, $currentTime, $currentDatetime, $author);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to dashboard after successful operation
        header("Location: dashboard.php");
        exit; // Ensure no further code is executed after redirection
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
