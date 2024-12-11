<?php
include_once "./session.php";
check_login();
include_once 'database.php';

// Fetch content by slug
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$meta_title = $summary = $social_sharing_image = $content = "";

if ($slug) {
    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT meta_title, summary, social_sharing_image, category, content FROM main_website_blog WHERE slug = ?");

    if ($stmt === false) {
        die('MySQL prepare error: ' . htmlspecialchars($conn->error));
    }

    // Bind parameters
    $stmt->bind_param("s", $slug);

    // Execute the statement
    if (!$stmt->execute()) {
        die('MySQL execute error: ' . htmlspecialchars($stmt->error));
    }

    // Bind the result variables
    $stmt->bind_result($meta_title, $summary, $social_sharing_image, $category, $content);

    // Fetch the data
    if (!$stmt->fetch()) {
        echo "No content found for this slug.";
    }

    // Debugging: Check the fetched value of the image
    // var_dump($social_sharing_image);  
    // Check the value of the image URL from DB

    // Fix escaped content for proper rendering
    $content = stripslashes($content); // Remove unnecessary backslashes
    $content = htmlspecialchars_decode($content, ENT_QUOTES); // Decode HTML entities like &quot; into normal quotes

    // Now we need to clean the image src within the content
    // Regex to fix the src within content
    $content = preg_replace_callback('/(src|data-mce-src)="\\?&quot;(.*?)\\?&quot;"/', function ($matches) {
        return $matches[1] . '="' . $matches[2] . '"'; // Correcting the src and data-mce-src format
    }, $content);

    // Close the statement
    $stmt->close();
} else {
    echo "Slug not provided.";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit and Publish Blog</title>
    <link rel="stylesheet" href="./assets/css/addblog.css">

    <script src="./tinymce/tinymce.min.js"></script>
    <script>
        const image_upload_handler_callback = (blobInfo, progress) => new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', 'upload.php');

            xhr.upload.onprogress = (e) => {
                progress(e.loaded / e.total * 100);
            };

            xhr.onload = () => {
                if (xhr.status === 403) {
                    reject({
                        message: 'HTTP Error: ' + xhr.status,
                        remove: true
                    });
                    return;
                }

                if (xhr.status < 200 || xhr.status >= 300) {
                    reject('HTTP Error: ' + xhr.status);
                    return;
                }

                const json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    reject('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                resolve(json.location);
            };

            xhr.onerror = () => {
                reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
            };

            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
        });

        tinymce.init({
            selector: '#editor',
            plugins: [
                'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
                'searchreplace', 'wordcount', 'visualblocks', 'code', 'fullscreen', 'insertdatetime', 'media',
                'table', 'emoticons', 'template', 'codesample'
            ],
            toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright alignjustify |' +
                'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
                'forecolor backcolor emoticons',
            menubar: 'favs file edit view insert format tools table',
            content_style: 'body{font-family:Helvetica,Arial,sans-serif; font-size:16px}',
            images_upload_url: 'upload.php',
            images_upload_handler: image_upload_handler_callback
        });
    </script>
</head>

<body>
    <?php include "navbar.php"; ?>
    <div class="container">
        <main class="content">
            <section class="form-section">
                <form method="POST" action="update_or_publish_blog.php" enctype="multipart/form-data" class="form">
                    <h1>Edit and Publish Blog</h1>

                    <!-- Meta Title Field -->
                    <div class="form-group">
                        <label for="meta_title">Meta Title *</label>
                        <input type="text" id="meta_title" name="meta_title" value="<?php echo htmlspecialchars($meta_title, ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>

                    <!-- Summary Field -->
                    <div class="form-group">
                        <label for="summary">Summary *</label>
                        <textarea id="summary" name="summary" rows="5" required><?php echo htmlspecialchars($summary, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>

                    <!-- Feature Image Field -->
                    <div class="form-group">
                        <label for="featureImage">Feature Image (Current: <?php echo htmlspecialchars($social_sharing_image, ENT_QUOTES, 'UTF-8'); ?>)</label>
                        <input type="file" id="featureImage" name="social_sharing_image" accept="image/*">
                    </div>
                    <!-- Blog Categories -->
                    <div class="form-group">
                        <label for="category">Choose Category*</label>
                        <select id="category" name="category">
                            <optgroup label="">
                                <option value="home">Home</option>
                                <option value="about-us">About Us</option>
                                <option value="our-services"> Our Services</option>
                                <option value="successes">Successes</option>
                                <option value="insights">Insights</option>
                                <option value="salesforce-sales-cloud">Salesforce Sales Cloud</option>
                                <option value="salesforce-service-cloud">Salesforce Service Cloud</option>
                                <option value="salesforce-marketing-cloud">Salesforce Marketing Cloud</option>
                                <option value="salesforce-commerce-cloud">Salesforce Commerce Cloud</option>
                                <option value="salesforce-experience-cloud">Salesforce Experience Cloud</option>
                                <option value="salesforce-finance-cloud">Salesforce Finance Cloud</option>
                                <option value="salesforce-community-cloud">Salesforce Community Cloud</option>
                                <option value="salesforce-healthcare-cloud">Salesforce Healthcare Cloud</option>
                                <option value="salesforce-education-cloud">Salesforce Education Cloud</option>
                                <option value="salesforce-public-cloud">Salesforce Public Cloud</option>
                                <option value="salesforce-analytic-cloud">Salesforce Analytic Cloud</option>
                            </optgroup>

                        </select>

                    </div>

                    <!-- Blog Content (TinyMCE Editor) -->
                    <div class="form-group">
                        <label for="editor">Blog Content *</label>
                        <textarea id="editor" name="editorContent"><?php echo htmlspecialchars($content, ENT_NOQUOTES, 'UTF-8'); ?></textarea>
                    </div>

                    <!-- Hidden Slug Field -->
                    <input type="hidden" name="slug" value="<?php echo htmlspecialchars($slug, ENT_QUOTES, 'UTF-8'); ?>">

                    <div class="button">
                        <input type="submit" name="action" value="Update Draft" class="action-btn">
                        <input type="submit" name="action" value="Publish" class="action-btn">
                    </div>
                </form>

            </section>
        </main>
    </div>

</body>

</html>