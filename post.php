<?php
session_start();
require 'includes/config.php';

if (isset($_GET['post_id']) && is_numeric($_GET['post_id'])) {
    $postID = intval($_GET['post_id']);


    $stmt = $conn->prepare("SELECT user_id, title, content, media_url, category, created_at FROM posts WHERE post_id = ?");
    $stmt->bind_param("i", $postID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $post = $result->fetch_assoc();


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
    } else {
        echo "<h1 class='title lg'>404</h1>Post not found";
    }

    //get post author data
    $userStmt = $conn->prepare("SELECT username FROM community_people WHERE user_id = ?");
    $userStmt->bind_param("i", $post['user_id']);
    $userStmt->execute();

    $userResult = $userStmt->get_result();
    if ($userResult->num_rows === 1) {
        $postAuthor = $userResult->fetch_assoc();
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
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style>
        form {
            display: flex;
            flex-direction: column;
            width: 100%;
            gap: 10px;
        }

        form label {
            font-size: 16px;
            font-weight: 600;
        }

        form label span {
            color: red;
        }

        form input:not([type="submit"]),
        form textarea {
            font-size: 16px;
            width: 100%;
            padding: 5px;
            border: none;
            outline: none;
            border-bottom: 1px solid var(--accent);
            color: var(--font);
            background: none;
        }

        form textarea {
            field-sizing: content;
            max-height: 200px;
        }

        form input:not([type="submit"]):focus,
        form textarea:focus {
            outline: 0;
        }
    </style>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material%20Symbols%20Outlined" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="includes/main.css">
    <link rel="stylesheet" href="includes/home.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> &bull; ULAVi Community</title>
</head>

<body>
    <main>
        <div class="overlay" id="overlay"></div>


        <div class="header">
            <a href="home.php" class="title sml logo"> <i class='bx bxs-palette'></i> <span>ulavi <br> community</span></a>
            <h2 class="current-page title sml ">Post</h2>
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
                <div class="post">
                    <div class="post-header">
                        <div class="post-details">
                            <div class="img"></div>

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
                </div>
                <div class="comments-container">
                    <form action="includes/backend/add_comment.php" method="post">
                        <input type="hidden" name="postID" value="<?php echo htmlspecialchars($postID); ?>"> <textarea name="comment" id="comment" required placeholder="Add comment"></textarea>
                        <div class="form-btns">
                            <button type="submit" name="submit_comment">Comment</button>
                        </div>
                    </form>
                    <?php
                    $commentsStmt = $conn->prepare("SELECT  content, created_at FROM comments WHERE post_id = ?");
                    $commentsStmt->bind_param('i', $postID);
                    $commentsStmt->execute();
                    $cntResult = $commentsStmt->get_result();
                    if ($cntResult->num_rows > 0) {
                        while ($allComments = $cntResult->fetch_assoc()) {
                            echo " Comment:  " . $allComments['content']  . "<br> Posted at: " . $allComments['created_at'] . "<hr>";
                        }
                    };
                    ?>
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