<?php
session_start();
include_once('config.php');

if (isset($_POST['signup'])) {
    $username = trim($_POST['username']);
    $email = strtolower(trim($_POST['email'])); // Normalize email
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email exists (case-insensitive)
    $check_stmt = $conn->prepare("SELECT user_id, email FROM community_people WHERE LOWER(email) = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        error_log("Registration attempt with existing email: " . $row['email']);
        $_SESSION['email_error'] = "Email is already registered, please use a different one";
        header("Location: ../../signup.php");
        exit();
    } else {
        $stmt = $conn->prepare("INSERT INTO community_people (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        $stmt->execute();

        $last_id = $conn->insert_id;

        //fetch user data using the $last id so that we can use that for the session
        $stmt = $conn->prepare("SELECT * FROM community_people WHERE user_id = ?");
        $stmt->bind_param("i", $last_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $current_user = $result->fetch_assoc();
            $_SESSION['user_id'] = $current_user['user_id'];
            $_SESSION['username'] = $current_user['username'];
            $_SESSION['email'] = $current_user['email'];

             //populate the user_profile with default data
       $role = "Public User";
$title = "Unknown";
$dob = "Unknown";
$gender = "Unknown";
$location = "Unknown";
$photo = "https://i.pinimg.com/736x/ae/25/58/ae25588122b4e9efaf260c6e1ea84641.jpg";
$bio = "Hey there, I'm a member of the ULAVi Community!";

$profileStmt = $conn->prepare("INSERT INTO user_profile (user_id, user_role, user_title, dob, gender, user_location, profile_photo, bio) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$profileStmt->bind_param("isssssss", $last_id, $role, $title, $dob, $gender, $location, $photo, $bio);
$profileStmt->execute();

        $profileStmt->close();
        //get profile
                get_profile();
        }


        $stmt->close();
        unset($_SESSION['email_error']);
        $_SESSION['account-success'] = 'Account created successfuly!';
        header("Location: ../../user_info1.php");
        exit();
    }
}


if (isset($_POST['signin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (empty($password) || empty($email)) {
        $_SESSION['signin_error'] = "Please fill in all fields";
    } else {
        $sql = "SELECT * FROM community_people WHERE email = '$email' ";
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0) {
            $userdata = $result->fetch_assoc();

            if (password_verify($password, $userdata['password'])) {
                $_SESSION['user_id'] = $userdata['user_id'];
                $_SESSION['username'] = $userdata['username'];
                $_SESSION['email'] = $userdata['email'];

                //get profile
                get_profile();

                unset($_SESSION['signin_error']);
                header("Location: ../../home.php");
                exit();
            } else {
                $_SESSION['signin_error'] = "Invalid password";
                header("Location: ../../signin.php");
            }
        } else {
            $_SESSION['signin_error'] = "Email not found";
            header("Location: ../../signin.php");
        }
    }
}

function get_profile(){
    global $conn; 
    $stmt = $conn->prepare("SELECT user_role, user_title, dob, gender, user_location, profile_photo, bio FROM user_profile WHERE user_id = ?");
    $stmt->bind_param('i', $_SESSION['user_id']);
    if ($stmt->execute()){
        $profileResult = $stmt->get_result();
        if($profileResult->num_rows === 1){
            $profileData = $profileResult->fetch_assoc();
            $_SESSION['role'] = $profileData['user_role'];
            $_SESSION['title'] = $profileData['user_title'];
            $_SESSION['dob'] = $profileData['dob'];
            $_SESSION['gender'] = $profileData['gender'];
            $_SESSION['location'] = $profileData['user_location'];
            $_SESSION['profile_photo'] = $profileData['profile_photo'];
            $_SESSION['bio'] = $profileData['bio'];
        }
    } else {
        error_log("get_profile error: " . $stmt->error); // Optional: log error
    }
}


if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../../signin.php");
    exit();
}