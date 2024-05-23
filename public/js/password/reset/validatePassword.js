const passwordInput = document.getElementById("password");
const resetPasswordForm = document.getElementById("resetPasswordForm");
const inputsBorderColor = "#909090";
const errorBorderColor = "#ff0000";
function validatePassword() {
    passwordError = document.getElementById("passwordError");
    if (passwordInput.value == "") {
        passwordError.innerText = "Please enter your password";
        passwordInput.style.borderColor = errorBorderColor;
    } else if (
        !/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{8,}$/.test(
            passwordInput.value
        )
    ) {
        passwordError.innerText = "Your password doesn't meet the requirements";
        passwordInput.style.borderColor = errorBorderColor;
    } else {
        passwordError.innerText = "";
        passwordInput.style.borderColor = inputsBorderColor;
    }
}
function validateFormData(e) {
    e.preventDefault();
    validatePassword();
    let isRight = true;
    const errors = document.querySelectorAll(".error-message");
    for (const error of errors) {
        if (!error.innerText == "") {
            error.parentElement.scrollIntoView({
                behavior: "smooth",
                block: "nearest",
            });
            isRight = false;
            break;
        }
    }
    if (!isRight) return;
    resetPasswordForm.submit();
}
passwordInput.addEventListener("blur", validatePassword);
resetPasswordForm.addEventListener("submit", validateFormData);
