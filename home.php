<?php
session_start();
require 'includes/config.php';
include_once 'includes/functions.php';

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: signin.php");
    exit();
}
//get users to show artists to follow 
$usersArray = array();
$usersSql = "SELECT * FROM community_people";
$usersResult = $conn->query($usersSql);

if ($usersResult->num_rows > 0) {
    while ($aUser = $usersResult->fetch_assoc()) {
        $user = array();
        $user['username'] = $aUser['username'];
        $user['user_id'] = $aUser['user_id'];

        //get the photo and the title of the user being displayed
        $stmt = $conn->prepare("SELECT profile_photo, user_title FROM user_profile WHERE user_id = ?");
        $stmt->bind_param("i", $aUser['user_id']);
        $stmt->execute();
        $theResult = $stmt->get_result();

        if ($theResult->num_rows === 1) {
            $userInfo = $theResult->fetch_assoc();
            $profilePic = $userInfo['profile_photo'];
            $userTitle =  $userInfo['user_title'];
        } else {
            $profilePic = "https://i.pinimg.com/736x/ae/25/58/ae25588122b4e9efaf260c6e1ea84641.jpg";
            $userTitle =  "Unkown";
        }

        $userData = [
            'name' => $aUser['username'],
            'id' => $aUser['user_id'],
            'profile_photo' => $profilePic,
            'user_title' => $userTitle
        ];

        $usersArray[] = $userData;
    }
}
//get posts from database to display on the feed
$postsArray = array();
$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($post = $result->fetch_assoc()) {
        $category = $post['category'];
        $categoryIcon = '';

        $category = $post['category'];
        $categoryIcon = '';

        switch ($category) {
            case "Community Development":
                $categoryIcon = "foundation";
                break;
            case "Artist Spotlight":
                $categoryIcon = "brush";
                break;
            case "Event":
                $categoryIcon = "calendar_month";
                break;
            case "Project Updates":
                $categoryIcon = "edit_arrow_up";
                break;
            default:
                $categoryIcon = "adaptive_audio_mic";
                break;
        }
        //get post author data
        //first query from the community_people table
        $userStmt = $conn->prepare("SELECT username, user_id FROM community_people WHERE user_id = ?");
        $userStmt->bind_param("i", $post['user_id']);
        $userStmt->execute();

        $userResult = $userStmt->get_result();
        if ($userResult->num_rows === 1) {
            $postAuthor = $userResult->fetch_assoc();

            //then query for user_profile table so as to get role and profile pict
            $profileInfoStmt = $conn->prepare("SELECT profile_photo, user_role FROM user_profile WHERE user_id  = ?");
            $profileInfoStmt->bind_param("i", $post['user_id']);
            $profileInfoStmt->execute();

            $profileInfoResult = $profileInfoStmt->get_result();
            if ($profileInfoResult->num_rows === 1) {
                $postAuthorInfo = $profileInfoResult->fetch_assoc();
            } else {
                $postAuthorInfo = [
                    'profile_photo' => 'https://i.pinimg.com/736x/ae/25/58/ae25588122b4e9efaf260c6e1ea84641.jpg',
                    'user_role' => 'Unknown'
                ];
            }
        } else {
            $postAuthor = [
                'username' => 'Unknown',
                'user_id' => NULL
            ];
        }
        $commentsStmt = $conn->prepare("SELECT COUNT(*) as comment_count FROM comments WHERE post_id = ?");
        $commentsStmt->bind_param('i', $post['post_id']);
        $commentsStmt->execute();
        $commentResult = $commentsStmt->get_result();
        $commentCount = $commentResult->fetch_assoc()['comment_count'];
        $post['comment_count'] = $commentCount;


        $postData = [
            'post_id' => $post['post_id'],
            'title' => $post['title'],
            'content' => $post['content'],
            'media_url' => $post['media_url'],
            'date' => $post['created_at'],
            'category' => $post['category'],
            'categoryIcon' => $categoryIcon,
            'author' => [
                'name' => $postAuthor['username'],
                'id' => $postAuthor['user_id'],
                'profile_photo' => $postAuthorInfo['profile_photo'],
                'user_role' => $postAuthorInfo['user_role']
            ],
            'comment_count' => $post['comment_count']

        ];


        $postsArray[] = $postData;
    }
}

$result->free();
$conn->close();



?>


<!DOCTYPE html>
<html lang="en">
<!-- to do: remove the console logging  -->
<script>
    const phpArray = <?php echo json_encode($postsArray); ?>;
    console.log('PHP Array:', phpArray);
