<?php
include_once "./session.php";
check_login();
include_once 'database.php';

// Fetch content by ID
$id = isset($_GET['id']) ? $_GET['id'] : ''; // Assuming the ID is passed in the URL as 'id'

if ($id) {
    // Prepare the SQL statement to fetch the record based on page_url (or ID)
    $stmt = $conn->prepare("SELECT 
        page_url,  
        page_title,  
        meta_description,  
        meta_keywords,  
        meta_robots,  
        canonical_url,  
        og_title,  
        og_description,  
        og_image,  
        og_url,  
        og_type,  
        og_site_name,  
        og_locale,  
        twitter_card,  
        twitter_site,  
        twitter_creator,  
        meta_author,  
        meta_viewport,  
        meta_theme_color,  
        meta_charset,  
        meta_http_equiv,  
        schema_markup,  
        created_at,  
        updated_at
        FROM public_pages_seo_setup WHERE id = ?");

    if ($stmt === false) {
        die('MySQL prepare error: ' . htmlspecialchars($conn->error));
    }

    // Bind the parameter (assuming page_url is a string)
    $stmt->bind_param("i", $id);

    // Execute the statement
    if (!$stmt->execute()) {
        die('MySQL execute error: ' . htmlspecialchars($stmt->error));
    }

    // Bind the result variables
    $stmt->bind_result(
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
        $created_at,
        $updated_at
    );

    // Fetch the data
    if (!$stmt->fetch()) {
        die('No record found for the given ID.');
    }

    // Close the statement
    $stmt->close();
} else {
    die("Page URL not provided in the URL.");
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit and Update Page URL</title>
    <link rel="stylesheet" href="./assets/css/addblog.css">
</head>

<body>
    <?php include "navbar.php"; ?>
    <div class="container">
        <main class="content">
            <section class="form-section">
                <form method="POST" action="update-seo-url.php" enctype="multipart/form-data" class="form">
                    <h1>Update SEO Content</h1>

                    <div class="form-group">
                        <label for="page_url">Page URL</label>
                        <input type="url" id="page_url" name="page_url" value="<?php echo htmlspecialchars($page_url, ENT_QUOTES, 'UTF-8'); ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="page_title">Page Title</label>
                        <input type="text" id="page_title" name="page_title" maxlength="255" value="<?php echo htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="form-group">
                        <label for="meta_description">Meta Description</label>
                        <textarea id="meta_description" name="meta_description" maxlength="500"><?php echo htmlspecialchars($meta_description, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="meta_keywords">Meta Keywords</label>
                        <textarea id="meta_keywords" name="meta_keywords"><?php echo htmlspecialchars($meta_keywords, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>

                    <div class="form-group-wrapper">

                        <div class="form-group">
                            <label for="meta_robots">Meta Robots</label>
                            <select id="meta_robots" name="meta_robots">

                                <option value="index, nofollow" <?php echo $meta_robots === 'index, nofollow' ? 'selected' : ''; ?>>Index, nofollow</option>
                                <option value="noindex, follow" <?php echo $meta_robots === 'noindex, follow' ? 'selected' : ''; ?>>noindex, Follow</option>
                                <option value="noindex, nofollow" <?php echo $meta_robots === 'noindex, nofollow' ? 'selected' : ''; ?>>noindex, nofollow</option>
                                <option value="index, follow" <?php echo $meta_robots === 'index, follow' ? 'selected' : ''; ?>>Index, Follow</option>





                            </select>
                        </div>
                        <div class="form-group">
                            <label for="og_type">OG Type</label>
                            <select id="og_type" name="og_type">
                                <option value="website" <?php echo $og_type === 'website' ? 'selected' : ''; ?>>Website</option>
                                <option value="article" <?php echo $og_type === 'article' ? 'selected' : ''; ?>>Article</option>
                                <option value="video" <?php echo $og_type === 'video' ? 'selected' : ''; ?>>Video</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="twitter_card">Twitter Card</label>
                            <select id="twitter_card" name="twitter_card">
                                <option value="summary" <?php echo $twitter_card === 'summary' ? 'selected' : ''; ?>>Summary</option>
                                <option value="summary_large_image" <?php echo $twitter_card === 'summary_large_image' ? 'selected' : ''; ?>>Summary Large Image</option>
                            </select>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="canonical_url">Canonical URL</label>
                        <input type="url" id="canonical_url" name="canonical_url" value="<?php echo htmlspecialchars($canonical_url, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="form-group">
                        <label for="og_title">OG Title</label>
                        <input type="text" id="og_title" name="og_title" maxlength="255" value="<?php echo htmlspecialchars($og_title, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="form-group">
                        <label for="og_description">OG Description</label>
                        <textarea id="og_description" name="og_description" maxlength="500"><?php echo htmlspecialchars($og_description, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="og_image">OG Image</label>
                        <?php if (!empty($og_image)): ?>
                            <!-- Display the current file path -->
                            <div>
                                <p>Current File Path: <?php echo htmlspecialchars($og_image, ENT_QUOTES, 'UTF-8'); ?></p>
                            </div>
                        <?php endif; ?>
                        <!-- Input for uploading a new file -->
                        <input type="file" id="og_image" name="og_image" accept="image/*">
                    </div>



                    <div class="form-group">
                        <label for="og_url">OG URL</label>
                        <input type="url" id="og_url" name="og_url" value="<?php echo htmlspecialchars($og_url, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>


                    <div class="form-group-wrapper">

                        <div class="form-group">
                            <label for="og_site_name">OG Site Name</label>
                            <input type="text" id="og_site_name" name="og_site_name" maxlength="100" value="<?php echo htmlspecialchars($og_site_name, ENT_QUOTES, 'UTF-8'); ?>">
                        </div>

                        <div class="form-group">
                            <label for="og_locale">OG Locale</label>
                            <input type="text" id="og_locale" name="og_locale" maxlength="20" value="<?php echo htmlspecialchars($og_locale, ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="meta_author"> Author</label>
                            <input type="text" id="meta_author" name="meta_author" maxlength="100" value="<?php echo htmlspecialchars($meta_author, ENT_QUOTES, 'UTF-8'); ?>">
                        </div>

                    </div>



                    <div class="form-group">
                        <label for="twitter_site">Twitter Site</label>
                        <input type="text" id="twitter_site" name="twitter_site" maxlength="50" value="<?php echo htmlspecialchars($twitter_site, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="form-group">
                        <label for="twitter_creator">Twitter Creator</label>
                        <input type="text" id="twitter_creator" name="twitter_creator" maxlength="50" value="<?php echo htmlspecialchars($twitter_creator, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>



                    <div class="form-group">
                        <label for="meta_viewport"> Viewport</label>
                        <input type="text" id="meta_viewport" name="meta_viewport" maxlength="255" value="<?php echo htmlspecialchars($meta_viewport, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>



                    <div class="form-group-wrapper">



                        <div class="form-group">
                            <label for="meta_theme_color"> Theme Color</label>
                            <input type="color" id="meta_theme_color" name="meta_theme_color" value="<?php echo htmlspecialchars($meta_theme_color, ENT_QUOTES, 'UTF-8'); ?>">
                        </div>

                        <div class="form-group">
                            <label for="meta_charset">Meta Charset</label>
                            <input type="text" id="meta_charset" name="meta_charset" maxlength="20" value="<?php echo htmlspecialchars($meta_charset, ENT_QUOTES, 'UTF-8'); ?>">
                        </div>

                        <div class="form-group">
                            <label for="meta_http_equiv">Meta HTTP Equiv</label>
                            <input type="text" id="meta_http_equiv" name="meta_http_equiv" maxlength="100" value="<?php echo htmlspecialchars($meta_http_equiv, ENT_QUOTES, 'UTF-8'); ?>">
                        </div>

                    </div>





                    <div class="form-group">
                        <label for="schema_markup">Schema Markup</label>
                        <?php
                        // Define the default JSON-LD script
                        $default_schema_markup = '
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "SalesClouds",
    "url": "https://www.salesclouds.com",
    "logo": "https://www.salesclouds.com/images/salesclouds-logo.jpg",
    "sameAs": [
        "https://www.facebook.com/salesclouds",
        "https://twitter.com/salesclouds",
        "https://www.instagram.com/salesclouds"
    ],
    "description": "SalesClouds is a leading Salesforce development company offering tailored solutions in Sales Cloud, Service Cloud, Marketing Cloud, and more. Empower your business with our proven expertise.",
    "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+91-911-861-8111",
        "contactType": "Customer Support",
        "email": "info@salesclouds.com"
    }
}';

                        // Use the default JSON-LD script if $schema_markup is null or blank
                        if (empty(trim($schema_markup))) {
                            $schema_markup = $default_schema_markup;
                        }
                        ?>

                        <!-- Textarea for Schema Markup -->
                        <textarea id="schema_markup" name="schema_markup" rows="5"><?php echo htmlspecialchars($schema_markup, ENT_QUOTES, 'UTF-8'); ?></textarea>

                    </div>



                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">

                    <button type="submit" class="action-btn">Update </button>
                </form>
            </section>
        </main>
    </div>
</body>

</html>