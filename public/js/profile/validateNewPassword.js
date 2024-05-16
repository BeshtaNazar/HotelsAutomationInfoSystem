const newPasswordInput = document.getElementById("newPassword");
const changePasswordForm = document.getElementById("changePasswordForm");
function validateNewPassword() {
    passwordError = document.getElementById("passwordError");
    if (newPasswordInput.value == "") {
        passwordError.innerText = "Please enter your password";
        newPasswordInput.style.borderColor = errorBorderColor;
    } else if (
        !/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{8,}$/.test(
            newPasswordInput.value
        )
    ) {
        passwordError.innerText = "Your password doesn't meet the requirements";
        newPasswordInput.style.borderColor = errorBorderColor;
    } else {
        passwordError.innerText = "";
        newPasswordInput.style.borderColor = inputsBorderColor;
    }
}
function validateFormData(e) {
    e.preventDefault();
    validateNewPassword();
    if (
        (passwordError =
            document.getElementById("passwordError").innerText != "")
    )
        return;
    else {
        changePasswordForm.submit();
    }
}
newPasswordInput.addEventListener("blur", validateNewPassword);
changePasswordForm.addEventListener("submit", validateFormData);
