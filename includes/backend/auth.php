<?php
session_start();
include_once('config.php');

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check_mail = "SELECT * FROM community_people WHERE email = '$email'";
    $result = mysqli_query($conn, $check_mail);
    if ($result->num_rows > 0) {

        $_SESSION['email_error'] = "Email is taken, please use a different one";
        header("Location: signup.php");
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
        }

        $stmt->close();
        unset($_SESSION['email_error']);
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
