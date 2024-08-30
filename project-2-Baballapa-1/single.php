<?php
$pageTitle = "Single Page";

require "inc/header.inc.php";
require "inc/db_connect.inc.php";

if (!isset($_GET['id'])) {
    header("Location: blog.php");
    exit(); // Add exit after redirection
} else {
    $blog_id = $_GET['id'];
}

?>
<link rel="stylesheet" href="css/style.css">
<div class="container border">
    <div class="row">
        <div class="col-12">
            <?php
            // SQL to get a single blog post. Note the use of a JOIN
            $sql = "SELECT post.post_id, post.title, post.date, post.content, author.author_id, author.first_name, author.last_name 
                FROM post 
                JOIN author 
                ON post.author = author.author_id 
                WHERE post.post_id = :blog_id";

            // PDO Prepared Statements
            $stmt = $db->prepare($sql);
            $stmt->execute(["blog_id" => $blog_id]);

            // Fetch one row
            $row = $stmt->fetch();

            // Blog Title
            echo "<h2>{$row->title}</h2>";
            echo "<hr>";

            // Take the date and convert it to a PHP date object
            $date = date_create($row->date);
            // Show blog post author and format the date
            echo "<p class='fw-bold'>{$row->first_name} {$row->last_name} - " . $date->format('M d, Y')  . "</p>";

            // Now get the categories for this post with SQL JOIN
            $sql = "SELECT post_category.post_id, post_category.category_id, category.category 
                FROM post_category 
                JOIN category 
                ON post_category.category_id = category.category_id 
                WHERE post_category.post_id = :post_id";

            // PDO Prepared statements
            $stmt_category = $db->prepare($sql);
            $stmt_category->execute(["post_id" => $row->post_id]);
            $categories = $stmt_category->fetchAll();

            // Generate comma-separated categories with links
            if (count($categories) > 0) {
                $categoryList = [];
                foreach ($categories as $category_row) {
                    $categoryList[] = "<a href='category.php?id={$category_row->category_id}&category_name={$category_row->category}'>{$category_row->category}</a>";
                }
                $categoryText = join(", ", $categoryList);
                echo "<p>" . (count($categoryList) > 1 ? "Categories" : "Category") . ": {$categoryText}</p>";
            }

            // Now get the tags for this post with SQL JOIN
            $sql = "SELECT post_tag.post_id, post_tag.tag_id, tag.id, tag.tag 
                FROM post_tag 
                JOIN tag 
                ON post_tag.tag_id = tag.id 
                WHERE post_tag.post_id = :post_id";

            // PDO Prepared statements
            $stmt_tag = $db->prepare($sql);
            $stmt_tag->execute(["post_id" => $row->post_id]);
            $tags = $stmt_tag->fetchAll();

            // Generate comma-separated tags with links
            if (count($tags) > 0) {
                $tagList = [];
                foreach ($tags as $tag_row) {
                    $tagList[] = "<a href='tag.php?id={$tag_row->tag_id}&tag_name={$tag_row->tag}'>{$tag_row->tag}</a>";
                }

                $tagText = join(", ", $tagList);
                echo "<p>" . (count($tagList) > 1 ? "Tags" : "Tag") . ": {$tagText}</p>";
            }

            // Show the blog post content
            echo "<p class='mb-3'>{$row->content}</p>";
            ?>
        </div>
    </div>
    <?php
    require "inc/footer.inc.php";
    ?>
</div>