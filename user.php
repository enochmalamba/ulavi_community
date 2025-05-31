<?php
session_start();
//check if logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
}
require 'includes/backend/fetch_data.php';
$userPosts = array();
foreach ($postsArray as $post) {
    if ($post['author']['id'] == $_SESSION['user_id']) {
        $userPosts[] = $post;
    }
}
//fake profile pic for now
$profilePic = "https://i.pinimg.com/736x/ae/25/58/ae25588122b4e9efaf260c6e1ea84641.jpg";

//varibles for page to show below profile
if (isset($_GET['page'])) {
    $currentPage = $_GET['page'];
} 

?>
<script>
let currentPage = <?php echo json_encode($currentPage); ?>;
</script>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material%20Symbols%20Outlined" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="includes/styles/main.css">
    <link rel="stylesheet" href="includes/styles/home.css">
    <link rel="stylesheet" href="includes/styles/user.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($_SESSION['username']) ?> | Profile</title>
</head>

<body>
    <main>
        <div class="overlay" id="overlay"></div>
        <div class="modal-container" id="modal-container"></div>

        <div class="header">
            <a href="home.php" class="title sml logo"> <i class='bx bxs-palette'></i> <span>ulavi <br>
                    community</span></a>
            <form class="search-bar">
                <input type="text" name="query" placeholder="Search..">
                <button type="submit"><i class='bx bx-search'></i></button>
            </form>
            <div class="mobile-nav">
                <span><i class='bx bx-search'></i></span>
                <span class="light-mode"><i class="bx bx-sun"></i></span>
                <span class="dark-mode"><i class="bx bx-moon"></i></span>
                <a href="user.php"><i class="bx bx-user"></i></a>

            </div>
        </div>
        <div class="container">
            <nav class="navigation">
                <ul class="page-nav">
                    <li><a href="home.php"><i class='bx bxs-home-alt-2'></i>
                            <div>Home</div>
                        </a></li>
                    <li><a href=""><i class='bx bx-group'></i>
                            <div>Community</div>
                        </a></li>
                    <li id="create-post-btn">
                        <span class="nav-btn"> <i class='bx bx-border-circle bx-plus'></i>
                            <div>Post</div>
                        </span>
                    </li>
                    <li><a href=""><i class='material-symbols-outlined'>person_play</i>
                            <div>Local talents</div>
                        </a></li>
                    <li id="menu-btn"><span class="nav-btn"><i class='bx bx-menu'></i>
                            <div>More</div>
                        </span></li>
                </ul>
                <ul class="user-nav">
                    <li>
                        <span class="nav-btn light-mode"><i class="bx bx-sun"></i>Light mode</span>
                        <span class="nav-btn dark-mode"><i class="bx bx-moon"></i>Dark mode</span>
                    </li>
                    <li id="logout-btn"><span class="nav-btn"><i class='bx bx-log-out'></i>Log out</span></li>

                    <li><a href="user.php" class="active"><i
                                class='bx bx-user'></i><?php echo htmlspecialchars($_SESSION['username']) ?></a></li>
                </ul>
                </ul>
            </nav>
            <div class="feed">
                <div class="profile">
                    <!-- <button> <i class='bx  bx-edit'></i>Edit profile</button> -->
                    <div class="profile-top">
                        <img src="<?php echo $profilePic ?>"
                            alt="<?php echo htmlspecialchars($_SESSION['username']) ?>">
                        <div>
                            <h4> <?php echo htmlspecialchars($_SESSION['username']) ?> </h4>
                            <p>Web Developer </p>
                            <p> <?php echo htmlspecialchars($_SESSION['email']) ?> </p>
                        </div>
                    </div>
                    <p class="user-bio">Passionate backend developer skilled in PHP, MySQL, and secure coding. I
                        specialize in user authentication, dynamic content management, and troubleshooting.</p>

                </div>
                <div class="profile-nav">
                    <button id="activity-btn">
                        <i class='bx  bx-trending-up'></i> Activity
                    </button>
                    <button id="edit-profile-btn">
                        <i class='bx  bx-edit'></i> Edit profile
                    </button>
                    <button id="settings-btn">
                        <i class='bx  bx-cog'></i> Settings
                    </button>

                </div>
                <div class="user-settings" id="user-settings">
                    <div class="settings-grp edit-profile" id="edit-profile">
                        <h4>Edit Profile</h4>
                        <p>Username: <span> <?php echo htmlspecialchars($_SESSION['username']) ?> <i
                                    class='bx  bx-edit'></i></span> </p>
                        <p>Proffession: <span>Web Developer<i class='bx  bx-edit'></i> </span> </p>
                        <p>Bio: <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem quae
                                necessitatibus consequatur doloremque non vitae qui fugiat! <i class='bx  bx-edit'></i>
                            </span></p>
                        <p>Profile Picture: <span>Change <i class='bx  bx-edit'></i> </span> </p>
                    </div>
                    <div class="settings-grp account-settings" id="account-settings">
                        <h4>Account Settings</h4>
                        <p>Email: <span><?php echo htmlspecialchars($_SESSION['email']) ?> <i
                                    class='bx  bx-edit'></i></span> </p>
                        <p>Password : <span>**********<i class='bx  bx-edit'></i> </span> </p>
                        <p>Location: <span>Lilongwe<i class='bx  bx-edit'></i> </span> </p>
                        <p>Gender: <span>Male<i class='bx  bx-edit'></i> </span> </p>

                    </div>

                </div>
                <div class="user-activity" id="user-activity">
                    <!-- display all user's posts from database -->
                    <?php foreach ($userPosts as $post) : ?>
                    <div class="post">
                        <div class="post-header">
                            <a href="profile.php?user_id=<?php echo $post['author']['id']; ?>">
                                <div class="post-details">
                                    <img src="<?php echo htmlspecialchars($post['author']['profile_photo']); ?>"
                                        alt="<?php echo htmlspecialchars($post['author']['name']); ?>" loading="lazy"
                                        class="img" />
                                    <div class="post-author">

                                        <h4 class="pa-name"><?php echo htmlspecialchars($post['author']['name']); ?>
                                        </h4>

                                        <small>
                                            <!--<?php echo htmlspecialchars($post['author']['user_role']); ?> &bull;-->
                                            <?php echo format_time(strtotime($post['date'])); ?>
                                        </small>
                                    </div>
                                </div>
                            </a>
                            <!-- <div class="post-category" >
                                    <a href="">
                                        <span class="material-symbols-outlined"><?php echo htmlspecialchars($categoryIcon); ?></span> <?php echo htmlspecialchars($category); ?>
                                    </a>
                                </div> -->
                        </div>
                        <a href="post.php?post_id=<?php echo $post['post_id']; ?>" class="post-link">
                            <h3 class="post-title title sml"><?php echo $post['title']; ?></h3>
                            <p class="post-content">
                                <?php
                                    // Show truncated content on the feed
                                    $truncatedContent = substr($post['content'], 0, 150);
                                    $suffix = strlen($post['content']) > 150 ? '...<strong>more</strong>' : '';
                                    echo nl2br(htmlspecialchars($truncatedContent)) . $suffix;
                                    ?>
                            </p>

                            <?php if (!empty($post['media_url'])): ?>
                            <div class="post-image">
                                <img src="<?php echo htmlspecialchars($post['media_url']); ?>"
                                    alt="<?php echo htmlspecialchars($post['title']); ?>">
                            </div>


                            <?php endif; ?>
                        </a>
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
                                    <?php if ($post['comment_count'] > 0): ?>
                                    <span class="comment-count"><?php echo $post['comment_count']; ?></span>
                                    <?php endif; ?>
                                </li>
                                <li>
                                    <span class="material-symbols-outlined"> send</span>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <?php endforeach; ?>
                </div>




            </div>
            <div class="right-sidebar">
                <div class="card">
                    <h2 class="title sml"><span class="material-symbols-outlined">
                            mode_heat
                        </span>Today's top artist</h2>
                    <h4>OG Stakks</h4>
                    <img src="includes/images/stakks.jpg" alt="">
                </div>
                <div class="card">
                    <h2 class="title sml" style="font-size: 15px;"><span class="material-symbols-outlined"
                            style="font-size: 20px;">
                            ad
                        </span>Ad</h2>
                    <img src="includes/images/ad.jpeg" alt="">
                </div>
            </div>
        </div>

    </main>
    <script src="includes/js/modals.js"></script>
    <script src="includes/js/main.js"></script>
    <script src="includes/js/user.js"></script>
</body>

</html>