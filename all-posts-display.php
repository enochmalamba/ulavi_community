<?php
session_start();
require_once 'includes/config.php';

// Fetch all posts and store in array
$postsArray = array();
$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($post = $result->fetch_assoc()) {
        // Get category icon
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

        // Get author information
        $userStmt = $conn->prepare("SELECT username FROM community_people WHERE user_id = ?");
        $userStmt->bind_param("i", $post['user_id']);
        $userStmt->execute();
        $userResult = $userStmt->get_result();

        if ($userResult->num_rows === 1) {
            $postAuthor = $userResult->fetch_assoc();

            // Get profile info
            $profileInfoStmt = $conn->prepare("SELECT profile_photo, user_role FROM user_profile WHERE user_id = ?");
            $profileInfoStmt->bind_param("i", $post['user_id']);
            $profileInfoStmt->execute();
            $profileInfoResult = $profileInfoStmt->get_result();

            if ($profileInfoResult->num_rows === 1) {
                $postAuthorInfo = $profileInfoResult->fetch_assoc();
            } else {
                $postAuthorInfo = [
                    'profile_photo' => '',
                    'user_role' => 'unknown'
                ];
            }
        } else {
            $postAuthor = [
                'username' => 'Unknown User'
            ];
            $postAuthorInfo = [
                'profile_photo' => '',
                'user_role' => 'unknown'
            ];
        }

        // Add everything to the post record
        $post['author_username'] = $postAuthor['username'];
        $post['author_role'] = $postAuthorInfo['user_role'];
        $post['author_photo'] = $postAuthorInfo['profile_photo'];
        $post['category_icon'] = $categoryIcon;

        // Get comment count
        $commentsStmt = $conn->prepare("SELECT COUNT(*) as comment_count FROM comments WHERE post_id = ?");
        $commentsStmt->bind_param('i', $post['post_id']);
        $commentsStmt->execute();
        $commentResult = $commentsStmt->get_result();
        $commentCount = $commentResult->fetch_assoc()['comment_count'];
        $post['comment_count'] = $commentCount;

        // Add to array
        $postsArray[] = $post;
    }
}

// Free result
$result->free();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material%20Symbols%20Outlined" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="includes/main.css">
    <link rel="stylesheet" href="includes/home.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Posts &bull; ULAVi Community</title>
</head>

<body>
    <main>
        <div class="overlay" id="overlay"></div>

        <div class="header">
            <a href="home.php" class="title sml logo"> <i class='bx bxs-palette'></i> <span>ulavi <br> community</span></a>
            <h2 class="current-page title sml ">All Posts</h2>
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
                    <li><a href="user/profile.php"><i class='bx bx-user'></i>Profile</a></li>
                </ul>
            </nav>
            <div class="feed">
                <?php if (!empty($postsArray)): ?>
                    <?php foreach ($postsArray as $post): ?>
                        <div class="post">
                            <div class="post-header">
                                <div class="post-details">
                                    <div class="img"></div>
                                    <div class="post-author">
                                        <h4 class="pa-name"><?php echo htmlspecialchars($post['author_username']); ?> </h4>
                                        <small><?php echo htmlspecialchars($post['author_role']); ?> &bull; <?php echo htmlspecialchars($post['created_at']); ?></small>
                                    </div>
                                </div>
                                <div class="post-category">
                                    <a href=""><span class="material-symbols-outlined"><?php echo htmlspecialchars($post['category_icon']); ?></span> <?php echo htmlspecialchars($post['category']); ?></a>
                                </div>
                            </div>
                            <a href="post.php?post_id=<?php echo $post['post_id']; ?>" class="post-link">
                                <h3 class="post-title title sml"><?php echo htmlspecialchars($post['title']); ?></h3>

                                <p class="post-content">
                                    <?php
                                    // Show truncated content on the feed
                                    echo nl2br(htmlspecialchars(substr($post['content'], 0, 200) . (strlen($post['content']) > 200 ? '...' : '')));
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
                        <h3>No posts found</h3>
                        <p>Be the first to create a post in the community!</p>
                        <a href="create_post.php" class="btn">Create Post</a>
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
</body>

</html>