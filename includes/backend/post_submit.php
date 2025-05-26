<?php
session_start();
require_once 'includes/backend/config.php';
require_once 'includes/backend/functions.php';

if (isset($_POST['create_post'])) {
    //geting the text for the post
    $title = sanitize_input($_POST['title']);
    $content = $_POST['content'];
    $category = "Arts";




    //get the image file to upload if it has been uploaded
    if (isset($_FILES['post_image']) && $_FILES['post_image']['error'] === UPLOAD_ERR_OK) {
        $imageName = uniqid() . $_FILES['post_image']['name'];
        $imageTempPath = $_FILES['post_image']['tmp_name'];
        $imageSavePath = "uploads/post-images/" . basename($imageName);

        //check to see if the folder exists and if not create one
        if (!is_dir("uploads/post-images")) {
            mkdir('uploads/post-images', 0755, true);
        }

        //moving the file into the folder
        if (move_uploaded_file($imageTempPath, $imageSavePath)) {
            $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content, media_url, category) VALUES (?,?,?,?,?)");
            $stmt->bind_param("issss", $_SESSION['user_id'], $title, $content, $imageSavePath, $category);
        } else {
            echo "<script>alert ('failed to upload image, please try again.')</script>";
            exit();
        }
    }

    //craete an upload statement without the image if it has not been set 
    else {
        $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content,  category) VALUES (?,?,?,?)");
        $stmt->bind_param("isss",  $_SESSION['user_id'], $title, $content, $category);
    }

    if ($stmt->execute()) {
        $last_id = $conn->insert_id;
        header("Location: post.php?post_id={$last_id}");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
