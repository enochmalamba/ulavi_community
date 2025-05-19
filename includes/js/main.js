const overlay = document.getElementById("overlay");
const createPostBtn = document.getElementById("create-post-btn");
const lightModeBtns = document.querySelectorAll(".light-mode");
const darkModeBtns = document.querySelectorAll(".dark-mode");
const menuContainer = document.getElementById("menu");
const menuBtn = document.getElementById("menu-btn");

const previewContainer = document.querySelector(".upload-img-preview");
const imgInput = document.getElementById("post_image");
const imgPreview = document.getElementById("img-preview");
const imgPreviewClose = document.getElementById("img-preview-close");
const cancelPostBtn = document.getElementById("cancel_post");

lightModeBtns.forEach((btn) => {
  btn.addEventListener("click", toggleLightMode);
});

darkModeBtns.forEach((btn) => {
  btn.addEventListener("click", toggleDarkMode);
});

function toggleLightMode() {
  localStorage.setItem("theme", "light");
  loadTheme();
}

function toggleDarkMode() {
  localStorage.setItem("theme", "dark");
  loadTheme();
}

function loadTheme() {
  const theme = localStorage.getItem("theme");
  if (theme === "dark") {
    document.body.classList.add("dark-theme");
  } else {
    document.body.classList.remove("dark-theme");
  }
  changeUIicon(theme);
}

function changeUIicon(theme) {
  if (theme === "dark") {
    darkModeBtns.forEach((btn) => {
      btn.style.display = "none";
    });
    lightModeBtns.forEach((btn) => {
      btn.style.display = "flex";
    });
  } else {
    darkModeBtns.forEach((btn) => {
      btn.style.display = "flex";
    });
    lightModeBtns.forEach((btn) => {
      btn.style.display = "none";
    });
  }
}

window.addEventListener("load", loadTheme);

createPostBtn.addEventListener("click", () => {
  overlay.style.display = "flex";
});
cancelPostBtn.addEventListener("click", () => {
  overlay.style.display = "none";
  imgPreview.src = "";
  imgPreview.style.display = "none";
  imgPreviewClose.style.display = "none";
  previewContainer.style.display = "none";
  imgInput.value = "";
});

// function openMenu() {
//   overlay.style.display = "flex";
//   // overlay.addEventListener("click", closeMenu);
// }

// function closeMenu() {
//   overlay.style.display = "none";
// }

// menuBtn.onclick = openMenu;

previewContainer.style.display = "none";
imgInput.addEventListener("change", function () {
  const file = this.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      imgPreview.src = e.target.result;
      imgPreview.style.display = "block";
      imgPreviewClose.style.display = "block";
      previewContainer.style.display = "flex";
    };
    reader.readAsDataURL(file);
  }
});

imgPreviewClose.addEventListener("click", function () {
  imgPreview.src = "";
  imgPreview.style.display = "none";
  imgPreviewClose.style.display = "none";
  previewContainer.style.display = "none";
  imgInput.value = "";
});
