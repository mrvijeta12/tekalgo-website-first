<?php
include_once "session.php";
check_login();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TinyMCE Blog Post Editor</title>
    <link rel="stylesheet" href="assets/css/addblog.css">
    <script src="./tinymce/tinymce.min.js"></script>

    <!-- Initialize TinyMCE Editor with Image Upload Support -->
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
    <?php include "navbar.php" ?>
    <div class="container">
        <main class="content">



            <section class="form-section">
                <form method="POST" action="postblog.php" enctype="multipart/form-data" class="form">

                    <h1>Add Blog</h1>

                    <!-- meta_title Field (Required) -->
                    <div class="form-group">
                        <label for="meta_title">Title*</label>
                        <input type="text" id="meta_title" name="meta_title" required>
                    </div>

                    <!-- summary Field (Required) -->
                    <div class="form-group">
                        <label for="summary">Summary*</label>
                        <textarea id="summary" name="summary" rows="5" required></textarea>
                    </div>

                    <!-- Feature Image Upload (Required) -->
                    <div class="form-group">
                        <label for="featureImage">Feature Image*</label>
                        <input type="file" id="featureImage" name="social_sharing_image" accept="image/*" required>
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

                    <!-- Blog content (TinyMCE Editor) -->
                    <div class="form-group">
                        <label for="editor">Blog Content*</label>
                        <textarea id="editor" name="editorContent"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="button">
                        <input type="submit" name="addToDraft" value="Add To Draft" class="action-btn">
                        <input type="submit" name="create" value="Publish" class="action-btn">


                    </div>
                </form>
            </section>


        </main>
    </div>


</body>

</html>