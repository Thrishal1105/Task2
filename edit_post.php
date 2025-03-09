<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once "config.php";

$title = $content = "";
$title_err = $content_err = "";

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = trim($_GET["id"]);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate title
        if (empty(trim($_POST["title"]))) {
            $title_err = "Please enter a title.";
        } else {
            $title = trim($_POST["title"]);
        }
        
        // Validate content
        if (empty(trim($_POST["content"]))) {
            $content_err = "Please enter some content.";
        } else {
            $content = trim($_POST["content"]);
        }
        
        // Check input errors before updating the database
        if (empty($title_err) && empty($content_err)) {
            $sql = "UPDATE posts SET title = ?, content = ? WHERE id = ? AND user_id = ?";
            
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssii", $param_title, $param_content, $param_id, $param_user_id);
                
                $param_title = $title;
                $param_content = $content;
                $param_id = $id;
                $param_user_id = $_SESSION["id"];
                
                if (mysqli_stmt_execute($stmt)) {
                    header("location: index.php");
                    exit();
                } else {
                    echo "Something went wrong. Please try again later.";
                }

                mysqli_stmt_close($stmt);
            }
        }
    } else {
        // Get post data
        $sql = "SELECT title, content FROM posts WHERE id = ? AND user_id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "ii", $param_id, $param_user_id);
            
            $param_id = $id;
            $param_user_id = $_SESSION["id"];
            
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $title, $content);
                    mysqli_stmt_fetch($stmt);
                } else {
                    header("location: error.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
} else {
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { font: 14px sans-serif; }
        .wrapper { width: 800px; padding: 20px; margin: 0 auto; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Edit Post</h2>
        <p>Please edit the input values and submit to update the post.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id); ?>" method="post">
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
                <span class="invalid-feedback"><?php echo $title_err; ?></span>
            </div>
            <div class="form-group">
                <label>Content</label>
                <textarea name="content" class="form-control <?php echo (!empty($content_err)) ? 'is-invalid' : ''; ?>" rows="10"><?php echo $content; ?></textarea>
                <span class="invalid-feedback"><?php echo $content_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
            </div>
        </form>
    </div>    
</body>
</html> 