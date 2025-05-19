<?php
// Start the session
session_start();
include_once('includes/config.php');

if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);
}


// $user_id = $_SESSION['user_id'];
// $username = $_SESSION['username'];
// $email = $_SESSION['email'];
$username = "";
$email = "";
$user_role = "";
$bio = "";
$location = "";

//fetch user data from the community_people table
$stmt = $conn->prepare("SELECT username, email FROM community_people WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $user_info = $result->fetch_assoc();
    $username = $user_info['username'];
    $email = $user_info['email'];
}

//fetch profile data from the user_profile table
$stmt = $conn->prepare("SELECT bio, user_role, user_location, profile_photo FROM user_profile WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user_info = $result->fetch_assoc();
    $user_role = $user_info['user_role'];
    $bio = $user_info['bio'];
    $location = $user_info['user_location'];
    $profilePhoto = $user_info['profile_photo'];
    //get user title/proffession
    $titleStml = $conn->prepare("SELECT user_title FROM user_profile WHERE user_id = ?");
    $titleStml->bind_param("i", $user_id);
    $titleStml->execute();
    $titleResult = $titleStml->get_result();
    $title = $titleResult->fetch_assoc()['user_title'];
} else {
    $user_role = "Unverified";
    $bio = "No bio yet";
    $location = "No location yet";
    $profilePhoto = "default.jpg";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material%20Symbols%20Outlined" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="includes/styles/main.css">
    <link rel="stylesheet" href="includes/styles/home.css">
    <link rel="stylesheet" href="includes/styles/profile.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($username); ?> &bull; ULAVi Community</title>
</head>

<body>
    <main>
        <div class="overlay" id="overlay"></div>
        <div class="header">
            <a href="home.php" class="title sml logo"> <i class='bx bxs-palette'></i> <span>ulavi <br> community</span></a>
            <h2 class="current-page title sml "><?php echo htmlspecialchars($username); ?> &bull; Profile</h2>
            <form class="search-bar">
                <input type="text" name="query" placeholder="Search..">
                <button type="submit"><i class='bx bx-search'></i></button>
            </form>
        </div>
        <div class="container">
            <nav class="navigation">
                <ul class="page-nav">
                    <li><a href="home.php"><i class='bx bxs-home-alt-2'></i>Home</a></li>
                    <li><a href=""><i class='bx bx-group'></i>Community</a></li>
                    <li><a href="create_post.php" class="post-link"><i class='bx bx-border-circle bx-plus'></i>Post</a></li>
                    <li><a href=""><i class='material-symbols-outlined'>person_play</i>Local talents</a></li>
                    <li><a href=""><i class='bx bx-menu-alt-left'></i>More</a></li>
                </ul>
                <ul class="user-nav">
                    <li><a href=""><i class="bx bx-sun"></i>Light mode</a></li>
                    <li><a href=""><i class='bx bx-log-out'></i>Log out</a></li>

                    <li><a href="user/user.php"><i class='bx bx-user'></i>Profile</a></li>
                </ul>
            </nav>
            <div class="feed">
                <div class="profile-view">
                    <div class="profile-header">
                        <img src="<?php echo htmlspecialchars($profilePhoto); ?>" alt="<?php echo htmlspecialchars($username); ?>" class="profile-img">
                        <div class="profile-details">
                            <h3 class="title sml"><?php echo htmlspecialchars($username); ?></h3>
                            <p><?php echo htmlspecialchars($title); ?></p>
                            <div class="user-counts">
                                <div class="count-card">
                                    <h4>57</h4>
                                    <p>Posts</p>
                                </div>
                                <div class="count-card">
                                    <h4>133K</h4>
                                    <p>Followers </p>
                                </div>
                                <div class="count-card">
                                    <h4>Gold Tier</h4>
                                    <p>Membership </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="bio"><?php echo htmlspecialchars($bio); ?></p>
                </div>
                <div class="user-posts">

                    <!-- <div class="post">
                        <div class="post-header">
                            <div class="post-details">
                                <div class="img"></div>

                                <div class="post-author">
                                    <h4 class="pa-name"><?php echo htmlspecialchars($postAuthor['username']); ?> </h4>
                                    <small><?php echo htmlspecialchars($postAuthorInfo['user_role']); ?> &bull; <?php echo htmlspecialchars($post['created_at']); ?></small>
                                </div>

                            </div>
                            <div class="post-category">
                                <a href=""><span class="material-symbols-outlined"><?php echo htmlspecialchars($categoryIcon); ?></span> <?php echo htmlspecialchars($category); ?></a>
                            </div>
                        </div>
                        <h3 class="post-title title sml"><?php echo htmlspecialchars($post['title']); ?></h3>

                        <p class="post-content">
                            <?php echo nl2br(htmlspecialchars($post['content'])); ?>
                        </p>

                        <?php if (!empty($post['media_url'])): ?>
                            <div class="post-image">
                                <img src="<?php echo htmlspecialchars($post['media_url']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                            </div>
                        <?php endif; ?>

                        <div class="post-interactions">
                            <ul>
                                <li>
                                    <span class="material-symbols-outlined"> sign_language</span>
                                </li>
                                <li>
                                    <span class="material-symbols-outlined"> favorite</span>

                                </li>
                                <li>
                                    <span class="material-symbols-outlined"> forum</span>

                                </li>
                                <li>
                                    <span class="material-symbols-outlined"> send</span>

                                </li>
                            </ul>

                        </div>
                    </div> -->

                    <div class="no-posts">
                        <img src="no-posts.png" alt="<?php echo htmlspecialchars($username); ?> has no posts, please check back later">#
                        <p><?php echo htmlspecialchars($username); ?> has no posts, please check back later</p>

                    </div>
                </div>
            </div>
            <div class="right-sidebar">
                <div class="card">
                    <h2 class="title sml"><span class="material-symbols-outlined">
                            mode_heat
                        </span>Today's top artist</h2>
                    <h4>OG Stakks</h4>
                    <img src="stakks.jpg" alt="">
                </div>
                <div class="card">
                    <h2 class="title sml" style="font-size: 15px;"><span class="material-symbols-outlined" style="font-size: 20px;">
                            ad
                        </span>Ad</h2>
                    <img src="ad.jpeg" alt="">
                </div>
            </div>
        </div>
    </main>

</body>

</html>