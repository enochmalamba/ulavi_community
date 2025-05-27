<?php
session_start();
// require 'includes/backend/fetch_data.php'
$profilePhoto = 'https://i.pinimg.com/736x/59/28/63/592863045173070313c50f1dd9b5ff78.jpg';
$username = $_SESSION['username'];
$title = 'ULV Memmber';

$bio = 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Commodi cupiditate est explicabo voluptas laborum dolore veniam, eum facere earum, autem possimus assumenda ipsum deleniti laboriosam doloribus non ea quis aliquam?'
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
    <link rel="stylesheet" href="includes/styles/profile.css">
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
                <div class="profile-view">
                    <div class="profile-header">
                        <img src="<?php echo htmlspecialchars($profilePhoto); ?>" alt="<?php echo htmlspecialchars($username); ?>" class="profile-img" style="display: none;">
                        <div class="profile-details">
                            <img src="<?php echo htmlspecialchars($profilePhoto); ?>" alt="<?php echo htmlspecialchars($username); ?>">
                            <h3 class="title sml"><?php echo htmlspecialchars($username); ?></h3>
                            <p><?php echo htmlspecialchars($title); ?></p>
                            <p class="bio"><?php echo htmlspecialchars($bio); ?></p>
                        </div>
                    </div>

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