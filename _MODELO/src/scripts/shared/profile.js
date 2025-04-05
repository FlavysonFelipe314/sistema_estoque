let profileTrigger = document.getElementById("profile-trigger");
let profileContent = document.querySelector(".profile-content");
let closeProfile = document.getElementById("close-profile")

profileTrigger.addEventListener("click", () => {
    profileContent.classList.add("profile-slide")
})

closeProfile.addEventListener("click", () => {
    profileContent.classList.remove("profile-slide")
})