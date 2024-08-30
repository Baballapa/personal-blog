<?php
$pageTitle = "Tags Page";
require "inc/db_connect.inc.php";
require "inc/header.inc.php";
?>
<div class="container mt-3">
    <div class="row">
        <h2 class="mb-5">Tag Selection</h2>
        <?php
        // SQL to get all tags
        $sql = "SELECT id, tag FROM tag";

        // PDO Prepared Statements
        $stmt = $db->prepare($sql);
        $stmt->execute();

        // Fetch all of the rows as objects
        $tags = $stmt->fetchAll();

        // Iterate through each of the tags
        foreach ($tags as $tag) {
            // Create HTML for each tag card
            echo "<div class='col-12 col-md-4 mb-4'>";
            echo "<div class='card'>";
            // Assuming there's a default image for each tag (optional)
            echo "<div class='card-body'>";
            echo "<h3 class='card-title'><a href='tag.php?id={$tag->id}'>{$tag->tag}</a></h3>";
            echo "</div>";
            echo "</div>"; // closing card
            echo "</div>"; // closing col-12 col-md-4
        } // end of loop for tags
        ?>
    </div> <!-- Closing for .row -->
    <?php
    require "inc/footer.inc.php";
    ?>
</div> <!-- Closing for .container -->