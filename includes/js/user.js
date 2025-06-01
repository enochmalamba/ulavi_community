const userSettingsContainer = document.getElementById("user-settings");
const activtyContainer = document.getElementById("user-activity");
const editProfile = document.getElementById("edit-profile");
const accountSettings = document.getElementById("account-settings");
const activityBtn = document.getElementById("activity-btn");
const editProfileBtn = document.getElementById("edit-profile-btn");
const accountSettingsBtn = document.getElementById("account-settings-btn");

//initialize the current page as an empty string
let currentSection = "";

//get or set the current page with search params
function getCurrentSection() {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has("cs")) {
    // return urlParams.get("cs");
    const section = urlParams.get("cs");
    currentSection = section;
  } else {
    currentSection = "activity";
  }
  showSection();
}
//show the current page on window load
window.onload = () => {
  showSection();
};

function changeSection(page) {
  const url = new URL(window.location);
  url.searchParams.set("cs", page);
  window.history.replaceState({}, "", url);
  getCurrentSection();
}

//event listeners for the nav buttons
activityBtn.addEventListener("click", () => {
  changeSection("activity");
});
editProfileBtn.addEventListener("click", () => {
  changeSection("edit-profile");
});
accountSettingsBtn.addEventListener("click", () => {
  changeSection("account-settings");
});

function showSection() {
  //hide all pages
  activtyContainer.style.display = "none";
  editProfile.style.display = "none";
  accountSettings.style.display = "none";
  // show the currentSection
  switch (currentSection) {
    case "activity":
      activtyContainer.style.display = "flex";
      break;
    case "edit-profile":
      editProfile.style.display = "flex";
      break;
    case "account-settings":
      accountSettings.style.display = "flex";
      break;
  }
  //remove active class to all buttons
  activityBtn.classList.remove("active");
  editProfileBtn.classList.remove("active");
  accountSettingsBtn.classList.remove("active");
  //give active class to the right button
  switch (currentSection) {
    case "activity":
      activityBtn.classList.add("active");
      break;
    case "edit-profile":
      editProfileBtn.classList.add("active");
      break;
    case "account-settings":
      accountSettingsBtn.classList.add("active");
      break;
  }
}
