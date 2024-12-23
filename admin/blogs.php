<?php
include_once "session.php";
check_login();

// Include the database connection file
include_once "database.php";

// Fetch available categories with at least one blog (excluding "home" initially)
function getCategoriesWithBlogs($conn)
{
    // Query to fetch distinct categories with at least one blog (excluding "home")
    $query = "SELECT DISTINCT category FROM main_website_blog WHERE category IS NOT NULL AND category != 'home' AND blog_status = 'published'";

    // Execute the query
    $result = $conn->query($query);

    // Check if the query was successful
    if (!$result) {
        die("Error executing query: " . $conn->error);
    }

    // Fetch categories into an array
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row['category'];
    }

    return $categories;
}

// Check if the "home" category has any blogs
$queryHome = "SELECT COUNT(*) as count FROM main_website_blog WHERE category = 'home' AND blog_status = 'published'";
$resultHome = $conn->query($queryHome);
$rowHome = $resultHome->fetch_assoc();
$homeHasBlogs = $rowHome['count'] > 0; // This will be true if 'home' category has blogs

// Fetch categories that have blogs (excluding "home")
$categories = getCategoriesWithBlogs($conn);

// Add "home" to categories if it has blogs
if ($homeHasBlogs) {
    array_unshift($categories, 'home'); // Add "home" at the beginning if it has blogs
}

// Set the default category (first one in the list of categories)
$defaultCategory = $categories[0] ?? ''; // Set the first category as the default if available
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Content Layout</title>
    <link rel="stylesheet" href="assets/css/blogs.css">
    <script>
        // Function to fetch blogs dynamically based on the selected category
        function fetchBlogs(category) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `fetch_blogs.php?category=${encodeURIComponent(category)}`, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const blogs = JSON.parse(xhr.responseText);
                    renderBlogs(blogs);
                }
            };
            xhr.send();
        }

        // Function to render blogs dynamically in the DOM as cards
        function renderBlogs(blogs) {
            const container = document.getElementById('blog-container');
            container.innerHTML = ''; // Clear existing content

            if (blogs.length === 0) {
                container.innerHTML = '<p>No blogs found for this category.</p>';
                return;
            }

            // Loop through blogs and create a card for each one
            blogs.forEach((blog) => {
                const card = document.createElement('div');
                card.className = 'blog-card';

                // Add onclick event to redirect to insights.php with the blog's slug
                card.onclick = function() {
                    window.location.href = `insights.php?slug=${encodeURIComponent(blog.slug)}`;
                };

                const cardHTML = `
                    <div class="blog-image">
                        <img src="${blog.social_sharing_image}" alt="Blog Image" />
                    </div>
                    <div class="blog-details">
                        <h3 class="card-title">${blog.slug}</h3>
                        <p class="card-summary">${blog.summary || "No summary available."}</p>
                        <div class="blog-actions">
                            ${
                                blog.id > 0
                                    ? `
                                    <form method='GET' action='editblog' class='edit-form'>
                                        <input type='hidden' name='slug' value='${blog.slug}' />
                                        <button type='submit' class='edit-button'><i class="fa-solid fa-pen-to-square"></i></button>
                                    </form>` 
                                    : ''
                            }
                            ${
                                blog.id > 0
                                    ? `
                                    <form method="POST" action="deletebloglogic.php" class="delete-form">
                                        <input type="hidden" name="delete-id" value="${blog.id}" />
                                        <button type="submit" class="delete-button"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>`
                                    : ''
                            }
                        </div>
                    </div>
                `;

                card.innerHTML = cardHTML;
                container.appendChild(card);
            });
        }

        // Add event listener for category selection
        document.addEventListener('DOMContentLoaded', () => {
            const categorySelect = document.getElementById('category');

            // Populate the dropdown with categories from PHP
            const categories = <?php echo json_encode($categories); ?>;

            // Clear the existing options in the select box
            categorySelect.innerHTML = '';

            // Add all categories (including "home" if it has blogs)
            categories.forEach((category) => {
                const option = document.createElement('option');
                option.value = category;
                option.textContent = category.charAt(0).toUpperCase() + category.slice(1); // Capitalize first letter
                categorySelect.appendChild(option);
            });

            // Set the default category to the first available category
            const defaultCategory = '<?php echo $defaultCategory; ?>';
            if (defaultCategory) {
                categorySelect.value = defaultCategory;
                fetchBlogs(defaultCategory); // Load blogs for the default category
            }

            // Listen for changes in the dropdown
            categorySelect.addEventListener('change', () => {
                const selectedCategory = categorySelect.value;
                fetchBlogs(selectedCategory);
            });
        });
    </script>
</head>

<body>
    <?php include "navbar.php"; ?>

    <div class="container">
        <main class="content">
            <!-- Category Selection (Dropdown Select Box) -->
            <div class="form-group">
                <label for="category">Filter</label>
                <select id="category" name="category" class="category">
                    <!-- Options will be populated dynamically -->
                </select>
                <div id="blog-container"></div>
            </div>
        </main>
    </div>
</body>

</html>