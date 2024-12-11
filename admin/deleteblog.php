<?php
include_once "session.php";
check_login();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Management</title>
    <link rel="stylesheet" href="assets/css/deleteblog.css">
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



        function renderBlogs(blogs) {
            const container = document.getElementById('blog-container');
            container.innerHTML = ''; // Clear existing content

            if (blogs.length === 0) {
                container.innerHTML = '<p>No blogs found for this category.</p>';
                return;
            }

            // Create a table element
            const table = document.createElement('table');
            table.className = 'blog-table';

            // Create the table header
            table.innerHTML = `
        <thead>
            <tr>
                <th>No.</th>
                <th>Title</th>
                <th>Category</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    `;

            const tbody = table.querySelector('tbody');

            // Append each blog as a row inside the table body
            blogs.forEach((blog, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
            <td>${index + 1}</td>
            <td>${blog.slug}</td>
            <td>${blog.category}</td>
            <td>
                <form method="POST" action="deletebloglogic.php" class="delete-form">
                    <input type="hidden" name="delete-id" value="${blog.id}">
                    <button type="submit" class="delete-button">Delete</button>
                </form>
            </td>
        `;
                tbody.appendChild(row);
            });

            // Append the table to the container
            container.appendChild(table);
        }


        // Event listener for category selection
        document.addEventListener('DOMContentLoaded', () => {
            const categorySelect = document.getElementById('category');

            // Fetch blogs for the default "blog" category on load
            fetchBlogs('blog');

            // Fetch blogs for the selected category on change
            categorySelect.addEventListener('change', () => {
                const selectedCategory = categorySelect.value;
                fetchBlogs(selectedCategory);
            });
        });
    </script>
</head>

<body>
    <?php include "navbar.php"; ?>

    <!-- Blog Pages -->
    <div class="wrapper">
        <div class="child child1">


            <?php include "sidebar.php"; ?>

        </div>

        <div class="child child2">
            <div class="form-group">
                <label for="category">Choose Category:-</label>
                <select id="category" name="category" class="category">
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

                <!-- Blog Content -->
                <div id="blog-container"></div>
            </div>

        </div>
    </div>


</body>

</html>