<?php
$pageTitle = "Categories Page";
require "inc/db_connect.inc.php";
require "inc/header.inc.php";
?>

<div class="container mt-3">
    <div class="row">
        <h2 class="mb-5">Categories List</h2>
        <?php
        // SQL to get all categories
        $sql = "SELECT category_id, category FROM category";

        // PDO Prepared Statements
        $stmt = $db->prepare($sql);
        $stmt->execute();

        // Fetch all of the rows as objects
        $categories = $stmt->fetchAll();

        // Iterate through each of the categories
        foreach ($categories as $category) {
            // Create HTML for each category card
            echo "<div class='col-12 col-md-6 mb-4'>";
            echo "<div class='card'>";
            // Assuming there's a default image for each category
            echo "<div class='card-body'>";
            // Modified link generation for category.php
            echo "<h3 class='card-title'><a href='category.php?id={$category->category_id}&category_name={$category->category}'>{$category->category}</a></h3>";
            echo "</div>";
            echo "</div>"; // closing card
            echo "</div>"; // closing col-12 col-md-4
        } // end of loop for categories
        ?>
    </div> <!-- Closing for .row -->
    <?php
    require "inc/footer.inc.php";
    ?>
</div> <!-- Closing for .container -->