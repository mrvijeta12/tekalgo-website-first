<?php
include_once "session.php";
check_login();

include_once 'database.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize input fields
    $meta_title = isset($_POST['meta_title']) ? $conn->real_escape_string($_POST['meta_title']) : '';
    $summary = isset($_POST['summary']) ? $conn->real_escape_string($_POST['summary']) : '';
    $content = isset($_POST['editorContent']) ? $conn->real_escape_string($_POST['editorContent']) : '';

    // Handle feature image upload
    $featureImagePath = '';
    if (isset($_FILES['social_sharing_image']) && $_FILES['social_sharing_image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpName = $_FILES['social_sharing_image']['tmp_name'];
        $imageName = $_FILES['social_sharing_image']['name'];
        $imageError = $_FILES['social_sharing_image']['error'];

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
                // File successfully uploaded, proceed to insert into the database
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

    // Remove leading dashes if present
    $slug = ltrim($slug, '-');

    // Insert blog data into the database
    $sql = "INSERT INTO main_website_blog (meta_title, summary, content, social_sharing_image, slug) 
            VALUES ('$meta_title', '$summary', '$content', '$featureImagePath', '$slug')";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
        exit; // Ensure no further code is executed after redirection
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>
