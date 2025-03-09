<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once "config.php";

$title = $content = "";
$title_err = $content_err = "";

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
    
    // Check input errors before inserting in database
    if (empty($title_err) && empty($content_err)) {
        $sql = "INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)";
        
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssi", $param_title, $param_content, $param_user_id);
            
            $param_title = $title;
            $param_content = $content;
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <div class="wrapper">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2><i class="fas fa-edit"></i> Create New Post</h2>
                </div>
                <div class="col-md-6 text-right">
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Posts
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper">
        <div class="form-container">
            <p class="mb-4">Share your thoughts with the world.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label><i class="fas fa-heading"></i> Title</label>
                    <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>" placeholder="Enter your post title">
                    <span class="invalid-feedback"><?php echo $title_err; ?></span>
                </div>    
                <div class="form-group">
                    <label><i class="fas fa-paragraph"></i> Content</label>
                    <textarea name="content" class="form-control <?php echo (!empty($content_err)) ? 'is-invalid' : ''; ?>" rows="10" placeholder="Write your post content here..."><?php echo $content; ?></textarea>
                    <span class="invalid-feedback"><?php echo $content_err; ?></span>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Publish Post
                    </button>
                    <a href="index.php" class="btn btn-secondary ml-2">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html> 