<?php
$pageTitle = "Tagged Posts";
require "inc/db_connect.inc.php";
require "inc/header.inc.php";

// Function to display a blog post
function display_blog_post($post, $conn)
{
    echo "<div class='col-12 blog-entry'>";
    echo "<h2 class='blog-title'>{$post->title}</h2>";
    echo "<hr>";

    // Convert the date to a PHP date object
    $date = date_create($post->date);
    echo "<p class='upload-info'>{$post->first_name} {$post->last_name} - " . $date->format('M d, Y') . "</p>";

    // Get the categories for this post
    $sql = "SELECT category.category, category.category_id 
            FROM post_category 
            JOIN category ON post_category.category_id = category.category_id 
            WHERE post_category.post_id = ?";
    $stmt_category = $conn->prepare($sql);
    $stmt_category->bind_param("i", $post->post_id);
    $stmt_category->execute();
    $result_category = $stmt_category->get_result();

    $categoryList = [];
    while ($category = $result_category->fetch_object()) {
        $categoryList[] = "<a href='category.php?id={$category->category_id}&category_name={$category->category}'>{$category->category}</a>";
    }

    $categoryText = join(", ", $categoryList);
    echo "<p>" . (count($categoryList) > 1 ? "Categories" : "Category") . ": {$categoryText}</p>";

    // Get the tags for this post
    $sql = "SELECT tag.tag, tag.id 
            FROM post_tag 
            JOIN tag ON post_tag.tag_id = tag.id 
            WHERE post_tag.post_id = ?";
    $stmt_tag = $conn->prepare($sql);
    $stmt_tag->bind_param("i", $post->post_id);
    $stmt_tag->execute();
    $result_tag = $stmt_tag->get_result();

    $tagList = [];
    while ($tag = $result_tag->fetch_object()) {
        $tagList[] = "<a href='tag.php?id={$tag->id}&tag_name={$tag->tag}'>{$tag->tag}</a>";
    }

    $tagText = join(", ", $tagList);
    echo "<p>" . (count($tagList) > 1 ? "Tags" : "Tag") . ": {$tagText}</p>";

    // Show the blog post content with a limit
    $content = limit_text($post->content, 50);
    echo "<p class='blog-content'>{$content}</p>";
    echo "<a href='single.php?id={$post->post_id}' title='Read the post'>Read more ></a>";
    echo "</div>"; // closing .col-12
}
?>
<link rel="stylesheet" href="css/style.css">
<div class="container mt-3">
    <div class="row">
        <h1 class="mb-5">Posts Tagged:</h1>
        <?php
        // Ensure tag_id is set
        if (isset($_GET['id'])) {
            $tagId = $_GET['id'];

            // Create connection
            $conn = new mysqli($host, $user, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // SQL to get blog posts with the specified tag
            $sql = "SELECT post.post_id, post.title, post.date, post.content, author.first_name, author.last_name 
                    FROM post 
                    JOIN author ON post.author = author.author_id
                    JOIN post_tag ON post.post_id = post_tag.post_id
                    WHERE post_tag.tag_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $tagId);
            $stmt->execute();
            $result = $stmt->get_result();

            // Iterate through each of the rows
            while ($post = $result->fetch_object()) {
                display_blog_post($post, $conn);
            }

            $conn->close();
        } else {
            echo "<p>No tag specified.</p>";
        }
        ?>
    </div> <!-- Closing for .row -->
</div> <!-- Closing for .container -->

<?php
require "inc/footer.inc.php";
?>