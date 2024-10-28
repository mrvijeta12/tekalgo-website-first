<?php
include_once "./session.php";
check_login();
include_once 'database.php';

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "blog";

// $conn = new mysqli($servername, $username, $password, $dbname);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// Fetch content by slug
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$meta_title = $summary = $social_sharing_image = $content = "";

if ($slug) {
    $stmt = $conn->prepare("SELECT meta_title, summary, social_sharing_image, content FROM main_website_blog  WHERE slug = ?");
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $stmt->bind_result($meta_title, $summary, $social_sharing_image, $content);
    $stmt->fetch();
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta_title>Edit Blog</meta_title>
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
            menu: {
                favs: {
                    meta_title: 'menu',
                    items: 'code visualaid | searchreplace | emoticons'
                }
            },
            menubar: 'favs file edit view insert format tools table',
            content_style: 'body{font-family:Helvetica,Arial,sans-serif; font-size:16px}',
            images_upload_url: 'upload.php', // Your server-side upload script
            images_upload_handler: image_upload_handler_callback
        });
    </script>
</head>

<body>
    <?php include "./navbar.php" ?>
    <section class="form-section">
        <form method="POST" action="saveEditContent.php" enctype="multipart/form-data" class="form">
            <h1>Edit Blog</h1>

            <!-- meta_title Field (Required) -->
            <div class="form-group">
                <label for="meta_title">meta_title *</label>
                <input type="text" id="meta_title" name="meta_title" value="<?php echo htmlspecialchars($meta_title, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <!-- Summary Field (Required) -->
            <div class="form-group">
                <label for="summary">Summary *</label>
                <textarea id="summary" name="summary" rows="5" required><?php echo htmlspecialchars($summary, ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>

            <!-- Feature Image Field (Optional) -->
            <div class="form-group">
                <label for="featureImage">Feature Image (Current: <?php echo htmlspecialchars($social_sharing_image, ENT_QUOTES, 'UTF-8'); ?>)</label>
                <input type="file" id="featureImage" name="social_sharing_image" accept="image/*">
            </div>

            <!-- Blog Content (TinyMCE Editor) -->
            <div class="form-group">
                <label for="editor">Blog Content *</label>
                <textarea id="editor" name="editorContent"><?php echo htmlspecialchars($content, ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>

            <input type="hidden" name="slug" value="<?php echo htmlspecialchars($slug, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="submit" name="update" value="Update">
        </form>
    </section>
</body>

</html>
