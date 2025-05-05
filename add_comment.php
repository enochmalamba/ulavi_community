<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/sanitize.php';

if (isset($_POST['submit_comment'])) {
    $comment = sanitize_input($_POST['comment']);
    $postID = intval($_POST['postID']);
    $userID = intval($_SESSION['user_id']);
    $commentStmt = $conn->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?) ");
    $commentStmt->bind_param("iis", $postID, $userID, $comment);
    if ($commentStmt->execute()) {
        echo "<script>
                window.location.href = 'view_post.php?post_id=" . $postID . "';
            </script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
