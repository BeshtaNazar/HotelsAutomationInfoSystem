const burgerMenu = document.querySelector(".burger-menu");
const navbar = document.querySelector(".header-navbar");
burgerMenu.addEventListener("click", function () {
    this.classList.toggle("active");
    navbar.classList.toggle("open-menu");
});

window.addEventListener("resize", () => {
    if (window.innerWidth > 767.98) {
        burgerMenu.classList.remove("active");
        navbar.classList.remove("open-menu");
    }
});
