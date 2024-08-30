<?php
$pageTitle = "Category Posts";
require "inc/db_connect.inc.php";
require "inc/header.inc.php";

// Function to display a blog post
function display_blog_post($post, $db)
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
            WHERE post_category.post_id = :post_id 
            ORDER BY category.category";
    $stmt_category = $db->prepare($sql);
    $stmt_category->execute(["post_id" => $post->post_id]);
    $categories = $stmt_category->fetchAll();

    if (count($categories) > 0) {
        $categoryList = [];
        foreach ($categories as $category) {
            $categoryList[] = "<a href='category.php?id={$category->category_id}&category_name={$category->category}'>{$category->category}</a>";
        }
        $categoryText = join(", ", $categoryList);
        echo "<p>" . (count($categoryList) > 1 ? "Categories" : "Category") . ": {$categoryText}</p>";
    }

    // Get the tags for this post
    $sql = "SELECT tag.tag, tag.id 
            FROM post_tag 
            JOIN tag ON post_tag.tag_id = tag.id 
            WHERE post_tag.post_id = :post_id 
            ORDER BY tag.tag";
    $stmt_tag = $db->prepare($sql);
    $stmt_tag->execute(["post_id" => $post->post_id]);
    $tags = $stmt_tag->fetchAll();

    if (count($tags) > 0) {
        $tagList = [];
        foreach ($tags as $tag) {
            $tagList[] = "<a href='tag.php?id={$tag->id}&tag_name={$tag->tag}'>{$tag->tag}</a>";
        }
        $tagText = join(", ", $tagList);
        echo "<p>" . (count($tagList) > 1 ? "Tags" : "Tag") . ": {$tagText}</p>";
    }

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
        <h1 class="mb-5">Posts in Category: <?php echo htmlspecialchars($_GET['category_name']); ?></h1>
        <?php
        // Ensure category_id is set
        if (isset($_GET['id'])) {
            $categoryId = $_GET['id'];

            // SQL to get blog posts with the specified category
            $sql = "SELECT post.post_id, post.title, post.date, post.content, author.first_name, author.last_name 
                    FROM post 
                    JOIN author ON post.author = author.author_id
                    JOIN post_category ON post.post_id = post_category.post_id
                    WHERE post_category.category_id = :category_id";

            // PDO Prepared Statements
            $stmt = $db->prepare($sql);
            $stmt->execute(['category_id' => $categoryId]);

            // Fetch all of the rows as objects
            $posts = $stmt->fetchAll();

            // Iterate through each of the rows
            foreach ($posts as $post) {
                display_blog_post($post, $db);
            } // end of loop for Posts
        } else {
            echo "<p>No category specified.</p>";
        }
        ?>
    </div> <!-- Closing for .row -->
</div> <!-- Closing for .container -->

<?php
require "inc/footer.inc.php";
?>