</script>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material%20Symbols%20Outlined" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="includes/main.css">
    <link rel="stylesheet" href="includes/home.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <div class="log-out" style="display: none;">
        <form action="home.php" method="post">
            <button type="submit" name="logout">Log Out</button>
        </form>

    </div>
    <main>
        <div class="overlay" id="overlay">
            <div id="create_post" class="create_post">
                <form action="post_submit.php" method="post" enctype="multipart/form-data">
                    <label for="title">Enter post title <span>*</span></label>
                    <input type="text" name="title" id="title" placeholder="Write an attention-grabbing headline..." required>

                    <label for="content">Enter post content <span>*</span></label>
                    <textarea name="content" id="content" placeholder="Share your thoughts, ideas, or story in detail..." required></textarea>

                    <label for="post_image">Upload with an image (Optional)</label>
                    <input type="file" name="post_image" id="post_image" accept="image/*">
                    <div class="upload-img-preview">
                        <img src="" alt="Image preview" id="img-preview">
                        <span class="material-symbols-outlined" id="img-preview-close">
                            close
                        </span>
                    </div>
                    <div class="form-btns">
                        <button type="reset" id="cancel_post">Cancel</button>
                        <button type="submit" name="create_post">Publish Post</button>
                    </div>

                </form>
            </div>
        </div>


        <div class="header">
            <a href="home.php" class="title sml logo"> <i class='bx bxs-palette'></i> <span>ulavi <br> community</span></a>
            <h2 class="current-page title sml ">Home</h2>
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
                    <li><a href="" class="active"><i class='bx bxs-home-alt-2'></i>
                            <div>Home</div>
                        </a></li>
                    <li><a href=""><i class='bx bx-group'></i>
                            <div>Community</div>
                        </a></li>
                    <li><a href="create_post.php"><i class='bx  bx-plus'></i>
                            <div>Post</div>
                        </a></li>
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
                    <li><a href=""><i class='bx bx-log-out'></i>Log out</a></li>

                    <li><a href="user.php"><i class='bx bx-user'></i><?php echo htmlspecialchars($_SESSION['username']) ?></a></li>
                </ul>
            </nav>
            <div class="feed">
                <div class="create-post-btn" id="create-post-btn">
                    <h2 class="title sml" style="padding-left: 5px;">Create post</h2>
                    <p>Share your thoughts, ideas, or story...</p>
                </div>
                <!-- <?php if (!empty($usersArray)):  ?>
                    <h2 class="title sml">Profiles</h2>
                    <div class="feed-profiles-row">
                        <?php foreach ($usersArray as $profile):  ?>
                            <div class="feed-profile-card">
                                <div class="img">
                                    <img src="<?php echo htmlspecialchars($profile['profile_photo']); ?>" alt="<?php echo htmlspecialchars($profile['name']); ?>">
                                    <span class="material-symbols-outlined">person_check</span>
                                </div>
                                <a href="" class="title sml"><?php echo htmlspecialchars($profile['name']); ?></a>
                                <h4><?php echo htmlspecialchars($profile['user_title']); ?></h4>
                            </div>
                        <?php endforeach;  ?>
                    </div>
                <?php endif;  ?> -->
                <?php if (!empty($postsArray)):  ?>
                    <?php foreach ($postsArray as $post): ?>
                        <div class="post">
                            <div class="post-header">
                                <a href="profile.php?user_id=<?php echo $post['author']['id']; ?>">
                                    <div class="post-details">
                                        <img
                                            src="<?php echo htmlspecialchars($post['author']['profile_photo']); ?>"
                                            alt="<?php echo htmlspecialchars($post['author']['name']); ?>"
                                            loading="lazy"
                                            class="img" />
                                        <div class="post-author">

                                            <h4 class="pa-name"><?php echo htmlspecialchars($post['author']['name']); ?> </h4>

                                            <small><!--<?php echo htmlspecialchars($post['author']['user_role']); ?> &bull;--> <?php echo format_time(strtotime($post['date'])); ?></small>
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
                                        <img src="<?php echo htmlspecialchars($post['media_url']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
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
                <?php else: ?>
                    <div class="no-posts">
                        <h3 class="title lg">No posts found</h3>
                        <p>Be the first to create a post in the community!</p>
                        <a href="create_post.php" style="text-decoration: underline;">Create Post</a>
                    </div>
                <?php endif; ?>
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
    <script src="includes/main.js"></script>
</body>

</html>