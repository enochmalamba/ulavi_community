<?php
session_start();
require_once 'includes/backend/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}
$stmt = $conn->prepare("SELECT username, email  FROM community_people WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $user_info = $result->fetch_assoc();
    $username = $user_info['username'];
    $email = $user_info['email'];

    //get the user bio , location, dob, user_title
    $stmt = $conn->prepare("SELECT bio, user_location, dob, user_title FROM user_profile WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user_info = $result->fetch_assoc();
        $bio = $user_info['bio'];
        $location = $user_info['user_location'];
        $dob = $user_info['dob'];
        $user_title = $user_info['user_title'];
    }
} else {
    header("Location: signin.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="includes/styles/main.css">
    <title>Account Settings</title>
</head>

<body>
    <div>
        <button onclick="showForm('profileForm')">Profile Settings</button>
        <button onclick="showForm('securityForm')">Security Settings</button>
    </div>

    <div id="profileForm" class="form-container">
        <h1>Profile Settings</h1>
        <form action="user.php" method="post">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $username; ?>">
            </div>

            <div>
                <label for="bio">Bio:</label>
                <textarea id="bio" name="bio" rows="4"><?php echo $bio; ?></textarea>
            </div>

            <div>
                <label for="profilePic">Profile Picture:</label>
                <input type="file" id="profilePic" name="profilePic" accept="image/*">

                <div id="imagePreviewContainer" style="display: none;">
                    <p>Preview:</p>
                    <img id="imagePreview" src="#" alt="Profile picture preview" style="max-width: 200px; max-height: 200px;">
                </div>
            </div>

            <button type="submit" name="update_profile">Update Profile</button>
          
        </form>
    </div>

    <div id="securityForm" class="form-container" style="display: none;">
        <h1>Security Settings</h1>
        <form>
            <div>
                <label for="email">New Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>">
            </div>

            <div>
                <label for="currentPassword">Current Password:</label>
                <input type="password" id="currentPassword" name="currentPassword">
            </div>

            <div>
                <label for="newPassword">New Password:</label>
                <input type="password" id="newPassword" name="newPassword">
            </div>

            <div>
                <label for="confirmPassword">Confirm New Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword">
            </div>

            <button type="submit">Update Security Settings</button>
        </form>
    </div>

    <script>
        // Function to show one form and hide the other
        function showForm(formId) {
            // Hide all forms
            document.querySelectorAll('.form-container').forEach(form => {
                form.style.display = 'none';
            });

            // Show the selected form
            document.getElementById(formId).style.display = 'block';
        }

        // Image preview functionality
        document.getElementById('profilePic').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');
            const previewContainer = document.getElementById('imagePreviewContainer');

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.style.display = 'block';
                }

                reader.readAsDataURL(file);
            } else {
                preview.src = "#";
                previewContainer.style.display = 'none';
            }
        });

        // Show profile form by default when page loads
        window.onload = function() {
            showForm('profileForm');
        };
    </script>
</body>

</html>