const textFormGenerator = (label, value, name, submitName) => {
  return `
     <form action="includes/backend/account_edit.php" method="post" >
        <label>${label}</label>
        <input type="text" name="${name}" placeholder="${label}" value="${value}">
        <div class="btn-container">
            <button id="cancel-modal-btn">Cancel</button>
            <button type="submit" name="${submitName}">Save</button>
        </div>
    </form>
  `;
};

const bioForm = () => {
  return `
   <form action="includes/backend/account_edit.php" method="post">
        <label for="new_bio">Update bio</label>
        <textarea name="new_bio">${bio}</textarea>
        <div class="btn-container">
            <button id="cancel-modal-btn">Cancel</button>
            <button type="submit" name="update_bio">Save</button>
        </div>
    </form>
  `;
};

const changePasswordForm = () => {
  return `
 <form action="includes/backend/account_edit.php" method="post">
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
  `;
};

const emailForm = () => {
  return `
    <form action="includes/backend/account_edit.php" method="post">
        <label>New email</label>
        <input type="email" name="new_email" value="${email}" required />
        <div class="btn-container">
            <button id="cancel-modal-btn">Cancel</button>
            <button type="submit" name="update_email">Save</button>
        </div>
    </form>
  `;
};

const profilePicForm = () => {
  return `
 <form action="includes/backend/account_edit.php" method="post" enctype="multipart/form-data">
        <label>Upload new profile picture</label>
        <input type="file" accept="image/*" name="profile_photo" id="profile_photo" required />
        <img src="${profile_photo}" alt="Image preview" id="img-preview" style="max-width: 200px; max-height: 200px;">
        <div class="btn-container">
            <button id="cancel-modal-btn">Cancel</button>
            <button type="submit" name="update_profile_pic">Save</button>
        </div>
    </form>
  `;
};

const genderForm = () => {
  return `
  <form action="includes/backend/account_edit.php" method="post">
    <label>Change your identity</label>
    <select name="gender" id="gender" required>
        <option disabled selected value>--Select your identity--</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
        <option value="Hidden">Prefer not to say</option>
     </select>
    <button id="cancel-modal-btn">Cancel</button>
    <button type="submit" name="update_gender">Save</button>
  </form>
  `;
};

const logOutModal = () => {
  return `
    <form class="modal-form" method="post" action="includes/backend/auth.php">
        <p>Are you sure you want to log out?</p>
        <input type="reset" value="Cancel" id="cancel-modal-btn" name="reset_log_out">
        <input type="submit" value="Log out" name="logout">
    </form>`;
};

const createPostModal = () => {
  return `
   
        <form action="includes/backend/post_submit.php" method="post" enctype="multipart/form-data">
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
                <button type="reset" id="cancel_modal_btn">Cancel</button>
                <button type="submit" name="create_post">Publish Post</button>
            </div>
        </form>
    `;
};
