const textFormGenerator = (label, value, name, submitName) => {
  return `
  <form method="post">
    <label></label>
    <input type="text" name="${name}" placeholder="${label}" value="${value}" >
    <button id="cancel-modal-btn">Cancel</button>
    <button type="submit" name="${submitName}">Save</button>
  </form>
  `;
};

const bioForm = () => {
  return `
  <form>
    <textarea name="new_bio" ><?php echo htmlspecialchars($_SESSION['bio']); ?></textarea>
    <button id="cancel-modal-btn">Cancel</button>
    <button type="submit" name="update_bio">Save</button>
  </form>
  `;
};

const logOutModal = () => {
  return `
    <form class="modal-form" method="post" action="includes/backend/auth.php">
        <p>Are you sure you want to log out?</p>
        <input type="reset" value="Cancel" id="cancel-modal-btn"  name="reset_log_out">
        <input type="submit"  value="Log out" name="logout">
    </form>`;
};

const createPostModal = () => {
  `
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
            </div>`;
};
