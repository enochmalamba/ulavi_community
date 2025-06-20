<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="includes/styles/main.css">
    <link rel="stylesheet" href="includes/styles/home.css">
    <!-- <link rel="stylesheet" href="includes/styles/user_info.css"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modals style test page</title>
    <style>
    body {
        max-width: 1000px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 39px;
        padding: 40px 0;
    }

    form {
        width: min(400px, 90%);
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    label {
        font-size: 17px;
        font-weight: 400;
        color: var(--font);
    }

    input,
    select,
    textarea {
        font-size: 16px;
        width: 100%;
        padding: 7px;
        outline: none;
        border: 1px solid var(--accent);
        border-radius: 5px;
        color: var(--font);
        background: none;
    }

    .btn-container {
        display: flex;
        align-items: center;
        /* justify-content: flex-end; */
        gap: 5px;
    }

    .btn-container button {
        padding: 5px 10px;
        border: 1px solid var(--accent);
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 400;
        color: var(--font);
        background: none;
    }
    </style>
</head>

<body>
    <form method="post">
        <label>${label}</label>
        <input type="text" name="${name}" placeholder="${label}" value="${value}">
        <div class="btn-container">
            <button id="cancel-modal-btn">Cancel</button>
            <button type="submit" name="${submitName}">Save</button>
        </div>
    </form>
    <form method="post">
        <label for="new_bio">Update bio</label>
        <textarea name="new_bio">${bio}</textarea>
        <div class="btn-container">
            <button id="cancel-modal-btn">Cancel</button>
            <button type="submit" name="update_bio">Save</button>
        </div>
    </form>
    <form method="post">
        <label>Old password</label>
        <input type="password" name="old_password" required />
        <label>New password</label>
        <input type="password" name="new_password" required />
        <label>Confirm password</label>
        <input type="password" name="confirm_password" required />
        <div class="btn-container">
            <button id="cancel-modal-btn">Cancel</button>
            <button type="submit" name="update_password">Save</button>
        </div>

    </form>
    <form method="post">
        <label>New email</label>
        <input type="email" name="new_email" value="${email}" required />
        <div class="btn-container">
            <button id="cancel-modal-btn">Cancel</button>
            <button type="submit" name="update_email">Save</button>
        </div>
    </form>
    <form method="post" enctype="multipart/form-data">
        <label>Upload new profile picture</label>
        <input type="file" accept="image/*" name="profile_photo" id="profile_photo" required />
        <img src="${profile_photo}" alt="Image preview" id="img-preview" style="max-width: 200px; max-height: 200px;">
        <div class="btn-container">
            <button id="cancel-modal-btn">Cancel</button>
            <button type="submit" name="update_profile_pic">Save</button>
        </div>
    </form>
    <form method="post">
        <label>Change your identity</label>
        <select name="gender" id="gender" required>
            <option disabled selected value>--Select your identity--</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
            <option value="Hidden">Prefer not to say</option>
        </select>
        <div class="btn-container">
            <button id="cancel-modal-btn">Cancel</button>
            <button type="submit" name="update_gender">Save</button>
        </div>

    </form>
    <form class="modal-form" method="post" action="includes/backend/auth.php">
        <label>Are you sure you want to log out?</label>
        <div class="btn-container">
            <button id="cancel-modal-btn">Cancel</button>
            <button type="submit" name="logout"> Log out </button>
        </div>

    </form>
    <div id="create_post" class="create_post">
        <form action="post_submit.php" method="post" enctype="multipart/form-data">
            <label for="title">Enter post title <span>*</span></label>
            <input type="text" name="title" id="title" placeholder="Write an attention-grabbing headline..." required>

            <label for="content">Enter post content <span>*</span></label>
            <textarea name="content" id="content" placeholder="Share your thoughts, ideas, or story in detail..."
                required></textarea>

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
</body>

</html>