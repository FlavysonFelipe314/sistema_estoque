let menuTrigger = document.getElementById("menu-trigger")
let closeTrigger = document.getElementById("close-trigger")
let menuContent = document.getElementById("menu-content")
let systemContent = document.getElementById("system-content")

menuTrigger.addEventListener("click", () => {
    if(menuContent.classList.contains("slide-menu")){
        menuContent.classList.remove("slide-menu")
        systemContent.classList.remove("slide-system")
    } else{
        menuContent.classList.add("slide-menu")
        systemContent.classList.add("slide-system")
    }
})

closeTrigger.addEventListener("click", () => {
    menuContent.classList.remove("slide-menu")
})