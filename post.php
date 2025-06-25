<?php
session_start();
require "includes/backend/config.php";
require_once "includes/backend/fetch_data.php";

if (isset($_GET["post_id"]) && is_numeric($_GET["post_id"])) {
  $postID = intval($_GET["post_id"]);
  //get the post from the post array using its id

  $post = null;
  foreach ($postsArray as $selected_post) {
    if ($selected_post["post_id"] == $postID) {
      $post = $selected_post;
      break; // Exit loop once found
    }
  }
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
    <link rel="stylesheet" href="includes/styles/post.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php if (isset($post) && $post !== null) {
          echo $post["title"] . htmlspecialchars("&bullet; ULAVi Community");
        } else {
          echo "404 - Post not found";
        } ?>
    </title>
</head>

<body>
    <main>
        <div class="overlay" id="overlay"></div>
        <div class="modal-container" id="modal-container"></div>

        <div class="header">
            <a href="home.php" class="title sml logo"> <i class='bx bxs-palette'></i> <span>ulavi <br>
                    community</span></a>
            <h2 class="current-page title sml ">Post</h2>
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
                            <div>Post</div>
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

                    <li><a href="user.php"><i class='bx bx-user'></i><?php echo htmlspecialchars(
                                  $_SESSION["username"],
                                ); ?></a></li>
                </ul>
            </nav>
            <div class="feed">


                <!-- show post if it exitsts -->
                <?php if ($post): ?>
                <div class="post">
                    <div class="post-header">
                        <a href="profile.php?user_id=<?php echo $post["author"][
                          "id"
                        ]; ?>">
                            <div class="post-details">
                                <img src="<?php echo htmlspecialchars(
                                  $post["author"]["profile_photo"],
                                ); ?>" alt="<?php echo htmlspecialchars(
                                      $post["author"]["name"],
                                    ); ?>" loading="lazy" class="img" />
                                <div class="post-author">

                                    <h4 class="pa-name"><?php echo htmlspecialchars(
                                      $post["author"]["name"],
                                    ); ?> </h4>

                                    <small>
                                        <!--<?php echo htmlspecialchars(
                                          $post["author"]["user_role"],
                                        ); ?> &bull;-->
                                        <?php echo format_time(
                                          strtotime($post["date"]),
                                        ); ?>
                                    </small>
                                </div>
                            </div>
                        </a>

                    </div>
                    <h3 class="post-title title sml"><?php echo $post[
                      "title"
                    ]; ?></h3>
                    <p class="post-content">
                        <?php echo htmlspecialchars($post["content"]); ?>
                    </p>

                    <?php if (!empty($post["media_url"])): ?>
                    <div class="post-image">
                        <img src="<?php echo htmlspecialchars(
                          $post["media_url"],
                        ); ?>" alt="<?php echo htmlspecialchars(
                              $post["title"],
                            ); ?>">
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
                                <?php if ($post["comment_count"] > 0): ?>
                                <span class="comment-count"><?php echo $post[
                                  "comment_count"
                                ]; ?></span>
                                <?php endif; ?>
                            </li>
                            <li>
                                <span class="material-symbols-outlined"> send</span>
                            </li>
                        </ul>
                    </div>

                </div>
                <form action="includes/backend/add_comment.php" class="comment_form" method="post">
                    <input type="hidden" name="post_id" value="<?php echo $post[
                      "post_id"
                    ]; ?>">
                    <input type="text" name="comment" placeholder="Add a comment">

                </form>

                <!-- show comments if they exist -->
                <?php if ($post["comment_count"] > 0): ?>
                <div class="comments">
                    <h2 class="title sml">Comments</h2>
                    <?php foreach ($post["comments"] as $comment): ?>
                    <div class="comment">

                        <a href="profile.php?user_id=<?php echo $comment[
                          "author"
                        ]["id"]; ?>"><img src="<?php echo htmlspecialchars(
                                  $comment["author"]["profile_photo"],
                                ); ?>" alt="User Profile Picture" class="comment-profile-pic" /></a>
                        <div class="comment-body">

                            <a href="profile.php?user_id=<?php echo $comment[
                              "author"
                            ]["id"]; ?>">
                                <h4 class="comment-author-name">
                                    <?php echo $comment["author"]["name"]; ?>
                                </h4>
                            </a>

                            <p class="comment-content"><?php echo $comment[
                              "content"
                            ]; ?></p>
                            <small><?php echo format_time(
                              strtotime($comment["created_at"]),
                            ); ?></small>
                        </div>



                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <!-- if there are no comments show message -->
                <div class="no-comment">
                    <center style='margin-top: 30px'>
                        <small>No comments available, be the first one to comment</small>
                    </center>
                </div>
                <?php endif; ?>
                <?php else: ?>
                <!-- if post doesnst extst show message -->

                <div class="post">
                    <h2 style="font-size: 60px; text-align: center;"> 404 <br> <span
                            style='font-size: 20px; font-weight: 300; '>Post not
                            found</span></h2>
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
                    <h2 class="title sml" style="font-size: 15px;"><span class="material-symbols-outlined"
                            style="font-size: 20px;">
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