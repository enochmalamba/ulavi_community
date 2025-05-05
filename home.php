<?php
session_start();
require 'includes/config.php';
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
        $stmt = $conn->prepare("SELECT profile_photo, user_title FROM user_info WHERE user_id = ?");
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

            //then query for user_info table so as to get role and profile pict
            $profileInfoStmt = $conn->prepare("SELECT profile_photo, user_role FROM user_info WHERE user_id  = ?");
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
    <main>
        <div class="overlay" id="overlay"></div>


        <div class="header">
            <a href="home.php" class="title sml logo"> <i class='bx bxs-palette'></i> <span>ulavi <br> community</span></a>
            <h2 class="current-page title sml ">Home</h2>
            <form class="search-bar">
                <input type="text" name="query" placeholder="Search..">
                <button type="submit"><i class='bx bx-search'></i></button>
            </form>
        </div>
        <div class="container">
            <nav class="navigation">
                <ul class="page-nav">
                    <li><a href="" class="active"><i class='bx bxs-home-alt-2'></i>Home</a></li>
                    <li><a href=""><i class='bx bx-group'></i>Community</a></li>
                    <li><a href="create_post.php" class="post-link"><i class='bx bx-border-circle bx-plus'></i>Post</a></li>
                    <li><a href=""><i class='material-symbols-outlined'>person_play</i>Local talents</a></li>
                    <li><a href=""><i class='bx bx-menu-alt-left'></i>More</a></li>
                </ul>
                <ul class="user-nav">
                    <li id="uiSwitch"><i class="bx bx-sun"></i>Light mod</li>
                    <!-- <li><a href="">Light mode</a></li> -->
                    <li><a href=""><i class='bx bx-bell'></i>Notifications</a></li>

                    <li><a href="profile.php"><i class='bx bx-user'></i><?php echo htmlspecialchars($_SESSION['username']) ?></a></li>
                </ul>
            </nav>
            <div class="feed">
                <?php if (!empty($usersArray)):  ?>
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
                <?php endif;  ?>
                <?php if (!empty($postsArray)):  ?>
                    <?php foreach ($postsArray as $post): ?>
                        <div class="post">
                            <div class="post-header">
                                <div class="post-details">
                                    <img
                                        src="<?php echo htmlspecialchars($post['author']['profile_photo']); ?>"
                                        alt="<?php echo htmlspecialchars($post['author']['name']); ?>"
                                        loading="lazy"
                                        class="img" />
                                    <div class="post-author">
                                        <h4 class="pa-name"><?php echo htmlspecialchars($post['author']['name']); ?> </h4>
                                        <small><?php echo htmlspecialchars($post['author']['user_role']); ?> &bull; <?php echo htmlspecialchars($post['date']); ?></small>
                                    </div>
                                </div>
                                <div class="post-category">
                                    <a href="">
                                        <span class="material-symbols-outlined"><?php echo htmlspecialchars($categoryIcon); ?></span> <?php echo htmlspecialchars($category); ?>
                                    </a>
                                </div>
                            </div>
                            <a href="post.php?post_id=<?php echo $post['post_id']; ?>" class="post-link">
                                <h3 class="post-title title sml"><?php echo $post['title']; ?></h3>
                                <p class="post-content">
                                    <?php
                                    // Show truncated content on the feed
                                    $truncatedContent = substr($post['content'], 0, 350);
                                    $suffix = strlen($post['content']) > 350 ? '...<strong>more</strong>' : '';
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