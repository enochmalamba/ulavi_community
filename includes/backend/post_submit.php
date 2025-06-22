<?php
session_start();
require_once 'config.php';
require_once 'functions.php';

if (isset($_POST['create_post'])) {
// Get the text for the post
$title = sanitize_input($_POST['title']);
$content = $_POST['content'];
$category = "Arts";

// Get the image file to upload if it has been uploaded
if (isset($_FILES['post_image']) && $_FILES['post_image']['error'] === UPLOAD_ERR_OK) {
$imageName = uniqid() . $_FILES['post_image']['name'];
$imageTempPath = $_FILES['post_image']['tmp_name'];

// Path two directories up
$baseDir = dirname(dirname(__DIR__)); // Goes two levels up
$targetDir = $baseDir . '/uploads/post-images/';
$imageSavePath = $targetDir . basename($imageName);

// Relative path for database storage (without the full server path)
$relativePath = 'uploads/post-images/' . basename($imageName);

// Check to see if the folder exists and if not create one
if (!is_dir($targetDir)) {
mkdir($targetDir, 0755, true);
}

// Moving the file into the folder
if (move_uploaded_file($imageTempPath, $imageSavePath)) {
$stmt = $conn->prepare("INSERT INTO posts (user_id, title, content, media_url, category) VALUES (?,?,?,?,?)");
$stmt->bind_param("issss", $_SESSION['user_id'], $title, $content, $relativePath, $category);
} else {
echo "<script>
alert('Failed to upload image, please try again.');
window.history.back();
</script>";
exit();
}
} else {
// Create an upload statement without the image if it has not been set
$stmt = $conn->prepare("INSERT INTO posts (user_id, title, content, category) VALUES (?,?,?,?)");
$stmt->bind_param("isss", $_SESSION['user_id'], $title, $content, $category);
}

if ($stmt->execute()) {
$last_id = $conn->insert_id;
header("Location: ../../post.php?post_id={$last_id}");
exit();
} else {
echo "<script>
alert('Error: " . addslashes($stmt->error) . "');
window.history.back();
</script>";
exit();
}
}