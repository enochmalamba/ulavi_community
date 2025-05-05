<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php"); // Redirect to login page if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material%20Symbols%20Outlined" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="includes/main.css">
    <link rel="stylesheet" href="includes/create_post.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post &bull; ULAVi Community</title>
</head>

<body>
    <main>
        <div class="overlay" id="overlay"></div>


        <div class="header">
            <a href="home.php" class="title sml logo"> <i class='bx bxs-palette'></i> <span>ulavi <br> community</span></a>
            <h2 class="current-page title sml ">Create a post</h2>
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
                    <li><a href="" class="post-link  active"><i class='bx bx-border-circle bx-plus'></i>Post</a></li>
                    <li><a href=""><i class='material-symbols-outlined'>person_play</i>Local talents</a></li>
                    <li><a href=""><i class='bx bx-menu-alt-left'></i>More</a></li>
                </ul>
                <ul class="user-nav">
                    <li><a href=""><i class="bx bx-sun"></i>Light mode</a></li>
                    <li><a href=""><i class='bx bx-bell'></i>Notifications</a></li>

                    <li><a href="user/profile.php"><i class='bx bx-user'></i>Profile</a></li>
                </ul>
            </nav>
            <div class="feed">
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
                        <button type="reset">Cancel</button>
                        <button type="submit" name="create_post">Publish Post</button>
                    </div>

                </form>
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
    <script>
        const previewContainer = document.querySelector('.upload-img-preview');
        const imgInput = document.getElementById('post_image');
        const imgPreview = document.getElementById('img-preview');
        const imgPreviewClose = document.getElementById('img-preview-close');

        previewContainer.style.display = 'none';
        imgInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imgPreview.src = e.target.result;
                    imgPreview.style.display = 'block';
                    imgPreviewClose.style.display = 'block';
                    previewContainer.style.display = 'flex';
                }
                reader.readAsDataURL(file);
            }
        });

        imgPreviewClose.addEventListener('click', function() {
            imgPreview.src = '';
            imgPreview.style.display = 'none';
            imgPreviewClose.style.display = 'none';
            previewContainer.style.display = 'none';
            imgInput.value = '';
        });
    </script>
</body>

</html>