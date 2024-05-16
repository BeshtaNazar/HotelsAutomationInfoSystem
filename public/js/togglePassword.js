const passwordInputElem = document.getElementById("password");
const togglePassword = document.querySelector(
    ".toggle-password-visibility-icon"
);
togglePassword.addEventListener("click", () => {
    togglePassword.classList.toggle("active");
    if (passwordInputElem.getAttribute("type") == "password") {
        passwordInputElem.setAttribute("type", "text");
    } else {
        passwordInputElem.setAttribute("type", "password");
    }
});
