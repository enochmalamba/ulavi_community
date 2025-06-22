<?php
session_start();
require_once('config.php');
require_once('functions.php');


$user_id = $_SESSION['user_id'];

if (isset($_POST['enter_user_data1'])) {
    $dob = $_POST['birthday'];
    $location = sanitize_input($_POST['location']);
    $gender = $_POST['gender'];
    $stmt = $conn->prepare("INSERT INTO user_profile (user_id, dob, user_location, gender) VALUES (?,?,?,?)");
    $stmt->bind_param("isss", $user_id, $dob, $location, $gender);
    if ($stmt->execute()) {
        $_SESSION['data_submit_msg'] = "Data submitted successfully!";
        header("Location: ../../user_info2.php");
    }
}

if (isset($_POST['enter_user_data2'])) {
    $title = sanitize_input($_POST['title']);
    $bio = sanitize_input($_POST['bio']);
    $imgName = uniqid() . basename($_FILES['profile_photo']['name']);
    
    // Go up 2 levels from current script to get project root
    $uploadDir = dirname(__DIR__, 2) . "/uploads/profiles/";
    $imgSavePath = $uploadDir . $imgName;

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0775, true);
    }

    if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $imgSavePath)) {
        $relativeImgPath = "uploads/profiles/" . $imgName; // for storing in DB

        $stmt = $conn->prepare("UPDATE user_profile SET profile_photo = ?, user_title = ?, bio = ? WHERE user_id = ?");
        $stmt->bind_param("sssi", $relativeImgPath, $title, $bio, $user_id);

        if ($stmt->execute()) {
            unset($_SESSION['data_submit_msg']);
            header("Location: ../../home.php");
            exit;
        }
    }
}