<?php
// Start the session and include necessary files
include_once "./session.php";
check_login(); // Ensure the user is logged in
include_once 'database.php'; // Include the database connection

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get the form data from POST
    $id = isset($_POST['id']) ? $_POST['id'] : ''; // Get the ID from the hidden field
    $page_url = isset($_POST['page_url']) ? $_POST['page_url'] : '';
    $page_title = isset($_POST['page_title']) ? $_POST['page_title'] : '';
    $meta_description = isset($_POST['meta_description']) && !empty($_POST['meta_description']) ? $_POST['meta_description'] : NULL;
    $meta_keywords = isset($_POST['meta_keywords']) && !empty($_POST['meta_keywords']) ? $_POST['meta_keywords'] : NULL;
    $meta_robots = isset($_POST['meta_robots']) ? $_POST['meta_robots'] : '';
    $canonical_url = isset($_POST['canonical_url']) && !empty($_POST['canonical_url']) ? $_POST['canonical_url'] : NULL;
    $og_title = isset($_POST['og_title']) && !empty($_POST['og_title']) ? $_POST['og_title'] : NULL;
    $og_description = isset($_POST['og_description']) && !empty($_POST['og_description']) ? $_POST['og_description'] : NULL;
    $og_url = isset($_POST['og_url']) && !empty($_POST['og_url']) ? $_POST['og_url'] : NULL;
    $og_type = isset($_POST['og_type']) ? $_POST['og_type'] : '';
    $og_site_name = isset($_POST['og_site_name']) ? $_POST['og_site_name'] : '';
    $og_locale = isset($_POST['og_locale']) ? $_POST['og_locale'] : '';
    $twitter_card = isset($_POST['twitter_card']) ? $_POST['twitter_card'] : '';
    $twitter_site = isset($_POST['twitter_site']) && !empty($_POST['twitter_site']) ? $_POST['twitter_site'] : NULL;
    $twitter_creator = isset($_POST['twitter_creator']) && !empty($_POST['twitter_creator']) ? $_POST['twitter_creator'] : NULL;
    $meta_author = isset($_POST['meta_author']) ? $_POST['meta_author'] : '';
    $meta_viewport = isset($_POST['meta_viewport']) ? $_POST['meta_viewport'] : '';
    $meta_theme_color = isset($_POST['meta_theme_color']) ? $_POST['meta_theme_color'] : '';
    $meta_charset = isset($_POST['meta_charset']) ? $_POST['meta_charset'] : '';
    $meta_http_equiv = isset($_POST['meta_http_equiv']) ? $_POST['meta_http_equiv'] : '';
    $schema_markup = isset($_POST['schema_markup']) && !empty($_POST['schema_markup']) ? $_POST['schema_markup'] : NULL;

    // Handle the image upload for og_image
    $og_image = NULL; // Initialize as NULL by default
    if (isset($_FILES['og_image']) && $_FILES['og_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['og_image']['tmp_name'];
        $fileName = $_FILES['og_image']['name'];
        $fileSize = $_FILES['og_image']['size'];
        $fileType = $_FILES['og_image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Allowed file extensions
        $allowedFileExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedFileExtensions)) {
            // Directory where the uploaded file will be saved
            $uploadFileDir = 'uploads/seo_images/';
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0777, true); // Create the directory if it doesn't exist
            }
            $destPath = $uploadFileDir . uniqid() . '.' . $fileExtension;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $og_image = $destPath; // Set the path of the uploaded file
            } else {
                die("There was an error moving the uploaded file.");
            }
        } else {
            die("Upload failed. Allowed file types: " . implode(',', $allowedFileExtensions));
        }
    }

    // Validate the inputs (You may also want to add further validation)
    if (empty($id)) {
        die("ID cannot be empty.");
    }

    // Prepare the SQL statement to update the record
    $stmt = $conn->prepare("UPDATE public_pages_seo_setup
                            SET 
                                page_url = ?, 
                                page_title = ?, 
                                meta_description = ?, 
                                meta_keywords = ?, 
                                meta_robots = ?, 
                                canonical_url = ?, 
                                og_title = ?, 
                                og_description = ?, 
                                og_image = ?, 
                                og_url = ?, 
                                og_type = ?, 
                                og_site_name = ?, 
                                og_locale = ?, 
                                twitter_card = ?, 
                                twitter_site = ?, 
                                twitter_creator = ?, 
                                meta_author = ?, 
                                meta_viewport = ?, 
                                meta_theme_color = ?, 
                                meta_charset = ?, 
                                meta_http_equiv = ?, 
                                schema_markup = ?
                            WHERE id = ?");

    if ($stmt === false) {
        die('MySQL prepare error: ' . htmlspecialchars($conn->error));
    }

    // Bind the parameters for the SQL query
    $stmt->bind_param(
        "sssssssssssssssssssssss",
        $page_url,
        $page_title,
        $meta_description,
        $meta_keywords,
        $meta_robots,
        $canonical_url,
        $og_title,
        $og_description,
        $og_image,
        $og_url,
        $og_type,
        $og_site_name,
        $og_locale,
        $twitter_card,
        $twitter_site,
        $twitter_creator,
        $meta_author,
        $meta_viewport,
        $meta_theme_color,
        $meta_charset,
        $meta_http_equiv,
        $schema_markup,
        $id
    ); // Bind the ID to the WHERE clause

    // Execute the query and check if successful
    if ($stmt->execute()) {
        // Successfully updated
        header("Location: basic-details.php"); // Redirect to a success page or back to the form
        exit;
    } else {
        // Error during update
        die("Error updating SEO data: " . htmlspecialchars($stmt->error));
    }

    // Close the statement
    $stmt->close();
} else {
    // If not a POST request, redirect or show an error
    die("Invalid request method.");
}

// Close the database connection
$conn->close();
