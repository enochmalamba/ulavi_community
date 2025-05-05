const uiSwitch = document.getElementById("uiSwitch");

function toggleDarkMode() {
  document.body.classList.toggle("dark-theme");
  const isDarkMode = document.body.classList.contains("dark-theme");
  localStorage.setItem("darkMode", isDarkMode);
  uiSwitch.innerHTML = isDarkMode ? "Light Mode" : "Dark Mode";
}

function loadDarkMode() {
  const isDarkMode = localStorage.getItem("darkMode") === "true";
  if (isDarkMode) {
    document.body.classList.add("dark-theme");
  } else {
    document.body.classList.remove("dark-theme");
  }
  uiSwitch.innerHTML = isDarkMode ? "Light Mode" : "Dark Mode";
}
// Load dark mode preference on page load
// loadDarkMode();
// Add event listener to the switch button
uiSwitch.addEventListener("click", toggleDarkMode);
