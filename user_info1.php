<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: signup.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="includes/styles/main.css">
    <link rel="stylesheet" href="includes/styles/user_info.css">
    <title>Account Registration</title>
</head>

<body>
    <form action="includes/backend/user_info_submit.php" method="POST" enctype="multipart/form-data" class="form">
        <div class="info">
            <h2 class="title">Tell us a bit about you!</h2>
            <p>Let's get to know you better so we can make your experience super awesome!</p>
        </div>
        <div class="inputs">
            <label for="birthday">When where you born?🎂</label>
            <input type="date" name="birthday" require>
            <label for="location">Where are you from? 🌍</label>
            <input type="text" name="location" placeholder="Are you from Blantre, Lilongwe, etc?" required>
            <label for="gender">What is your gender? 💫</label>
            <select name="gender" id="gender" required>
                <option disabled selected value>--Select your identity--</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
                <option value="prefer_not_to_say">Prefer not to say</option>
            </select>
            <button type="submit" name="enter_user_data1">Next Step → Let's create your profile</button>

        </div>
    </form>
</body>

</html>