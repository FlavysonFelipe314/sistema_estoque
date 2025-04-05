let modal = document.querySelector(".modal");
let activeModal = document.getElementById("active-modal");
let closeModal = document.getElementById("close-modal");

activeModal.addEventListener("click", () => {
    modal.classList.add("slide-modal")
})

closeModal.addEventListener("click", () => {
    modal.classList.remove("slide-modal")
})
