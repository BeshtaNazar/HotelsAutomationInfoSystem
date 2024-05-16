const firstNameInput = document.getElementById("firstName");
const lastNameInput = document.getElementById("lastName");
const birthdayInput = document.getElementById("birthday");
const birthYearInput = document.getElementById("birthYear");
const phoneInput = document.getElementById("phone");
const emailInput = document.getElementById("email");
const countryInput = document.getElementById("country");
const passwordInput = document.getElementById("password");
const registerForm = document.getElementById("registerForm");
const inputsBorderColor = "#909090";
const errorBorderColor = "#ff0000";
function validateFirstName() {
    firstNameError = document.getElementById("firstNameError");
    if (firstNameInput.value == "") {
        firstNameError.innerText = "Please enter your first name";
        firstNameInput.style.borderColor = errorBorderColor;
    } else {
        firstNameError.innerText = "";
        firstNameInput.style.borderColor = inputsBorderColor;
    }
}
function validateLastName() {
    lastNameError = document.getElementById("lastNameError");
    if (lastNameInput.value == "") {
        lastNameError.innerText = "Please enter your last name";
        lastNameInput.style.borderColor = errorBorderColor;
    } else {
        lastNameError.innerText = "";
        lastNameInput.style.borderColor = inputsBorderColor;
    }
}
function validateBirthday() {
    birthdayError = document.getElementById("birthdayError");
    if (birthdayInput.value == "") {
        birthdayError.innerText = "Please enter your birthday";
        birthdayInput.style.borderColor = errorBorderColor;
    } else {
        birthdayError.innerText = "";
        birthdayInput.style.borderColor = inputsBorderColor;
    }
}
function validateBirthdayRange() {
    if (
        parseInt(birthdayInput.value, 10) >
        parseInt(birthdayInput.getAttribute("max"), 10)
    ) {
        birthdayInput.value = birthdayInput.getAttribute("max");
    }
    if (
        parseInt(birthdayInput.value, 10) <
        parseInt(birthdayInput.getAttribute("min"), 10)
    ) {
        birthdayInput.value = birthdayInput.getAttribute("min");
    }
}
function validateBirthYear() {
    birthYearError = document.getElementById("birthYearError");
    if (birthYearInput.value == "") {
        birthYearError.innerText = "Please enter your birth year";
        birthYearInput.style.borderColor = errorBorderColor;
    } else {
        birthYearError.innerText = "";
        birthYearInput.style.borderColor = inputsBorderColor;
    }
}
function validateBirthYearRange() {
    if (
        parseInt(birthYearInput.value, 10) >
        parseInt(birthYearInput.getAttribute("max"), 10)
    ) {
        birthYearInput.value = birthYearInput.getAttribute("max");
    }
    if (
        parseInt(birthYearInput.value, 10) <
        parseInt(birthYearInput.getAttribute("min"), 10)
    ) {
        birthYearInput.value = birthYearInput.getAttribute("min");
    }
}
function validatePhone() {
    phoneError = document.getElementById("phoneError");
    if (phoneInput.value == "") {
        phoneError.innerText = "Please enter your phone";
        phoneInput.style.borderColor = errorBorderColor;
    } else if (!/^\d+$/.test(phoneInput.value)) {
        phoneError.innerText = "Phone must contain only numbers";
        phoneInput.style.borderColor = errorBorderColor;
    } else {
        phoneError.innerText = "";
        phoneInput.style.borderColor = inputsBorderColor;
    }
}
function validateEmail() {
    emailError = document.getElementById("emailError");
    if (emailInput.value == "") {
        emailError.innerText = "Please enter your email";
        emailInput.style.borderColor = errorBorderColor;
    } else if (!/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/.test(emailInput.value)) {
        emailError.innerText = "Please enter valid email";
        emailInput.style.borderColor = errorBorderColor;
    } else {
        emailError.innerText = "";
        emailInput.style.borderColor = inputsBorderColor;
    }
}
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
    validateFirstName();
    validateLastName();
    validateBirthday();
    validateBirthYear();
    validatePhone();
    validateEmail();
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
    registerForm.submit();
}
firstNameInput.addEventListener("blur", validateFirstName);
lastNameInput.addEventListener("blur", validateLastName);
birthdayInput.addEventListener("blur", validateBirthday);
birthdayInput.addEventListener("input", validateBirthdayRange);
birthYearInput.addEventListener("blur", validateBirthYear);
birthYearInput.addEventListener("input", validateBirthYearRange);
phoneInput.addEventListener("blur", validatePhone);
emailInput.addEventListener("blur", validateEmail);
passwordInput.addEventListener("blur", validatePassword);
registerForm.addEventListener("submit", validateFormData);
