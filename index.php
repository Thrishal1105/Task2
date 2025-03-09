<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once "config.php";

// Delete post if requested
if (isset($_GET["delete"]) && !empty($_GET["delete"])) {
    $sql = "DELETE FROM posts WHERE id = ? AND user_id = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ii", $_GET["delete"], $_SESSION["id"]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <div class="wrapper">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h2>
                </div>
                <div class="col-md-6 text-right">
                    <a href="create_post.php" class="btn btn-success"><i class="fas fa-plus"></i> New Post</a>
                    <a href="logout.php" class="btn btn-danger ml-3"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper">
        <?php
        // Fetch all posts
        $sql = "SELECT p.*, u.username FROM posts p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="post">';
                echo '<h3>' . htmlspecialchars($row["title"]) . '</h3>';
                echo '<div class="post-content">' . nl2br(htmlspecialchars($row["content"])) . '</div>';
                echo '<div class="post-meta">Posted by <strong>' . htmlspecialchars($row["username"]) . '</strong> on ' . date('F j, Y, g:i a', strtotime($row["created_at"])) . '</div>';
                
                if ($row["user_id"] == $_SESSION["id"]) {
                    echo '<div class="post-actions">';
                    echo '<a href="edit_post.php?id=' . $row["id"] . '" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>';
                    echo '<a href="index.php?delete=' . $row["id"] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this post?\')"><i class="fas fa-trash"></i> Delete</a>';
                    echo '</div>';
                }
                echo '</div>';
            }
        } else {
            echo '<div class="text-center mt-5">';
            echo '<p class="h4 text-muted">No posts found.</p>';
            echo '<p class="mt-3"><a href="create_post.php" class="btn btn-primary">Create Your First Post</a></p>';
            echo '</div>';
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html> 