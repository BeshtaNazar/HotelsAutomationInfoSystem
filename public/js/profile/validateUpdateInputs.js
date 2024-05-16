const firstNameInput = document.getElementById("firstName");
const lastNameInput = document.getElementById("lastName");
const birthdayInput = document.getElementById("birthday");
const birthYearInput = document.getElementById("birthYear");
const phoneInput = document.getElementById("phone");
const emailInput = document.getElementById("email");
const countryInput = document.getElementById("country");
const updateInfoForm = document.getElementById("updateInfoForm");
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
function checkForSameData() {
    if (
        firstNameInput.value == firstNameInput.getAttribute("value") &&
        lastNameInput.value == lastNameInput.getAttribute("value") &&
        birthdayInput.value == birthdayInput.getAttribute("value") &&
        birthYearInput.value == birthYearInput.getAttribute("value") &&
        phoneInput.value == phoneInput.getAttribute("value") &&
        emailInput.value == emailInput.getAttribute("value")
    )
        return true;
    else return false;
}
function validateFormData(e) {
    e.preventDefault();
    validateFirstName();
    validateLastName();
    validateBirthday();
    validateBirthYear();
    validatePhone();
    validateEmail();
    const isSame = checkForSameData();
    if (isSame) {
        document.getElementById("formError").innerText =
            "Please enter information that differences from previous";
    } else {
        const formError = document.getElementById("formError");
        if (formError.innerText !== "") formError.innerText = "";
    }
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
    updateInfoForm.submit();
}
firstNameInput.addEventListener("blur", validateFirstName);
lastNameInput.addEventListener("blur", validateLastName);
birthdayInput.addEventListener("blur", validateBirthday);
birthdayInput.addEventListener("input", validateBirthdayRange);
birthYearInput.addEventListener("blur", validateBirthYear);
birthYearInput.addEventListener("input", validateBirthYearRange);
phoneInput.addEventListener("blur", validatePhone);
emailInput.addEventListener("blur", validateEmail);
updateInfoForm.addEventListener("submit", validateFormData);
