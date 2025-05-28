<?php
session_start();
require 'includes/backend/fetch_data.php';
//fake profile pic for now
$profilePic = "https://i.pinimg.com/736x/ae/25/58/ae25588122b4e9efaf260c6e1ea84641.jpg";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material%20Symbols%20Outlined" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="includes/styles/main.css">
    <link rel="stylesheet" href="includes/styles/home.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($_SESSION['username']) ?> | Profile</title>
</head>

<body>
    <main>
        <div class="overlay" id="overlay"></div>
        <div class="modal-container" id="modal-container"></div>

        <div class="header">
            <a href="home.php" class="title sml logo"> <i class='bx bxs-palette'></i> <span>ulavi <br> community</span></a>
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
                    <li><a href="" ><i class='bx bxs-home-alt-2'></i>
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

                    <li><a href="user.php" class="active"><i class='bx bx-user'></i><?php echo htmlspecialchars($_SESSION['username']) ?></a></li>
                </ul>
            </nav>
        <div class="feed">
            <div class="profile">
                    <img src="<?php echo $profilePic ?>" alt="<?php echo htmlspecialchars($_SESSION['username']) ?>">
                    <h2 class="title sml"> <?php echo htmlspecialchars($_SESSION['username']) ?> </h2>
                    <h4> <?php echo htmlspecialchars($_SESSION['email']) ?> </h4>      
                        <button><i class='bx  bx-edit'></i>  Edit Profile</button>
                </div>
            <div class="profile-nav">
                <button>Activity</button>
          
                <button>Settings</button>
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