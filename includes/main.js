const overlay = document.getElementById("overlay");
const createPostBtn = document.getElementById("create-post-btn");
const lightModeBtns = document.querySelectorAll(".light-mode");
const darkModeBtns = document.querySelectorAll(".dark-mode");
const menuContainer = document.getElementById("menu");
const menuBtn = document.getElementById("menu-btn");

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

// function openMenu() {
//   overlay.style.display = "flex";
//   // overlay.addEventListener("click", closeMenu);
// }

// function closeMenu() {
//   overlay.style.display = "none";
// }

// menuBtn.onclick = openMenu;
