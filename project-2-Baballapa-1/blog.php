<?php
// Set the page title to "Blog Home"
$pageTitle = "Blog Home";

// Include the database connection script
require "inc/db_connect.inc.php";

// Include the header script
require "inc/header.inc.php";

// Function to display a blog post
function display_blog_post($post, $db)
{
    // Output the blog entry container
    echo "<div class='col-12 blog-entry'>";
    // Output the blog post title
    echo "<h2 class='blog-title'>{$post->title}</h2>";
    echo "<hr>";

    // Convert the date to a PHP date object
    $date = date_create($post->date);
    // Output the author name and post date
    echo "<p class='upload-info'>{$post->first_name} {$post->last_name} - " . $date->format('M d, Y') . "</p>";

    // SQL query to get the categories for the current post
    $sql = "SELECT category.category, category.category_id 
            FROM post_category 
            JOIN category ON post_category.category_id = category.category_id 
            WHERE post_category.post_id = :post_id 
            ORDER BY category.category";
    // Prepare the SQL statement
    $stmt_category = $db->prepare($sql);
    // Execute the statement with the post ID parameter
    $stmt_category->execute(["post_id" => $post->post_id]);
    // Fetch all categories as objects
    $categories = $stmt_category->fetchAll();

    // If there are categories, output them
    if (count($categories) > 0) {
        $categoryList = [];
        // Iterate through each category and create a link
        foreach ($categories as $category) {
            $categoryList[] = "<a href='category.php?id={$category->category_id}&category_name={$category->category}'>{$category->category}</a>";
        }
        // Join the category links with a comma
        $categoryText = join(", ", $categoryList);
        // Output the categories
        echo "<p>" . (count($categoryList) > 1 ? "Categories" : "Category") . ": {$categoryText}</p>";
    }

    // SQL query to get the tags for the current post
    $sql = "SELECT tag.tag, tag.id 
            FROM post_tag 
            JOIN tag ON post_tag.tag_id = tag.id 
            WHERE post_tag.post_id = :post_id 
            ORDER BY tag.tag";
    // Prepare the SQL statement
    $stmt_tag = $db->prepare($sql);
    // Execute the statement with the post ID parameter
    $stmt_tag->execute(["post_id" => $post->post_id]);
    // Fetch all tags as objects
    $tags = $stmt_tag->fetchAll();

    // If there are tags, output them
    if (count($tags) > 0) {
        $tagList = [];
        // Iterate through each tag and create a link
        foreach ($tags as $tag) {
            $tagList[] = "<a href='tag.php?id={$tag->id}&tag_name={$tag->tag}'>{$tag->tag}</a>";
        }
        // Join the tag links with a comma
        $tagText = join(", ", $tagList);
        // Output the tags
        echo "<p>" . (count($tagList) > 1 ? "Tags" : "Tag") . ": {$tagText}</p>";
    }

    // Limit the blog post content to a certain number of words
    $content = limit_text($post->content, 50);
    // Output the blog post content
    echo "<p class='blog-content'>{$content}</p>";
    // Output a link to read the full post
    echo "<a class='text-decoration-underline' href='single.php?id={$post->post_id}' title='Read the post'>Read more ></a>";
    // Close the blog entry container
    echo "</div>";
}

// SQL query to get all blog posts with their authors
$sql = "SELECT post.post_id, post.title, post.date, post.content, author.first_name, author.last_name 
        FROM post 
        JOIN author ON post.author = author.author_id";

// Prepare the SQL statement
$stmt = $db->prepare($sql);
// Execute the statement with filter parameters
$stmt->execute();

// Fetch all posts as objects
$posts = $stmt->fetchAll();

?>
<div class="container">
    <div class="row">
        <!-- Output the blog header -->
        <h1 class="mb-5">Martin's Understanding Blog</h1>
        <?php
        // Iterate through each post and display it
        foreach ($posts as $post) {
            display_blog_post($post, $db);
        }
        ?>
    </div> <!-- Closing for .row -->
</div> <!-- Closing for .container -->

<?php
// Include the footer script
require "inc/footer.inc.php";
?>