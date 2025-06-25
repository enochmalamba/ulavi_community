<?php
 require_once("config.php");
 
if(isset($_POST['update_password'])){
   if($_POST['new_password'] == $_POST['confirm_password']){
       $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
       $stmt = $conn->prepare("UPDATE community_people SET password = ? WHERE user_id = ?");
       $stmt->bind_param("si", $new_password, $_SESSION['user_id']);
       $stmt->execute();
       $_SESSION['update_message'] = "Password updated successfully!";
} else {
    $_SESSION['update_message'] = "Passwords do not match!";
}
}
if(isset($_POST['update_email'])){
    $new_email = $_POST['new_email'];
    $stmt = $conn->prepare("UPDATE community_people SET email = ? WHERE user_id = ?");
    $stmt->bind_param("si", $new_email, $_SESSION['user_id']);
    $stmt->execute();
    $_SESSION['update_message'] = "Email updated successfully!";
} 