const overlay = document.getElementById("overlay");
const modalContainer = document.getElementById("modal-container");
const createPostBtn = document.getElementById("create-post-btn");
const lightModeBtns = document.querySelectorAll(".light-mode");
const darkModeBtns = document.querySelectorAll(".dark-mode");
const logoutBtn = document.getElementById("logout-btn");

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

// window.addEventListener("load", loadTheme);
loadTheme();

//start modal functionality
function openModal(modalGeneratorFn) {
  overlay.style.display = "flex";
  overlay.onclick = closeModals;
  const modal = modalGeneratorFn();
  modalContainer.innerHTML = modal;
  modalContainer.style.display = "flex";
  const cancelModalBtn = document.getElementById("cancel-modal-btn");
  cancelModalBtn.onclick = closeModals;
}

function closeModals() {
  overlay.style.display = "none";
  modalContainer.style.display = "none";
  modalContainer.innerHTML = "";
}

logoutBtn.onclick = () => {
  openModal(logOutModal);
};
