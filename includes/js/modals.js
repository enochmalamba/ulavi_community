let formHTML = "";
const formGenerator = (label, inputName, type, value) => {
  formHTML = `
    <div class="form-group">
        <label for="${inputName}">${label}</label>
        <input type="${type}" class="form-control" id="${inputName}" name="${inputName}" value="${value}">
        <input type="reset" value="Cancel"  name="reset_${inputName}">
        <input type="submit"  value="Submit" name="edit_${inputName}">
    </div>`;
  document.getElementById("form").innerHTML = formHTML;
};

const textareaGenerator = (label, inputName, value) => {
  formHTML = `
    <div class="form-group">
        <label for="${inputName}">${label}</label>
        <textarea class="form-control" id="${inputName}" name="${inputName}">${value}</textarea>
        <input type="reset" value="Cancel"  name="reset_${inputName}">
        <input type="submit"  value="Submit" name="edit_${inputName}">
    </div>`;
  document.getElementById("form").innerHTML = formHTML;
};

const profilePhotoUpload = () => {
  formHTML = `
    <div class="form-group">
        <label for="profile_photo">Upload Profile Photo</label>
        <input type="file" class="form-control" id="profile_photo" name="profile_photo">
        <input type="reset" value="Cancel"  name="reset_profile_photo">
        <input type="submit"  value="Upload" name="upload_profile_photo">
    </div>`;
  document.getElementById("form").innerHTML = formHTML;
};

const logOutModal = () => {
  formHTML = `
    <div class="form-group">
        <p>Are you sure you want to log out?</p>
        <input type="reset" value="Cancel"  name="reset_log_out">
        <input type="submit"  value="Log out" name="log_out">
    </div>`;
  // document.getElementById("form").innerHTML = formHTML;
  return formHTML;
};

const createPostModal = () => {
  formHTML = `
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
  overlay.innerHTML = formHTML;
};
