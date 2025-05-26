<?php
session_start();
require 'includes/backend/fetch_data.php'

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
    <link rel="stylesheet" href="includes/styles/main.css">
    <link rel="stylesheet" href="includes/styles/home.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <main>
        <div class="overlay" id="overlay"></div>
        <div class="modal-container" id="modal-container"></div>

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
                    <img src="includes/images/stakks.jpg" alt="">
                </div>
                <div class="card">
                    <h2 class="title sml" style="font-size: 15px;"><span class="material-symbols-outlined" style="font-size: 20px;">
                            ad
                        </span>Ad</h2>
                    <img src="includes/images/ad.jpeg" alt="">
                </div>
            </div>
        </div>

    </main>
    <script src="includes/js/main.js"></script>
    <script src="includes/js/modals.js"></script>
</body>

</html>